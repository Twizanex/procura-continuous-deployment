<?php
/**
 * relations/delete_all
 * Elimina todas las relaciones de un usuario
 */

// Recuperamos los datos del formulario
$subject_user_guid = get_input('subject_user_guid', $default = NULL);

// recuperamos el usuario
if ($subject_user_guid === NULL){ // usamos el usuario actual
    $subject_user = elgg_get_logged_in_user_entity();    
} else {
    $subject_user = get_user($subject_user_guid);
}

// eliminamos las relaciones
$result = prp_delete_all_relations($subject_user);
if (!$result) {
    register_error(elgg_echo('prp:actions:relations:delete_all:error'));
} else {
    system_message(elgg_echo('prp:actions:relations:delete_all:ok'));
}
// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERER);
} else {
    forward($url_to_forward);
}
