<?php

function procura_notifications_init() {
    
    //Registrar las librerías de este módulo
    elgg_register_library('procura:notifications', elgg_get_plugins_path() . 'procura_notifications/lib/notifications.php');

    //Cargar las librerías de este módulo inmediatamente si fuese necesario (se hace en index.php)
    elgg_load_library('procura:notifications'); //<- las cargamos para que otros módulos puedan acceder a las librerías, aunque no estemos en la página de visualización de notificaciones (es decir, no pasamos por index.php
    
    // routing of urls
    elgg_register_page_handler('notifications', 'procura_notifications_page_handler');//notifications es el nombre que se pondrá en la URL después del /pg/
    
    // Extender los CSS del sistema con los estilos propios del módulo
    elgg_extend_view('css/elgg', 'procura_notifications/css');
    
    // Registrar el JavaScript
    $procura_notifications_js = elgg_get_simplecache_url('js', 'procura_notifications');
    elgg_register_js('procura.notifications', $procura_notifications_js);
    
    // registro de acciones sobre las notificaciones
    $base_actions_dir = elgg_get_plugins_path() . 'procura_notifications/actions';
    elgg_register_action('procura_notifications/delete', "$base_actions_dir/delete.php"); //Borrar una notificación
    elgg_register_action('procura_notifications/toggle', "$base_actions_dir/toggle.php"); //Notificación leida/no leida
    
    elgg_register_action('procura_notifications/remove_notification_control', "$base_actions_dir/remove_notification_control.php");//Quitar que un usuario reciba una notificación por su relación con el destinatario
    elgg_register_action('procura_notifications/add_notification_control', "$base_actions_dir/add_notification_control.php");//Añadir un usuario que recibirá una notificación dada su relación con el destinatario
    
    // menu administracion
    elgg_register_admin_menu_item('configure', 'notifications_control', 'settings');
            //configure indica que estará en el apartado de Configuración, en lugar del de Admón.
            //settings hará que la nueva opción aparezca en el desplegable "Configuración"
            //menu_items_control hace que redirija a views/default/admin/settings/notifications_control.php
            
    // registro del botón de acceso al módulo, en el menú principal de custom_index
    $menu_name = 'site'; //$menu_name = [site, page, userprofile]
    $menu_item = new ElggMenuItem('procura_notificaciones', elgg_echo('notifications:main_menu_name'), 'notifications/');
    elgg_register_menu_item($menu_name, $menu_item);
    
    // registro del botón de acceso al módulo, en el menú del perfil de ¿custom_profile?
    $menu_name = 'userprofile';
    $menu_item = new ElggMenuItem('procura_notificaciones', elgg_echo('notifications:profile_menu_name'), 'notifications/');
    elgg_register_menu_item($menu_name, $menu_item);

    elgg_register_event_handler('pagesetup', 'system', 'pr_notifications_notifier');//La actualización de la
        //página actualiza el botón del menú de Notificaciones (para detectar si hay alguna sin leer)
}
    
elgg_register_event_handler('init', 'system', 'procura_notifications_init');//acciones al cargar un módulo


