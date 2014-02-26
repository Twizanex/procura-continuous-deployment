<?php

admin_gatekeeper();

$forward_url = REFERER;

$id_perfil = get_input('perfil');//guid del perfil sobre el que se van a establecer las notificaciones en cuanto a sus relaciones
$id_relacion = get_input ('relationship');//guid de la relación que recibirá la notificación cuando se envíe al perfil de arriba

if (!empty($id_perfil) && !empty($id_relacion)){//verificar que se pasan los 2 campos obligatorios
    
    //Recuperar settings del plugin para saber qué había antes
    //El identificador del setting será el identificador del perfil + el identificador
    //de la relación, de forma que si hay 5perfiles*4relaciones=20 settings
    elgg_set_plugin_setting($id_perfil."-".$id_relacion, "1", 'procura_notifications');
}


forward($forward_url);
