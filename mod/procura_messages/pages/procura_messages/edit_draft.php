<?php
/**
 * Página que extrae la información de un borrador para su Edición
 * Lleva a la vista de Edición de Borrador
 * 
 */

// Sólo para usuarios logueados

gatekeeper();

// Obtener el borrador a tratar a partir de su id
$message_id = get_input('message_id', array());
$message = get_entity($message_id);

$page_owner = elgg_get_logged_in_user_entity();
elgg_set_page_owner_guid($page_owner->getGUID());

$title = elgg_echo('procura_messages:edit_draft');

elgg_push_breadcrumb($title);

$form_params = array(
    'id' => 'messages-edit-form',
    'class' => 'elgg-form',
    'action' => 'action/procura_messages/save', 
        );
$body_params = array('message' => $message);
$content .= elgg_view_form('procura_messages/edit_draft', $form_params, $body_params);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
