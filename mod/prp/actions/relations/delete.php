<?php
/**
 * relations/delete
 * Elimina una relación existente entre dos usuarios
 */


// Recuperamos los datos del formulario
$relation_name = get_input('relation_name');
$subject_user_guid = get_input('subject_user_guid', $default = NULL);
$object_user_guid = get_input('object_user_guid');

// recuperamos los usuarios
if ($subject_user_guid === NULL){ // usamos el usuario actual
    $subject_user = elgg_get_logged_in_user_entity();    
} else {
    $subject_user = get_user($subject_user_guid);
}

$object_user = get_user($object_user_guid);


// eliminamos la relacion
$result = prp_delete_relation($subject_user, $object_user, $relation_name);
if (!$result) {
    register_error(elgg_echo('prp:actions:relations:delete:error'));
} else {
    system_message(elgg_echo('prp:actions:relations:delete:ok'));
}
// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERER);
} else {
    forward($url_to_forward);
}
