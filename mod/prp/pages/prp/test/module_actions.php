<?php
/*
 * test/module_actions
 * Listado de acciones (prueba)
 */

// only admins should see this page
//admin_gatekeeper();

// context will be help so we need to set to admin
//elgg_set_context('admin');
// titulo
$title = elgg_echo('prp:pages:test:module_actions:title');

// contenido
// recuperamos las acciones existentes
$module_actions_list = prp_get_module_actions();

// Mostramos los tipos de relaciones, indicando que es tipo test, para mostrar unos botones u otros
$vars = array(
    'module_actions_list' => $module_actions_list,
    'module_actions_view' => 'test',
);
$content = elgg_view('prp/module_actions/list', $vars);

// añadimos un botón para definir nuevas acciones
$add_module_action_button = elgg_view("output/url", array(
    "text" => elgg_echo("add"), 
    "href" => $vars["url"] . "prp/forms/add_module_action", 
    "class" => "elgg-button elgg-button-action"));

$content .= $add_module_action_button;

// Visualizacion de la pagina
// use special admin layout
$body = elgg_view_layout('one_sidebar', array('content' => $content));
//echo elgg_view_page($title, $body, 'admin');
echo elgg_view_page($title, $body);