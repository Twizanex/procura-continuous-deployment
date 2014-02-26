<?php

/* CGI Team
 * Funciones relacionadas con el módulo/plugin procura_contactos
 */
?>

<?php
/**
 * Se añaden a los elementos de menú disponibles las opciones:
 *  - Contactos (usuarios que tienen alguna relación con el usuario logueado)
 *  - Otros Usuarios (Usuarios que no tienen ninguna relación con el usuarios logueado
 *  * @return boolean (siempre true)
 */
function procura_contactos_en_site_item(){
   // Indicamos que sea en el menú del custom_index 
    
   elgg_register_menu_item('site', array(
			'name' => 'procura_contactos',
			'text' => elgg_echo('menu:contactos'),
			'href' => 'procura_contactos/contactos',
                        'link_class'=> 'elgg-button', 
                        'priority' =>100,
		)); 
   
   elgg_register_menu_item('site', array(
			'name' => 'procura_otros',
			'text' => elgg_echo('menu:otros'),
			'href' => 'procura_contactos/otros',
                        'link_class'=> 'elgg-button', 
                        'priority' =>100,
		)); 
   
    elgg_register_menu_item('site', array(
			'name' => 'mis_paciente',
			'text' => elgg_echo('menu:otros'),
			'href' => 'procura_contactos/mis_paciente',
                        'link_class'=> 'elgg-button', 
                        'priority' =>100,
		)); 
   
}

/*
 * Opciones que aparecerán en la ficha de un contacto:
 * 
 * Ver detalles
 * Enviar mensaje 
 * Llamar
 * Videoconferencia
 * Ver Blog
 * Establecer relación (Amigo) lo hace directamente, sin ir a ninguna página
 * Chat
 * 
 */
function contactos_menu($usuario){
    // Son los href de las opciones de menú
     $opciones = array (        
        'menu_contact:mail'=> elgg_get_site_url().'procura_messages/compose?send_to='.$usuario->guid,         
        //'menu_contact:telefono'=> '#',
        'menu_contact:video'=> '#',
         );
    return $opciones;
}

/**
 * 
 * @param type $user: Usuario del que se quieren obtener los NO contactos
 * @param type $perfil: Perfil al que deben pertenecer los usuarios devueltos
 * @return array: usuarios NO CONECTADOS con el dado por parámetro, del perfil indicado
 */
function pr_get_users_not_conected_to_by_profile($user,$perfil=NULL){

   // Obtenemos los objetos con los nombres de las relaciones
   $nombres_relaciones_notificadas = prp_get_relation_names();     
   // Extraemos los nombres en sí
   foreach ($nombres_relaciones_notificadas as $nombre_relacion) {
       $nombres[] = $nombre_relacion->title;       
   }      
   //Buscar todas las relaciones del usuario dado
   $relaciones_usuario = prp_get_user_relations($user);   
  
   /* Para cada relación, comprobar que su 'nombre' es uno de los anteriores
    * y extraer el objeto usuario relacionado correspondiente
    */
   $aEliminar = array();   
   foreach ($relaciones_usuario as $usuario_relacion){     
       if (in_array($usuario_relacion['relation_name']->title, $nombres)){
           // Obtenemos sólo los username
           $aEliminar[] = $usuario_relacion['related_user']->username;           
       }
   }          
   $options = array('type' => 'user','full_view' => FALSE);
   $todos = elgg_get_entities($options);
   $todosUsernames = array();
   foreach ($todos as $valor) {
       // Cogemos sólo los del perfil que queremos
       if ($valor instanceof ElggUser and prp_get_user_profile_type($valor) == $perfil){        
        $todosUsernames[] = $valor->username;
       }
   }
   
   // todos - destinatarios         
   $aEliminar[] = $user->username;
   $otros=array_diff($todosUsernames,$aEliminar); 

   // array con objetos de tipo usuario
   $resultado = array();
   foreach ($otros as $otroValue) {
       $candidato = get_user_by_username($otroValue);       
       // No queremos que aparezca el administrador
       if ($candidato->admin!='yes'){           
           $resultado[] = $candidato;
       }       
   }   
return $resultado;   
}

/**
 * 
 * @param type $user
 * @param type $perfil
 * @return \ElggUser
 */
