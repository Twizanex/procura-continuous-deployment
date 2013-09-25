<?php
/**
 * Upload a new saludo
 *
 * @package Elggsaludo
 */

elgg_load_library('elgg:saludo');

$owner = elgg_get_page_owner_entity();

gatekeeper();
group_gatekeeper();

$title = elgg_echo('saludo:add');

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('saludo'), "saludo/all");
if (elgg_instanceof($owner, 'user')) {
	elgg_push_breadcrumb($owner->name, "saludo/owner/$owner->username");
} else {
	elgg_push_breadcrumb($owner->name, "saludo/group/$owner->guid/all");
}
elgg_push_breadcrumb($title);

// create form
$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = saludo_prepare_form_vars();
$content = elgg_view_form('saludo/upload', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
