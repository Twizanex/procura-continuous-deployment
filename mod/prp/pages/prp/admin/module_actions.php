<?php
/*
 * admin/module_actions
 * Muestra las acciones de módulo registradas, permitiendo modificarlas
 */

// only admins should see this page
admin_gatekeeper();

// context will be help so we need to set to admin
elgg_set_context('admin');
// titulo
$title = elgg_echo('prp:pages:admin:module_actions:title');

// contenido
$content = elgg_view_title($title);
$content .= elgg_echo('prp:pages:admin:module_actions:info');

// recuperamos las acciones existentes
$module_actions_list = prp_get_module_actions();

// Mostramos los tipos de relaciones, indicando que es tipo admin, para mostrar unos botones u otros
$vars = array(
    'module_actions_list' => $module_actions_list,
    'module_actions_view' => 'admin',
);
$content .= elgg_view('prp/module_actions/list', $vars);

// añadimos el botón para importar acciones
$import_module_action_button = elgg_view("output/url", array(
    "text" => elgg_echo("import"), 
    "href" => elgg_add_action_tokens_to_url($vars["url"] . "action/prp/module_actions/import"), 
    "class" => "elgg-button elgg-button-action"));

// añadimos el botón para exportar acciones
$export_module_action_button = elgg_view("output/url", array(
    "text" => elgg_echo("export"), 
    "href" => elgg_add_action_tokens_to_url($vars["url"] . "action/prp/module_actions/export"), 
    "class" => "elgg-button elgg-button-action"));

$content .= $import_module_action_button;
$content .= $export_module_action_button;

// Visualizacion de la pagina
// use special admin layout
$body = elgg_view_layout('admin', array('content' => $content));
echo elgg_view_page($title, $body, 'admin');