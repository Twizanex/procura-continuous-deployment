<?php
/**
 * Messages helper functions
 *
 * @sdrortega: Updated from @package ElggMessages
 */

/**
 * Prepare the compose form variables
 *
 * @return array
 */
function pr_messages_prepare_form_vars($recipient_guid = 0) {    
	// input names => defaults
	$values = array(
		'subject' => '',
		'body' => '',
		'recipient_guid' => $recipient_guid,
	);

	if (elgg_is_sticky_form('messages')) {
		foreach (array_keys($values) as $field) {
			$values[$field] = elgg_get_sticky_value('messages', $field);
		}
	}

	elgg_clear_sticky_form('messages');

	return $values;
}
/**
 * Transforma la fecha y hora de inglés a castellano
 * @param type $fecha_y_hora
 * @return string formateada
 */
function fecha_mensaje($fecha_y_hora){
    //$fecha_ingles = strftime("%A %#d de %B del %Y %H:%M ");
    
    if (empty($fecha_y_hora)){
        $fecha_y_hora = getDate();
    }else{
        $fecha_y_hora = getDate($fecha_y_hora);
    }    
    
    $dia_sem = $fecha_y_hora['weekday'];
    $mes = $fecha_y_hora['month'];
    
    $fecha_y_hora['hours']<10 ? $hora = '0'.$fecha_y_hora['hours'] : $hora = $fecha_y_hora['hours'];
    $fecha_y_hora['minutes']<10 ? $min = '0'.$fecha_y_hora['minutes'] : $min = $fecha_y_hora['minutes'];
    
    $fecha_def = elgg_echo($dia_sem).", ".$fecha_y_hora['mday']." de ".elgg_echo($mes)." de ".$fecha_y_hora['year']." - ".$hora.":".$min;
    return $fecha_def;
}

/**
 * Se parte de la función send del módulo de mensajes de Elgg
 * Genera un borrador, que es un mensaje con el nuevo campo "borrador" a 1.
 * 
 * @return si el guardado del objeto ha tenido éxito o no
 */
function pr_messages_save($subject, $body, $send_to, $from = 0, $reply = 0, $notify = true, $add_to_sent = true) {

	global $messagesendflag;
	$messagesendflag = 1;

	global $messages_pm;
	if ($notify) {
		$messages_pm = 1;
	} else {
		$messages_pm = 0;
	}

	// If $from == 0, set to current user
	if ($from == 0) {
            $from = (int) elgg_get_logged_in_user_guid();
	}

	// Initialise new ElggObject: ¿Cómo diferenciar si es un borrador nuevo o uno ya existente?
	
	$message_sent = new ElggObject();
	
	$message_sent->subtype = "messages";
	
	$message_sent->owner_guid = $from;
	$message_sent->container_guid = $from;
	
	$message_sent->access_id = ACCESS_PUBLIC;
	$message_sent->title = $subject;
	$message_sent->description = $body;

	$message_sent->toId = $send_to; // the user receiving the message. What if nothing
	$message_sent->fromId = $from; // the user receiving the message
	$message_sent->readYet = 0; // this is a toggle between 0 / 1 (1 = read)
	$message_sent->hiddenFrom = 0; // this is used when a user deletes a message in their sentbox, it is a flag
	$message_sent->hiddenTo = 0; // this is used when a user deletes a message in their inbox
        $message_sent->borrador = 1;
	$message_sent->msg = 1;
        
	// Save the copy of the message that goes to the sender
	if ($add_to_sent) {
            $success2 = $message_sent->save();
	}

	if ($add_to_sent) {
            $message_sent->access_id = ACCESS_PRIVATE;
            $message_sent->save();
	}
        
        $messagesendflag = 0;
	return $success2;
}

/**
 * Copia de pr_messages_save, pero añadiendo el id del borrador guardado -> Eliminar pr_messages_save
 * 
 * @return type
 */
function pr_messages_save_con_id($subject, $body, $send_to, $from = 0, $reply = 0, $notify = true, $add_to_sent = true,$id=0) {

	global $messagesendflag;
	$messagesendflag = 1;

	global $messages_pm;
	if ($notify) {
		$messages_pm = 1;
	} else {
		$messages_pm = 0;
	}

	// If $from == 0, set to current user
	if ($from == 0) {
		$from = (int) elgg_get_logged_in_user_guid();
	}

	// Initialise new ElggObject: ¿Cómo diferenciar si es un borrador nuevo o uno ya existente?
	if ($id == 0 ){
            $message_sent = new ElggObject();
        }else{
            // Modificar el borrador
            $message_sent = get_entity($id);
        }

        $message_sent->subtype = "messages";

        $message_sent->owner_guid = $from;
        $message_sent->container_guid = $from;

        $message_sent->access_id = ACCESS_PUBLIC;
        $message_sent->title = $subject;
        $message_sent->description = $body;

        $message_sent->toId = $send_to; // the user receiving the message. What if nothing
        $message_sent->fromId = $from; // the user receiving the message
        $message_sent->readYet = 0; // this is a toggle between 0 / 1 (1 = read)
        $message_sent->hiddenFrom = 0; // this is used when a user deletes a message in their sentbox, it is a flag
        $message_sent->hiddenTo = 0; // this is used when a user deletes a message in their inbox
        $message_sent->borrador = 1;
        $message_sent->msg = 1;
        

	if ($add_to_sent) {
		$message_sent->access_id = ACCESS_PRIVATE;
		$success2 = $message_sent->save();
	}
        
        $messagesendflag = 0;
	return $success2;
}


