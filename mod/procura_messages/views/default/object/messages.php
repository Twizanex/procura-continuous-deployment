<?php
/**
 * File renderer.
 * Lista de mensajes recibidos/enviados
 * @package ElggFile
 */

$full = elgg_extract('full_view', $vars, false);
$message = elgg_extract('entity', $vars, false);

if (!$message) {
	return true;
}

if ($message->toId == elgg_get_page_owner_guid()) {
	// received
	$user = get_entity($message->fromId);
	if ($user) {            
		$icon = elgg_view_entity_icon($user, 'tiny');
                //@sdrortega 16/10/2013: El nombre del remitente también llevará al mensaje recibido
		$user_link .= elgg_view('output/url', array(
			'href' => $message->getURL(),//"procura_messages/compose?send_to=$user->guid",
			'text' => $user->name,
			'is_trusted' => true,
		));
	} else {
		$icon = '';
		$user_link = elgg_echo('messages:deleted_sender');
	}

	if ($message->readYet) {
		$class = 'message read';
	} else {
		$class = 'message unread';
	}

} else {
       // sent y borradores
       $user = get_entity($message->toId);

       $borrador = $message->borrador;
       if ($borrador){
           $destino = "procura_messages/edit_draft/".$message->guid;           
       }else{
           $destino = $message->getURL();
       }
                
	if ($user) {            
		$icon = elgg_view_entity_icon($user, 'tiny');                
		$user_link .= elgg_view('output/url', array(
			'href' => $destino,  //$message->getURL(), /
			'text' => elgg_echo('messages:to_user', array($user->name)),
			'is_trusted' => true,
		));
	} else {
		$icon = '';
		$user_link = elgg_echo('messages:deleted_sender');
	}

	if ($message->borrador) {
		$class = 'message unread';
	} else {
		$class = 'message read';
	}
}

// La fecha la ponemos como texto
// Hay que corregir los acentos
$timestamp = fecha_mensaje($message->time_created);
 
$subject_info = elgg_view('output/url', array(
	'href' => $message->getURL(),
	'text' => $message->title,
	'is_trusted' => true,
));

$delete_link = elgg_view("output/confirmlink", array(
						'href' => "action/procura_messages/delete?guid=" . $message->getGUID(),
						'text' => "<span class=\"elgg-icon elgg-icon-delete float-alt\"></span>",
						'confirm' => elgg_echo('deleteconfirm'),
						'encode_text' => false,
					));

$chequeo = "<input type='checkbox' name=\"message_id[]\" value=\"{$message->guid}\" />";

$body = <<<HTML
<div class="messages-owner">$user_link</div> 
<div class="messages-timestamp">$timestamp</div>
<div class="messages-subject">$subject_info</div>
<div class="messages-delete">$delete_link</div>
HTML;

if ($full) {        
	echo elgg_view_image_block($icon, $body, array('class' => $class));
	echo elgg_view('output/longtext', array('value' => $message->description));
} else {
        $icon = $chequeo.$icon;
	echo elgg_view_image_block($icon, $body, array('class' => $class));
}