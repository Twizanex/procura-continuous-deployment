<?php

$toggle = get_input('leido', -1); //Indicador de leido/no leido
$notification_id = get_input('notification_id'); //id de la notificacion dueña

//El usuario logueado no tiene porqué ser dueño de la notificación, sólo ser uno de los destinatarios que están en las annotations
//$user_id = get_input('user_id');
$user_id = elgg_get_logged_in_user_guid();

//Si toggle == 1 -> No está leido, hay que marcarlo como leido -> poner un 0 en la annotation
//Si toggle == 0 -> Lo contrario de lo de arriba

$forward_url = REFERER;//URL a la que volveremos tras la ejecución de esta página
$error = FALSE;//informará de si se ha producido un error durante la ejecución de la acción

if (($toggle != -1) && !empty($notification_id) /*&& !empty($user_id)*/){//verificar que se pasan los 3 campos obligatorios
    //if (get_loggedin_userid() == $user_id){//verificar que eres dueño de lo que vas a modificar
        $notificacion = get_entity($notification_id);
        $destinatarios = $notificacion->getAnnotations('notification');
        foreach ($destinatarios as $destinatario){
//            system_message('Estado de lectura de la anotacion del usuario ' . $destinatario->owner_guid . ": " . $destinatario->value . ". Cambiaría a " . abs($destinatario->value - 1));
            if ($destinatario->owner_guid == $user_id){ //modificar solo tu annotation
                $destinatario->value = abs($destinatario->value - 1);//Si era 0, lo pone a 1. Si era 1, lo pone a 0
                $destinatario->save();
                //system_message(elgg_echo('p_ind:add_menu_item:exito'));//No necesitas informar. Como vuelves a la página anterior, ya verás el resultado.
                forward($forward_url);
            }
        }
        $error = elgg_echo ("notificaciones:toggle_status:unpredecible_error");
    //}else{
    //    $error = elgg_echo ("notificaciones:toggle_status:owner_error");
    //}
}else{
    $error = elgg_echo("notificaciones:toggle_status:parameters_error");
}
//Si llegas aquí, es que se ha producido un error.
register_error($error);
forward($forward_url);
?>
