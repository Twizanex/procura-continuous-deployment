<?php
/**
 * Edit a saludo
 *
 * @package Elggsaludo
 */

elgg_load_library('elgg:saludo');

gatekeeper();

$saludo_guid = (int) get_input('guid');
$saludo = new ElggSaludo($saludo_guid);
if (!$saludo) {
	forward();
}
if (!$saludo->canEdit()) {
	forward();
}

$title = elgg_echo('saludo:edit');

elgg_push_breadcrumb(elgg_echo('saludo'), "saludo/all");
elgg_push_breadcrumb($saludo->title, $saludo->getURL());
elgg_push_breadcrumb($title);

elgg_set_page_owner_guid($saludo->getContainerGUID());

$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = saludo_prepare_form_vars($saludo);

$content = elgg_view_form('saludo/upload', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
