<?php
/**
 * View a saludo
 *
 * @package Elggsaludo
 */

$saludo = get_entity(get_input('guid'));

$owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb(elgg_echo('saludo'), 'saludo/all');

$crumbs_title = $owner->name;
if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "saludo/group/$owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "saludo/owner/$owner->username");
}

$title = $saludo->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($saludo, array('full_view' => true));
$content .= elgg_view_comments($saludo);

elgg_register_menu_item('title', array(
	'name' => 'download',
	'text' => elgg_echo('saludo:download'),
	'href' => "saludo/download/$saludo->guid",
	'link_class' => 'elgg-button elgg-button-action',
));

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
