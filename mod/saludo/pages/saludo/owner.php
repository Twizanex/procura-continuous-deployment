<?php
/**
 * Individual's or group's saludos
 *
 * @package Elggsaludo
 */

// access check for closed groups
group_gatekeeper();

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('saludo/all');
}

elgg_push_breadcrumb(elgg_echo('saludo'), "saludo/all");
elgg_push_breadcrumb($owner->name);

elgg_register_title_button();

$params = array();

if ($owner->guid == elgg_get_logged_in_user_guid()) {
	// user looking at own saludos
	$params['filter_context'] = 'mine';
} else if (elgg_instanceof($owner, 'user')) {
	// someone else's saludos
	// do not show select a tab when viewing someone else's posts
	$params['filter_context'] = 'none';
} else {
	// group saludos
	$params['filter'] = '';
}

$title = elgg_echo("saludo:user", array($owner->name));

// List saludos
$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'saludo',
	'container_guid' => $owner->guid,
	'limit' => 10,
	'full_view' => FALSE,
));
if (!$content) {
	$content = elgg_echo("saludo:none");
}

$sidebar = saludo_get_type_cloud(elgg_get_page_owner_guid());
$sidebar = elgg_view('saludo/sidebar');

$params['content'] = $content;
$params['title'] = $title;
$params['sidebar'] = $sidebar;

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
