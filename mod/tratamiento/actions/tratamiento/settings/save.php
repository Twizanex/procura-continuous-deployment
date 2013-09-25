<?php
error_log("accion settings personalizada");
elgg_log("accion settings personalizada","WARNING");

$params = get_input('params');

$title = get_input('title');
// Add category
$category = new ElggTratamientoCategory();
$category->subtype = 'tratamientoCategory';
$category->title = $title;
$category->access_id = ACCESS_PUBLIC; // Sino, luego al buscarlas en otros sitios no se ven...
$category->save();

foreach ($params as $k => $v) {
	$result = $plugin->setSetting($k, $v);
//	if (!$result) {
//		register_error(elgg_echo('plugins:settings:save:fail', array($plugin_name)));
//		forward(REFERER);
//		exit;
//	}
}
//forward(REFERER);
forward('admin/plugin_settings/tratamiento');