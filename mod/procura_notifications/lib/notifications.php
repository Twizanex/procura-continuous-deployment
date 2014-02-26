<?php

/**
 * Crea el camino de migas de pan en función de los parámetros enviados en la URL, y sin machacar migas que tubiese previamente
 * @param type $page Array de parámetros que se envían en la URL
 */
function procura_notifications_handle_breadcrum ($page){
/*
 * Ejemplo: elgg_push_breadcrumb(elgg_echo('procura:notificaciones'), "notifications/all"); //Miga de pan a todas las notificaciones
 * elgg_push_breadcrumb($title, $link = NULL); //'title' y 'link' son los nombres de los 2 campos del array que devuelve cada miga
 * elgg_pop_breadcrumb(); //Elimina la última
 * elgg_get_breadcrumbs();
 */    
    //Si entramos aquí, estamos seguros de que hay:
    //page[0]=nombre_de_un_usuario
    
    $last_link = "notifications/".$page[0];
    if (get_loggedin_user()->username == $page[0]){
        $last_title = "procura_notifications:own";
    } else{
        $last_title = "procura_notifications:other";
    }
    
    $encontrado = 0;
    $breadcrums = elgg_get_breadcrumbs();
    $breadcrums = array_reverse($breadcrums);//tomar los elementos desde el final hasta el principio
    foreach ($breadcrums as $breadcrum){
        if ($encontrado == 0){ //Una vez se ha encontrado la miga de pan, no continuar
            //Estas son las 2 migas de pan que se reconocen como propiedad de este módulo
            if (($breadcrum->title != "procura_notifications:own") || 
                ($breadcrum->title != "procura_notifications:other")){
                elgg_pop_breadcrumb();
            } else{
                $encontrado = 1;
            }
        }
    }
    if ($encontrado == 0){
        elgg_push_breadcrumb(elgg_echo("procura:home"), elgg_get_site_url());//Si encontrado = 0 -> Se han eliminado TODAS las breadcrumb -> Meter la breadcrum de HOME
        elgg_push_breadcrumb(elgg_echo("procura_notifications"), 'notifications/');//Si encontrado = 0 -> Se han eliminado TODAS las breadcrumb -> Meter la breadcrum de página principal de notificaciones (las del usuario logueado)
        elgg_push_breadcrumb(elgg_echo($last_title, array($page[0])), $last_link);
    }
}



/**
 * Devuelve la lista de notificaciones que se han asignado al usuario
 * 
 * @param String $username Nombre de usuario del usuario del que queremos obtener las notificaciones.
 * @return Array Lista de entidades de tipo 'notification'.
 */
function procura_notifications_get_notification_list($username, $orden){    
    $id_usuario = get_user_by_username($username)->guid;
    $notificaciones_devueltas = array ();

    $valores_ordenacion = split('_', $orden);

    $order_by = $valores_ordenacion[0];//nivel o fecha
    $orden_order_by = $valores_ordenacion[1];//ASC ó DESC
    
    if ($order_by == 'nivel'){
        $order_by = 'priority'; //el metadata 'nivel' en realidad se llama 'priority' en la base de datos
        $options = array (
            'type' => 'object',
            'subtype' => 'notification',
            'limit' => 20,
            'metadata_name' => $order_by,
            //'metadata_name' => 'priority',
            'order_by_metadata' => array(
                'name' => $order_by,
                'direction' => $orden_order_by,
                //'name' => 'priority',
                //'direction' => 'DESC',
                'as' => integer
            ),
        );
    
        $notificaciones = elgg_get_entities_from_metadata($options);
    }
    else //if ($order_by == 'fecha') // <- por defecto, si no se ordena por nivel, se ordena por fecha
    {
        $order_by = 'time_created'; //el dato 'fecha' en realidad se llama 'time_created', y NO es un metadato creado por mi
        
        $options = array (
            'type' => 'object',
            'subtype' => 'notification',
            'limit' => 20,
            'order_by' => $order_by . ' ' . $orden_order_by,
        );
        
        $notificaciones = elgg_get_entities($options);
    }    
    //var_dump ($notificaciones);
    
    foreach ($notificaciones as $notificacion) {
        //Las personas a las que les llega la notificacion se guardan (su guid)
        // como anotación!!!! El destinatario original incluido.
        $anotaciones = $notificacion->getAnnotations('notification');
        foreach ($anotaciones as $anotacion) {
            if ($anotacion->owner_guid == $id_usuario){
                $notificaciones_devueltas[] = $notificacion;
            }
        }
    }
    return $notificaciones_devueltas;
}