/**
 * Se llamará desde la acción de save. Se trata del envío de un borrador. Siempre tendremos id
 */
function pr_messages_send_id($subject, $body, $send_to, $from = 0, $reply = 0, $notify = true, $add_to_sent = true,$id=0) {

	global $messagesendflag;
	$messagesendflag = 1;

	global $messages_pm;
	if ($notify) {
		$messages_pm = 1;
	} else {
		$messages_pm = 0;
	}

	// If $from == 0, set to current user
	if ($from == 0) {
		$from = (int) elgg_get_logged_in_user_guid();
	}

	
        if ($id == 0){
            $message_to = new ElggObject();
        }else{
            $message_to = get_entity($id);            
        }
        
        $message_sent = new ElggObject();
        
	$message_to->subtype = "messages";
	$message_sent->subtype = "messages";
	$message_to->owner_guid = $send_to;
	$message_to->container_guid = $send_to;
	$message_sent->owner_guid = $from;
	$message_sent->container_guid = $from;
	$message_to->access_id = ACCESS_PUBLIC;
	$message_sent->access_id = ACCESS_PUBLIC;
	$message_to->title = $subject;
	$message_to->description = $body;
	$message_sent->title = $subject;
	$message_sent->description = $body;
	$message_to->toId = $send_to; // the user receiving the message
	$message_to->fromId = $from; // the user receiving the message
	$message_to->readYet = 0; // this is a toggle between 0 / 1 (1 = read)
	$message_to->hiddenFrom = 0; // this is used when a user deletes a message in their sentbox, it is a flag
	$message_to->hiddenTo = 0; // this is used when a user deletes a message in their inbox
	$message_sent->toId = $send_to; // the user receiving the message
	$message_sent->fromId = $from; // the user receiving the message
	$message_sent->readYet = 0; // this is a toggle between 0 / 1 (1 = read)
	$message_sent->hiddenFrom = 0; // this is used when a user deletes a message in their sentbox, it is a flag
	$message_sent->hiddenTo = 0; // this is used when a user deletes a message in their inbox
        $message_sent->borrador = 0;
        $message_to->borrador = 0;
	$message_to->msg = 1;
	$message_sent->msg = 1;

	// Save the copy of the message that goes to the recipient
	$success = $message_to->save();

	// Save the copy of the message that goes to the sender
	if ($add_to_sent) {
		$success2 = $message_sent->save();
	}

	$message_to->access_id = ACCESS_PRIVATE;
	$message_to->save();

	if ($add_to_sent) {
		$message_sent->access_id = ACCESS_PRIVATE;
		$message_sent->save();
	}
      
/*
 * Si el mensaje se ha enviado al DESTINATARIO, enviar la notificación al módulo:
 */
        if (elgg_is_active_plugin('procura_notifications')){
            $origen = elgg_get_logged_in_user_entity()->username;
            $destinatario = get_user($send_to)->username;
            $texto = $destinatario . ", ha recibido un mensaje nuevo. <a href='" . elgg_get_site_url() . "procura_messages/read/" . $success . "'>Leer</a>";
            //$texto = elgg_echo('messages:send_notification:new_message', array($texto));
            procura_notifications_send_notification($texto, $origen, $destinatario);
        } else{
            system_message(elgg_echo("messages:module_missed", array ('procura_notifications')));
        }
        
	// if the new message is a reply then create a relationship link between the new message
	// and the message it is in reply to
	if ($reply && $success){
		$create_relationship = add_entity_relationship($message_sent->guid, "reply", $reply);
	}

	$message_contents = strip_tags($body);
	if ($send_to != elgg_get_logged_in_user_entity() && $notify) {
		$subject = elgg_echo('messages:email:subject');
		$body = elgg_echo('messages:email:body', array(
			elgg_get_logged_in_user_entity()->name,
			$message_contents,
			elgg_get_site_url() . "procura_messages/inbox/" . $user->username,
			elgg_get_logged_in_user_entity()->name,
			elgg_get_site_url() . "procura_messages/compose?send_to=" . elgg_get_logged_in_user_guid()
		));

		notify_user($send_to, elgg_get_logged_in_user_guid(), $subject, $body);
	}

	$messagesendflag = 0;
	return $success;
}