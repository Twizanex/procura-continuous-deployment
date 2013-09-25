<?php
/*
 * prp/forms/relation
 * Pagina para mostrar un formulario para establecer una relación entre dos usuarios
 */

// only admins should see this page
//admin_gatekeeper();

// context will be help so we need to set to admin
//elgg_set_context('admin');

// titulo
$title = elgg_echo('prp:pages:forms:relation:title');

// recuperamos el usuario al que se le quiere establecer la relacion
$user_guid = get_input('user_guid', $default = NULL);
if ($user_guid === NULL){
    // recuperamos el usuario logado
    $subject_user = elgg_get_logged_in_user_entity();
} else {
    //identificamos el usuario solicitado
    $subject_user = get_entity($user_guid);
}

$form_vars = array(
    'subject_user' => $subject_user,
);

// mostramos el formulario
$content = elgg_view_form('prp/relations/add', null, $form_vars);

//TODO:
$content .= $back_button;

// Visualizacion de la pagina
$body = elgg_view_layout('one_sidebar', array('content' => $content));
echo elgg_view_page($title, $body);