/**
 * Función llamada desde otros módulos para enviarle una notificación a un usuario y a todos los que también tengan que estar enterados.
 * Como enviar una notificación es una acción de la plataforma (NUNCA de un usuario), esta acción no se lanza desde un formulario, y por tanto, no está en la carpeta 'actions'
 * 
 * @param type $texto Texto de la notificación. Admite etiquetado HTML
 * @param type $origen Username del usuario que ha generado la notificación, en caso de existir
 * @param type $destinatario Username del usuario al que va dirigida la notificación
 * @param type $prioridad Entero de 1 a 3 que indica la prioridad de la notificación, siendo 1 la de menor importancia
 */
function procura_notifications_send_notification($texto, $origen, $destinatario, $prioridad = 1){

//1º: Crear la entidad 'notification' y guardarla
    $notificacion = new ProcuraNotification();
    $notificacion->access_id = ACCESS_PUBLIC;
    $notificacion->title = $origen;
    $notificacion->description = $texto;
    //$notificacion->time_created = ¿?; //Supongo que esto se guarda automáticamente
    $notificacion->priority = $prioridad;
    
    $succed = true;
    if (!$notificacion->save()){
        register_error(elgg_echo ("notificaciones:crear_notificacion:error"));
        $succed = false;
    }

//2º: saber a quien debe enviársele.
    $origen_id = get_user_by_username($origen)->guid;
    $destinatario_id = get_user_by_username($destinatario)->guid;
    $destinatarios = procura_notifications_get_destinations($destinatario_id);
//    system_message("los destinatarios son en total: ");
  
//3º: Poner como annotation a quien envía la notificación, pero ésta ya estará 'leida'
    //Al final no se pone esta notificación. El usuario ya sabe lo que ha hecho
    //$notificacion->annotate("notification", 0, ACCESS_PUBLIC, $origen_id);
    
//4º: Poner como annotation de la entity a los usuarios a quien debe enviarse.
    //Tras este proceso, el $destinatario es el ID de la última annotation
    foreach ($destinatarios as $dest){
        $notificacion->annotate("notification", 0, ACCESS_PUBLIC, $dest);
    }
    

 
}


/**
 * 
 * Función para saber a qué usuarios hay que enviar la notificación, cuando se envía a uno en particular.
 * Esa decisión es tarea del administrador, en función de los perfiles y relaciones definidos.
 * @param int $destinatario_id GUID del destinatario principal de la notificación
 * @return array Conjunto de guids de los usuarios destinatarios
 */
function procura_notifications_get_destinations($destinatario_id){
    $user = get_user($destinatario_id);
    $tipo_perfil = prp_get_user_profile_type($user);
    
    //obtener el perfil como una entidad:
    $options = array(
            'type' => 'object',
            'subtype' => 'custom_profile_type',
            'metadata_value' => $tipo_perfil,
        );
    $perfiles = elgg_get_entities_from_metadata($options);
    $guid_perfil = $perfiles[0]->guid;//Sólo habrá 1 entidad de tipo perfil con ese valor ('paciente', 'cuidador', etc)
    
    $relaciones_notificadas = procura_notifications_get_relationships_destinations($guid_perfil);
    $destinatarios = array ();
    
    // Obtner los nombres de las relaciones notificadas, porque es con lo que trabaja el prp_get_user_relations
    $nombres_relaciones_notificadas = array ();
    foreach ($relaciones_notificadas as $id_relacion_notificada){
        $nombres_relaciones_notificadas[] = get_entity($id_relacion_notificada)->title;
    }
    
    //Buscar todos los usuarios que tengan el tipo de relación 
    //$relaciones_notificadas con rescpecto al $destinatario_id
    $relaciones_usuario = prp_get_user_relations($user);
    foreach ($relaciones_usuario as $usuario_relacion){
        if (in_array($usuario_relacion['relation_name']->title, $nombres_relaciones_notificadas)){
            $destinatarios[] = $usuario_relacion['related_user']->guid;
        }
    }

    //el destinatario original del mensaje SIEMPRE estará incluido
    $destinatarios[] = $destinatario_id; //Debe ser un array de GUIDs
    
    return $destinatarios;
}


