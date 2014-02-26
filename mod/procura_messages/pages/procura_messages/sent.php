<?php
/**
* Elgg sent messages page
*
* @package ElggMessages
*/

gatekeeper();

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	register_error(elgg_echo());
	forward();
}

elgg_push_breadcrumb(elgg_echo('messages:sent'));

//elgg_register_title_button();

$title = elgg_echo('messages:sentmessages', array($page_owner->name));

$list = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'messages',
        'metadata_name_value_pair' => array(
            array('name' => 'fromId', 'value' => elgg_get_page_owner_guid()),
            array('name' => 'borrador', 'value' => 0)),
	'owner_guid' => elgg_get_page_owner_guid(),
	'full_view' => false,
));

$body_vars = array(
	'folder' => 'sent',
	'list' => $list,
);
$content = elgg_view_form('procura_messages/process', array(), $body_vars);

$body = elgg_view_layout('content', array(
//$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
