<?php
/**
* Compose a message
*
* @package ElggMessages
*/

gatekeeper();

$page_owner = elgg_get_logged_in_user_entity();
elgg_set_page_owner_guid($page_owner->getGUID());

$title = elgg_echo('messages:add');

elgg_push_breadcrumb($title);

$params = pr_messages_prepare_form_vars((int)get_input('send_to'));
//$params['friends'] = $page_owner->getFriends('', 50);

// Queremos que se puedan enviar mensajes sólo a nuestros contactos (amigos y contactos), a excepción del adminsitrador, que podrá a todos
//$params['friends'] = prp_get_related_users($page_owner);
$params['friends'] = pr_get_users_conected_to_by_profile($page_owner);
$content = elgg_view_form('procura_messages/send', array(), $params);

$body = elgg_view_layout('content', array(
//$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
