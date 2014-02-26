<?php
/**
* Página que lista los borradores
*/

gatekeeper();

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	register_error(elgg_echo());
	forward();
}

elgg_push_breadcrumb(elgg_echo('procura_messages:drafts'));

$title = elgg_echo('procura_messages:drafts', array($page_owner->name));

// Seleccionamos los objetos mensaje que tienen el campo 'borrador' a 1
$list = elgg_list_entities_from_metadata(array(
	'type' => 'object',    
	'subtype' => 'messages',
        'metadata_name_value_pair' => array(
        array('name' => 'fromId', 'value' => elgg_get_page_owner_guid()),
        array('name' => 'borrador', 'value' => 1)),
	'owner_guid' => elgg_get_page_owner_guid(),
	'full_view' => false,
));

$body_vars = array(
	'folder' => 'drafts',
	'list' => $list,
);
$content = elgg_view_form('procura_messages/process', array(), $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
