<?php
/*
 * admin/relation_names
 * Muestra los tipos de relaciones permitidas, permitiendo modificarlas y dar de alta nuevas relaciones
 */

// only admins should see this page
admin_gatekeeper();

// context will be help so we need to set to admin
elgg_set_context('admin');
// titulo
$title = elgg_echo('prp:pages:admin:relation_names:title');

// contenido
$content = elgg_view_title($title);
$content .= elgg_echo('prp:pages:admin:relation_names:info');

// recuperamos los tipos de relaciones existentes
$relation_names_list = prp_get_relation_names();

// Mostramos los tipos de relaciones
$vars = array(
    'relation_names_list' => $relation_names_list,
);
$content .= elgg_view('prp/relations/names/list', $vars);

// añadimos el botón para añadir nuevas relaciones
$add_relation_name_button = elgg_view("output/url", array(
    "text" => elgg_echo("add"), 
    "href" => $vars["url"] . "prp/forms/relation_name", 
    "class" => "elgg-button elgg-button-action"));

// añadimos el botón para importar relaciones
$import_relation_name_button = elgg_view("output/url", array(
    "text" => elgg_echo("import"), 
    "href" => elgg_add_action_tokens_to_url($vars["url"] . "action/prp/relations/names/import"), 
    "class" => "elgg-button elgg-button-action"));

// añadimos el botón para exportar relaciones
$export_relation_name_button = elgg_view("output/url", array(
    "text" => elgg_echo("export"), 
    "href" => elgg_add_action_tokens_to_url($vars["url"] . "action/prp/relations/names/export"), 
    "class" => "elgg-button elgg-button-action"));

$content .= $add_relation_name_button;
$content .= $import_relation_name_button;
$content .= $export_relation_name_button;

// Visualizacion de la pagina
// use special admin layout
$body = elgg_view_layout('admin', array('content' => $content));
echo elgg_view_page($title, $body, 'admin');