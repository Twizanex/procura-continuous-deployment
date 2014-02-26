<?php
/**
 * Muestra por pantalla una notificación
 */

$notificacion = $vars['notificacion'];

$fecha = $notificacion->time_created;
$texto = $notificacion->description;
//$content_owner_guid = $notificacion->owner_guid;//ID del usuario que realizó la acción que inició la notificación
//$content_owner_guid = get_user_by_username($content_owner)->guid;//GUID del usuario del que estamos viendo las notificaciones
$content_owner_guid = elgg_get_page_owner_guid();

//por defecto, la clase de los paneles de las notificaciones es 'no leida'
$notification_div_class='div_notification_unread';
$notification_text_class='text_notification_unread';
$leido = 0;

//comprobar si la notificación estaba leida
$destinatarios = $notificacion->getAnnotations ('notification');
//system_message('Estamos viendo las notificaciones del usuario ' . $content_owner . ', con ID: ' . $content_owner_guid);
foreach ($destinatarios as $destinatario){    
//    system_message('Para la notificacion:' . $notificacion->guid . " su destinatario:" . $destinatario->owner_guid . " tiene el valor de lectura: ". $destinatario->value);
    if ((   $destinatario->owner_guid == $content_owner_guid) && //Queremos saber si el usuario del que estamos viendo la anotación, la ha leido
            $destinatario->value == 1){ //Vamos a ver si el receptor de la notificación la ha leido, que no tiene porqué ser el usuario logueado
//        system_message('Por lo que entra aqui');
        $notification_div_class='div_notification_read';
        $notification_text_class='text_notification_read';
        $leido = 1;
    }
    $guid_destinatario_original = $destinatario->owner_guid;//El destinatario original ES el último del array de destinatarios
}


if ($content_owner_guid == get_loggedin_userid()){
    
    //Formulario para marcar una Notificación como leida/no leida
    $id_formulario = "form_leido_" . $notificacion->guid;
    $accion = "action/procura_notifications/toggle"; //declarado en el start.php
    $accion_borrar = "procura_notifications/delete"; //declarado en el start.php
    elgg_load_js('procura.notifications');
    $opciones_checkbox = array (
        'internalname'=>'leido',
        'value'=>$leido,//En realidad, no hace falta asignarle ningún valor
        'js'=>"onClick=\"procura.notifications.sendForm('$id_formulario')\"", //funcion javascript para enviar el formulario en cuanto se pulse el checkbox. Se encuentra en views/default/js/procura_notifications.php
        'leido'=> $leido//,
    );
    //Si la notificación SI está leida, el formulario tendrá el valor checked ACTIVO
    if ($leido == 1){
        $opciones_checkbox['checked'] = "";
    }
    $body_form .= elgg_view('input/checkbox',$opciones_checkbox);//Sólo se permitirá cambiar el estado de la annotation si te pertenece

    //El formulario para eliminar la anotación se muestra a TODOS los que ven la anotación, porque sólo se elimina la 
    //'annotation' que te asocia a la 'notificacion'. NO estás borrando la 'notificación' en sí
    $formulario_borrar = elgg_view_form($accion_borrar, array(), array('id_notificacion' => $notificacion->guid));

    $body_form .= elgg_view('input/hidden', array('name' => 'notification_id', 'value' => $notificacion->guid));
    $body_form .= elgg_view('input/hidden', array ('name' => 'user_id', 'value' => $guid_destinatario_original)); //GUID del usuario al que se ha hecho la notificación

    $opciones_form = array ('body' => $body_form, 'action' => $accion, 'id'=>$id_formulario);

    //finalmente, el formulario que indica si la notificación se ha leido
    $formulario = elgg_view ('input/form', $opciones_form);
    
}

//la fecha en la que se creó la notificación
$fecha_creacion = elgg_view('output/date',array('value'=>$fecha));

if (is_null($notificacion->priority) || !$notificacion->priority){
    $notificacion->priority = 1;
}
echo "
    <tr class='{$notification_div_class}'>
        
        <td class='td_notification_form'>{$formulario}</td>
        <td class='td_notification_date'>{$fecha_creacion}</td>
        <td class='td_notification_priority'><img class='td_notification_priority_img' src='" .elgg_get_site_url() . "mod/procura_notifications/graphics/priority_{$notificacion->priority}.png' ></td>
        <td class='td_notification_from'>" . get_user($notificacion->owner_guid)->username . "</td>
        <td class='{$notification_text_class}'>{$texto}</td>
        <td class='td_notification_delete'>{$formulario_borrar}</td>
    </tr>";
?>