function pr_notifications_notifier(){
    if (elgg_is_logged_in()){
        //system_message("Se carga UNA pagina");

        $unread = procura_notifications_count_unread(elgg_get_logged_in_user_guid());
//system_message("La cantidad de notificaciones sin leer del usuario logueado es: " . $unread);
        if ($unread != 0){
            /*
             * Intento de: introducir el numero de notificaciones sin leer
             * en el botón del menú principal de notificaciones.
             * 
            // ACTUALIZACIÓN DEL registro del botón de acceso al módulo, en el menú principal de custom_index
            $menu_name = 'site'; //$menu_name = [site, page, userprofile]
            //system_message("La cantidad de notificaciones sin leer es: " . $unread);
            $txt_item_menu = elgg_echo('notifications:main_menu_name') . "<span class=\"messages-new\">$unread</span>";
            $menu_item = new ElggMenuItem('procura_notificaciones', $txt_item_menu, 'notifications/');
            //$resultado = elgg_unregister_menu_item('procura_notificaciones', elgg_echo('notifications:main_menu_name'));
            //system_message("El resultado de la desactivación del menu_item es: $resultado");
            //elgg_register_menu_item($menu_name, $menu_item);

            // ACTUALIZACIÓN DEL registro del botón de acceso al módulo, en el menú del perfil de ¿custom_profile?
            //$menu_name = 'userprofile';
            //$menu_item = new ElggMenuItem('procura_notificaciones', elgg_echo('notifications:profile_menu_name'), 'notifications/');
            //elgg_register_menu_item($menu_name, $menu_item);
             *************************/
            
            $class = "elgg-icon elgg-icon-attention";
            //$class = "elgg-icon elgg-icon-speech-bubble"; //Esta imagen se ve mejor, pero es inadecuada
            
            $text = "<span class='$class'></span>";
            $tooltip = elgg_echo("procura_notifications");

            $text .= "<span class=\"messages-new\">$unread</span>";
            $tooltip .= " (" . elgg_echo("messages:unreadcount", array($unread)) . ")";


            elgg_register_menu_item('topbar', array(
                    'name' => 'notifications',
                    'href' => 'notifications/',// . elgg_get_logged_in_user_entity()->username,
                    'text' => $text,
                    'priority' => 600,
                    'title' => $tooltip,
            ));
            
            
        }
    }
    return true;
}

function procura_notifications_page_handler ($page){
    if (!include_once(dirname(__FILE__) . "/index.php")) {
        return false;
    }
    return true; // Devuelve 'true' si se ha cargado index.php
}


//Notificaciones No leídas destinadas al usuario??
function pr_notifications_count_unread() {
	$user_guid = elgg_get_logged_in_user_guid();
	$db_prefix = elgg_get_config('dbprefix');

	// denormalize the md to speed things up.
	// seriously, 10 joins if you don't.
	$strings = array('toId', $user_guid, 'readYet', 0, 'msg', 1);
	$map = array();
	foreach ($strings as $string) {
		$id = get_metastring_id($string);
		$map[$string] = $id;
	}

	$options = array(
//		'metadata_name_value_pairs' => array(
//			'toId' => elgg_get_logged_in_user_guid(),
//			'readYet' => 0,
//			'msg' => 1
//		),
		'joins' => array(
			"JOIN {$db_prefix}metadata msg_toId on e.guid = msg_toId.entity_guid",
			"JOIN {$db_prefix}metadata msg_readYet on e.guid = msg_readYet.entity_guid",
			"JOIN {$db_prefix}metadata msg_msg on e.guid = msg_msg.entity_guid",
		),
		'wheres' => array(
			"msg_toId.name_id='{$map['toId']}' AND msg_toId.value_id='{$map[$user_guid]}'",
			"msg_readYet.name_id='{$map['readYet']}' AND msg_readYet.value_id='{$map[0]}'",
			"msg_msg.name_id='{$map['msg']}' AND msg_msg.value_id='{$map[1]}'",
		),
		'owner_guid' => $user_guid,
		'count' => true,
	);

	//return elgg_get_entities_from_metadata($options);
        $usuario = get_entity($user_guid);
        return procura_notifications_get_notification_list($usuario->username);
}

function pr_notifications_site_notify_handler(ElggEntity $from, ElggUser $to, $subject, $notification, array $params = NULL) {

	if (!$from) {
		throw new NotificationException(elgg_echo('NotificationException:MissingParameter', array('from')));
	}

	if (!$to) {
		throw new NotificationException(elgg_echo('NotificationException:MissingParameter', array('to')));
	}

	global $messages_pm;
	if (!$messages_pm) {
		return messages_send($subject, $notification, $to->guid, $from->guid, 0, false, false);
	}

	return true;
}

?>
