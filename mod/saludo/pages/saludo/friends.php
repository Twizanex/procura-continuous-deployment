<?php
/**
 * Friends saludos
 *
 * @package Elggsaludo
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('saludo/all');
}

elgg_push_breadcrumb(elgg_echo('saludo'), "saludo/all");
elgg_push_breadcrumb($owner->name, "saludo/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo("saludo:friends");

// offset is grabbed in list_user_friends_objects
$content = list_user_friends_objects($owner->guid, 'saludo', 10, false);
if (!$content) {
	$content = elgg_echo("saludo:none");
}

$sidebar = saludo_get_type_cloud($owner->guid, true);

$body = elgg_view_layout('content', array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
