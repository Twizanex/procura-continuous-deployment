<?php
/*
 * admin/profile_permisions
 * Muestra los permisos definidos para campos de perfil, permitiendo modificarlas y dar de alta nuevas relaciones
 */

// only admins should see this page
admin_gatekeeper();

// context will be help so we need to set to admin
elgg_set_context('admin');
// titulo
$title = elgg_echo('prp:pages:admin:profile_permissions:title');

// contenido
$content = elgg_view_title($title);
$content .= elgg_echo('prp:pages:admin:profile_permissions:info');

// recuperamos los campos de perfil definidos
$profile_permissions_list = prp_get_profile_permissions();

// Mostramos los tipos de relaciones
$vars = array(
    'profile_permissions_list' => $profile_permissions_list,
);
$content .= elgg_view('prp/profile_permissions/list', $vars);

// añadimos el botón para añadir nuevas permisos
$add_profile_permission_button = elgg_view("output/url", array(
    "text" => elgg_echo("add"), 
    "href" => $vars["url"] . "prp/forms/profile_permission", 
    "class" => "elgg-button elgg-button-action"));

// añadimos el botón para importar relaciones
$import_profile_permission_button = elgg_view("output/url", array(
    "text" => elgg_echo("import"), 
    "href" => elgg_add_action_tokens_to_url($vars["url"] . "action/prp/profile_permissions/import"), 
    "class" => "elgg-button elgg-button-action"));

// añadimos el botón para exportar relaciones
$export_profile_permission_button = elgg_view("output/url", array(
    "text" => elgg_echo("export"), 
    "href" => elgg_add_action_tokens_to_url($vars["url"] . "action/prp/profile_permissions/names/export"), 
    "class" => "elgg-button elgg-button-action"));

$content .= $add_profile_permission_button;
$content .= $import_profile_permission_button;
$content .= $export_profile_permission_button;

// Visualizacion de la pagina
// use special admin layout
$body = elgg_view_layout('admin', array('content' => $content));
echo elgg_view_page($title, $body, 'admin');