function pr_get_users_not_conected_to_by_profile_and_id($user,$perfil=NULL){
// array en el que se devlverá el resultado
   $resultado = array();
   // Obtenemos los objetos con los nombres de las relaciones
   $nombres_relaciones_notificadas = prp_get_relation_names();     
   // Extraemos los nombres en sí
   foreach ($nombres_relaciones_notificadas as $nombre_relacion) {
       $nombres[] = $nombre_relacion->title;       
   }      
   //Buscar todas las relaciones del usuario dado
   $relaciones_usuario = prp_get_user_relations($user);   

   // Array con ids de usuarios a eliminar
   $aEliminar = pr_id_amigos_por_perfil($user,$perfil);

   /* Para cada relación, comprobar que su 'nombre' es uno de los anteriores
    * y extraer el objeto usuario relacionado correspondiente
    */
   
   foreach ($relaciones_usuario as $usuario_relacion){
       //var_dump($usuario_relacion);
       if (in_array($usuario_relacion['relation_name']->title, $nombres)){
           // Obtenemos sólo los username
           $usu = $usuario_relacion['related_user'];
           $aEliminar[] = $usu->guid;           
       }
   }    
   
   $options = array('type' => 'user','full_view' => FALSE);
   $todos = elgg_get_entities($options);
   $todosIds = array();
   foreach ($todos as $valor) {
       // Cogemos sólo los del perfil que queremos       
       if ($valor instanceof ElggUser and prp_get_user_profile_type($valor) == $perfil){        
        $todosIds[] = $valor->guid;
       }
   }
  
   // todos - destinatarios         
   $aEliminar[] = $user->guid;
   //$otros es un array de ids
   $otros=array_diff($todosIds,$aEliminar); 

   // Si el array de diferencia está vacío, no buscamos nada
   if (count($otros)>0){
        $candidatos = elgg_get_entities(array(  
             'type' => 'user',   
             'guids' => $otros));

        foreach($candidatos as $candidato){
            // No queremos que aparezca el administrador
            if ($candidato->admin!='yes' ){           
                $resultado[] = $candidato;
            } 
        }
   }
   // Array de objetos usuarios   
    return $resultado;   
}
/**
 * @return array de objetos de perfil, ordenado alfabéticamente
 */
function pr_perfiles(){
    // Obtener todos los perfiles (profile_manager) ordenados por el campo metadata_name        
     $options = array(
        "type" => "object",
        "subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
	"order_by_metadata" => array('name' => 'metadata_name')
      );
    
    $list = elgg_get_entities_from_metadata($options); 

    return $list;
}


/**
 * Obtener todos los usuarios del perfil indicado de los contenidos en la lista dada. 
 * @param type array $lista_usuarios en la que buscar los perfiles
 * @param type string $perfil_buscado. Si es null, se devuelve el mismo array que se ha pasado como parámetro
 * @return type
 */
function get_users_by_profile($lista_usuarios,$perfil_buscado=NULL){   
   
   if (count($lista_usuarios) >0){  
       $users_perfil = array();
       if ($perfil_buscado != NULL){
            foreach ($lista_usuarios as $usuario) {
              //CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE                  
                if ($perfil_buscado == prp_get_user_profile_type($usuario)){                    
                    $users_perfil[] = $usuario;
                }  
            }
       }else{
           $users_perfil = $lista_usuarios;
       }
    }
    return $users_perfil;  
}

/**
 * Devuelve los usuarios de un perfil que están relacionados con el dado
 * @param type $user: usuario de contacto
 * @param type $perfil: String con el Perfil de los usuarios que queremos obtener. Si es NULL, se buscan todos los perfiles
 * @return type array de objetos usuario del $perfil relacionados con $user
 */
function pr_get_users_conected_to_by_profile($user,$perfil=NULL){
    //$aDevolver = array();
    $aDevolver = pr_amigos_por_perfil($user,$perfil);
    $ids_amigos = pr_id_amigos_por_perfil($user,$perfil);
    
    // Controlar si no hay amigos
    if ($perfil!=NULL){          
        $relacionados = prp_get_related_users($user);                
        foreach ($relacionados as $related_user){
            if (!in_array($related_user->guid, $ids_amigos)){                      
                $perfil_contacto = prp_get_user_profile_type($related_user);                        
                if ($perfil==$perfil_contacto){
                    if ($related_user != $user){
                        $aDevolver[] = $related_user;
                    }
                }
             }            
        }        
    }else{
        //Array_push sólo funciona con arrays simples
        //$aDevolver = prp_get_related_users($user);
        array_push($aDevolver, prp_get_related_users($user));
    }
 
    return $aDevolver;
}

