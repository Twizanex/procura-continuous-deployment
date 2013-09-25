<?php
/*
 * prp/forms/add_module_action
 * Pagina para mostrar un formulario para dar de alta una nueva accion de modulo
 */

// only admins should see this page
//admin_gatekeeper();

// context will be help so we need to set to admin
//elgg_set_context('admin');

// titulo
$title = elgg_echo('prp:pages:forms:add_module_action:title');

// mostramos el formulario
$content = elgg_view_form('prp/module_actions/add');

//TODO: añadir boton para cancelar
$content .= $back_button;

// Visualizacion de la pagina
// use special admin layout
$body = elgg_view_layout('one_sidebar', array('content' => $content));
//echo elgg_view_page($title, $body, 'admin');
echo elgg_view_page($title, $body);

