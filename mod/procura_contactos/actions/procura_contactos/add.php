<?php
/**
 * Procura contactos -> acción: "Añadir amigo", que sea bidireccional
 *
 */

// Get the GUID of the user to friend
$friend_guid = get_input('friend');
$friend = get_entity($friend_guid);

system_message(REFERER);
if (!$friend) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$errors = false;

// Get the user
try {
	if (!elgg_get_logged_in_user_entity()->addFriend($friend_guid)) {                      
		$errors = true;
	}else{
            // Si ha ido bien, añadimos el recíproco
            $user_uid = elgg_get_logged_in_user_entity()->guid;
            if (!$friend ->addFriend($user_uid)){
                $errors = true;
            }
        }
        
} catch (Exception $e) {    
	register_error(elgg_echo("friends:add:failure", array($friend->name)));
	$errors = true;
}   

if (!$errors) {
    //Si todo ha ido bien, se envía la Notificación correspondiente
        if (elgg_is_active_plugin('procura_notifications')){
            $origen = elgg_get_logged_in_user_entity()->username;
            $destinatario = $friend->username;
            $texto = elgg_echo('contactos:add:notification', array($origen->username));
            procura_notifications_send_notification($texto, $origen, $destinatario);
        } else{
            system_message(elgg_echo("contactos:module_missed", array ('procura_notifications')));
        }
	// add to river
	add_to_river('river/relationship/friend/create', 'friend', elgg_get_logged_in_user_guid(), $friend_guid);
	system_message(elgg_echo("friends:add:successful", array($friend->name)));        
        
}

// Forward back to the page you friended the user on
forward(REFERER);