/**
 * Crea el camino de migas de pan en función de los parámetros enviados en la URL, y sin machacar migas que tubiese previamente
 * @param type $page Array de parámetros que se envían en la URL
 */
function pr_contactos_handle_breadcrum ($page){
/*
 * Ejemplo: elgg_push_breadcrumb(elgg_echo('procura:notificaciones'), "notifications/all"); //Miga de pan a todas las notificaciones
 * elgg_push_breadcrumb($title, $link = NULL); //'title' y 'link' son los nombres de los 2 campos del array que devuelve cada miga
 * elgg_pop_breadcrumb(); //Elimina la última
 * elgg_get_breadcrumbs();
 */    
    //Si entramos aquí, estamos seguros de que hay:
    //page[0]=contactos    
    if ($page[0]==''){
        $pag0 = 'contactos';
    }else{
        $pag0= $page[0];
    }
    
    if ($page[1]==''){
        $pag1 = elgg_get_logged_in_user_entity()->username;
    }else{
        $pag1= $page[1];
    }
    
    $last_link = "procura_contactos/".$pag0."/".$pag1;
    switch ($pag0) {
        case "detalle_contactos":
            $last_title = "Detalle";
            break;
        case "contactos":
            $last_title = elgg_echo('procura_contactos:contactos');
            break;
        case "otros":
            $last_title = elgg_echo('procura_contactos:otros');
            break;
        default:
            break;
    }
    
    $encontrado = 0;
    $breadcrums = elgg_get_breadcrumbs();   
    
    $breadcrums = array_reverse($breadcrums);//tomar los elementos desde el final hasta el principio
  
    foreach ($breadcrums as $breadcrum){        
        if ($encontrado == 0){ //Una vez se ha encontrado la miga de pan, no continuar            
            if ($breadcrum->title != elgg_echo('procura_contactos:otros')){
                elgg_pop_breadcrumb();
            } else{
                $encontrado = 1;
            }
        }
    }
        
    if ($encontrado == 0){
        elgg_push_breadcrumb(elgg_echo("procura:home"), elgg_get_site_url());//Si encontrado = 0 -> Se han eliminado TODAS las breadcrumb -> Meter la breadcrum de HOME
        elgg_push_breadcrumb($last_title, $last_link);
    }

    
    }

    
function pr_get_my_patients($user){
   return pr_get_users_conected_to_by_profile($user,'Paciente'); 
} 

/*
 * Obtener los amigos de un determinado perfil.
 * Si no se indica perfil, obtenerlos todos.
 * return array containing user ids
 */
function pr_id_amigos_por_perfil($user,$perfil=NULL){
    
    $amigosADevolver = array();
    $$ids_amigos_a_devolver =array();
    $amigos = $user->getFriends('',0);
    if($amigos){        
        // Obtener sólo los del perfil dado
        if ($perfil!=NULL){
           foreach($amigos as $amigo){
               if ($perfil == prp_get_user_profile_type($amigo)){
                   $amigosADevolver[] = $amigo;
                   $ids_amigos_a_devolver[] = $amigo->guid;
               }
           }
        }else{
            foreach ($amigos as $amigo){
                $ids_amigos_a_devolver[] = $amigo->guid;
            }
        }
    }
    // Mejor devolver una lista de ids
    return $ids_amigos_a_devolver;
}

/**
 * 
 * @param type $user
 * @param type $perfil
 * @return type mix: Array with user type objects
 */
function pr_amigos_por_perfil($user,$perfil=NULL){
    
    $amigosADevolver = array();
    
    $amigos = $user->getFriends('',0);    
    if($amigos){        
        // Obtener sólo los del perfil dado
        if ($perfil!=NULL){           
           foreach($amigos as $amigo){
               if ($perfil == prp_get_user_profile_type($amigo)){
                   $amigosADevolver[] = $amigo;
               }
           }
        }else{
            return $amigos;
        }
    }
    
    return $amigosADevolver;
}

?>
