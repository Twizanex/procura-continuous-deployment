<?php
/**
 * Upload a saludo through the embed interface
 */

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-embed',
);
$body_vars = array('container_guid' => elgg_get_page_owner_guid());
echo elgg_view_form('saludo/upload', $form_vars, $body_vars);

// the tab we want to be forwarded to after upload is complete
echo elgg_view('input/hidden', array(
	'name' => 'embed_forward',
	'value' => 'saludo',
));