/**
 * Funcion que devuelve las relaciones a las que hay que notificar, cuando se envía una notificación
 * a un perfil determinado.
 * Ejemplo:
 * Se envía una notificación a un PACIENTE
 * Se adjunta a la notificación a sus PACIENTE-CUIDADOR y PACIENTE-FAMILIAR
 * @param string $nombre_perfil Nombre del perfil del que se quieren obtener los destinatarios añadidos
 * @return array Conjunto de id de las relaciones cuyos usuarios también tendrán que recibir la notificación
 */
function procura_notifications_get_relationships_destinations($guid_perfil){
    //'Paciente - Cuidador' -> guid 117
    $relaciones_destino = array ();
    
    //Sabemos que el nombre del setting es id_perfil + id_relacion. Así que:
    //1º: obtenemos todas las relaciones
    $relaciones = prp_get_relation_names();
    
    foreach ($relaciones as $relacion){
        //2º: construimos el nombre del setting
        $name = $guid_perfil . "-" . $relacion->guid;
        
        //3º: comprobamos que existe y está a 1
        $valor = elgg_get_plugin_setting($name, 'procura_notifications');
        if ((!empty($valor)) && ($valor != 0)){
            
            //4º: lo añadimos a la lista de relaciones que serán notificadas
            $relaciones_destino[] = $relacion->guid;
        }
    }
    
    return $relaciones_destino;
}

/**
 * Función que devolverá la cantidad de notificaciones sin leer del usuario del que se esté solicitando
 * @param type $id_usuario Identificador del usuario del que se solicitan las notificaciones sin leer
 * @return type int
 */
function procura_notifications_count_unread($id_usuario){
    $usuario = $id_usuario;
    if (empty($usuario))
        $usuario = elgg_get_logged_in_user_guid ();
    
    $notificaciones_pendientes = procura_notifications_unread($usuario);
    
    return count($notificaciones_pendientes);
}


/**
 * Función que devolverá el array de notificaciones sin leer del usuario del que s esté solicitando
 * @param type $id_usuario Identificador del usuario del que se solicitan las notificaciones sin leer
 * @return type array<ProcuraNotification>
 */
function procura_notifications_unread($id_usuario){
    
    //Declaración de variables necesarias en esta función
    $id_usuario_solicitado = $id_usuario;
    $notificaciones_pendientes = array();
    
    //verificacion de valores
    if (empty($id_usuario_solicitado))
        $id_usuario_solicitado = elgg_get_logged_in_user_guid ();

    //llenado del resto de valores
    $usuario_logueado = get_user($id_usuario_solicitado)->username;
    $total_notificaciones = procura_notifications_get_notification_list($usuario_logueado);
    
    //Lógica de la función
    foreach ($total_notificaciones as $notificacion) {
        $anotaciones = $notificacion->getAnnotations('notification');//Es en las anotaciones donde se indica si el usuario ha leido la notificación
        foreach ($anotaciones as $anotacion) {
            if (($anotacion->owner_guid == $id_usuario_solicitado) &&
                ($anotacion->value == 0))//si la notificación está NO leida (de ahí el 0), se cuenta
                {
                $notificaciones_pendientes[] = $notificacion;
            }
        }
    }
    return $notificaciones_pendientes;
}

?>
