<?php
/*
 * prp/forms/relation_name
 * Pagina para mostrar un formulario para componer las características de una relacion nueva
 */

// only admins should see this page
admin_gatekeeper();

// context will be help so we need to set to admin
elgg_set_context('admin');

// titulo
$title = elgg_echo('prp:pages:forms:relation_name:title');

// identificamos si se trata de un alta o modificacion
$relation_name = get_input('relation_name', $default = NULL);
$relation_name_entity = prp_get_relation_name($relation_name);
$form_vars = array(
    'relation_name_entity' => $relation_name_entity,
);

// mostramos el formulario
$content = elgg_view_form('prp/relations/names/save', null, $form_vars);

echo $content;
//// Visualizacion de la pagina
//// use special admin layout
//$body = elgg_view_layout('admin', array('content' => $content));
//echo elgg_view_page($title, $body, 'admin');

