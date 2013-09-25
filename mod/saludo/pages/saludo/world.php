<?php
/**
 * All saludos
 *
 * @package Elggsaludo
 */

elgg_push_breadcrumb(elgg_echo('saludo'));

elgg_register_title_button();

$limit = get_input("limit", 10);

$title = elgg_echo('saludo:all');

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'saludo',
	'limit' => $limit,
	'full_view' => FALSE
));
if (!$content) {
	$content = elgg_echo('saludo:none');
}

$sidebar = saludo_get_type_cloud();
$sidebar = elgg_view('saludo/sidebar');

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
