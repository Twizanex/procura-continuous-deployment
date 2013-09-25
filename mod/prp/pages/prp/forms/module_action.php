<?php
/*
 * prp/forms/module_action
 * Pagina para mostrar un formulario para componer las características de una accion
 */

// only admins should see this page
admin_gatekeeper();

// context will be help so we need to set to admin
elgg_set_context('admin');

// titulo
$title = elgg_echo('prp:pages:forms:module_action:title');

// recuperamos la accion del modulo
$action_name = get_input('action_name', $default = NULL);
$module_name = get_input('module_name', $default = NULL);
$module_action_entity = prp_get_module_action_entity($module_name, $action_name);
$form_vars = array(
    'module_action_entity' => $module_action_entity,
);

// mostramos el formulario
$content = elgg_view_form('prp/module_actions/save', null, $form_vars);

//TODO: añadir boton para cancelar
$content .= $back_button;

echo $content;
//// Visualizacion de la pagina
//// use special admin layout
//$body = elgg_view_layout('admin', array('content' => $content));
//echo elgg_view_page($title, $body, 'admin');

