<?php

if (elgg_is_logged_in()){    
    
 /*
 * Verificamos la existencia de todos los módulos que serán necesarios para el funcionamiento de los enlaces
 * de este módulo (que en realidad, son TODOS los identificados para satisfacer los requisitos el proyecto).
 */
    if (!((elgg_is_active_plugin('file')) && //V
        (elgg_is_active_plugin('blog')) && //V
        (elgg_is_active_plugin('loginrequired')) &&
        (elgg_is_active_plugin('rss')) &&
        (elgg_is_active_plugin('links')) &&
        (elgg_is_active_plugin('forum')) &&
        (elgg_is_active_plugin('chat')) &&
        (elgg_is_active_plugin('conference')) &&
        (elgg_is_active_plugin('members')) && //V
        (elgg_is_active_plugin('tratamiento')) && //V
        (elgg_is_active_plugin('actividad')) &&
        (elgg_is_active_plugin('event_calendar')) && //V
        (elgg_is_active_plugin('relacion')) && //+o-
        (elgg_is_active_plugin('profile_manager')) && //V
        (elgg_is_active_plugin('procura_common')) && //V
        (elgg_is_active_plugin('messages'))) //V
        ){
        system_message(elgg_echo('p_ind:falta_mod'));
    }
    
    $file_dir = elgg_get_plugins_path() . 'custom_index/pages';
    include "$file_dir/custom_index.php";
}

