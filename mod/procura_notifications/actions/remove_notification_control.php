<?php

admin_gatekeeper();

$forward_url = REFERER;

$id_perfil = get_input('perfil');//guid del perfil sobre el que se van a establecer las notificaciones en cuanto a sus relaciones
$id_relacion = get_input ('relationship');//guid de la relación que recibirá la notificación cuando se envíe al perfil de arriba

if (!empty($id_perfil) && !empty($id_relacion)){//verificar que se pasan los 2 campos obligatorios
    
    //Recuperar settings del plugin para saber qué había antes
    //El identificador del setting será el identificador del perfil + el identificador
    //de la relación, de forma que si hay 5perfiles*4relaciones=20 settings
    $valor = elgg_get_plugin_setting($id_perfil."-".$id_relacion, 'procura_notifications');
    if (empty($valor) || $valor==0){ //Si no existía o ya estaba en 0, NO se puede BORRAR
        $error = elgg_echo ("notificaciones:remove_notification:already_removed");
    } else{
        elgg_set_plugin_setting($id_perfil."-".$id_relacion, 0, 'procura_notifications');
    }
}


forward($forward_url);
