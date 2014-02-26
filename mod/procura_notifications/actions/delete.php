<?php

gatekeeper();

$notification_id = get_input('notification_id'); //id de la notificacion
//$user_id = get_input('user_id'); //Usuario destinatario de la notificación

// No se va a modificar la entidad, sólo la anotación que afecta al usuario logueado:
$user_id = elgg_get_logged_in_user_guid();

$forward_url = REFERER;//URL a la que volveremos tras la ejecución de esta página
$error = FALSE;//informará de si se ha producido un error durante la ejecución de la acción

if (!empty($notification_id)){//verificar que se pasan los campos obligatorios
    //if (get_loggedin_userid() == $user_id){//No tienes porqué ser dueño de la entidad, sólo de la anotacion
        $notificacion = get_entity($notification_id);
        $destinatarios = $notificacion->getAnnotations('notification');
        
        foreach ($destinatarios as $destinatario) {
            if ($destinatario->owner_guid == $user_id){ //borrar sólo tu annotation
                $destinatario->delete();
            }
        }
        
        //Si la notificacion (es una entidad) se queda sin anotaciones, se borra:
        if ($notificacion->countAnnotations('notification') == 0){
            if (!$notificacion->delete()) {
                $error = elgg_echo ("notificaciones:delete:cannot_delete");
            }
        }
}else{
    $error = elgg_echo("notificaciones:delete:parameters_error");
}

//Siempre llegas aquí, aunque a veces con un error
if ($error)
    register_error($error);
forward($forward_url);
?>
