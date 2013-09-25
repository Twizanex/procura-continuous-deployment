<?php
/*
 * Acción de quitar un botón del menú de un perfil de usuario
 */

$item_guid = get_input('id_menu_item');
$menu_item = get_entity($item_guid);

if (elgg_instanceof($menu_item, 'object', ProcuraMenuItem::SUBTYPE)) {
    if ($menu_item->delete()) {
        system_message(elgg_echo('p_ind:remove_menu_item:exito'));
    } else {
        register_error(elgg_echo('p_ind:remove_menu_item:error'));
    }
} else {
    register_error(elgg_echo('p_ind:remove_menu_item:f_error'));
}

forward(REFERER);