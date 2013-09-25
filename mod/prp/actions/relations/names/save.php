<?php
/**
 * relations/names/save
 * Añade una nueva relación o modifica una existente
 */


// Recuperamos los datos del formulario
$relation_name = get_input('relation_name');
$relation_title = get_input('relation_title');
$subject_profiles = get_input('subject_profiles');
$object_profiles = get_input('object_profiles');
$allowed_profiles = get_input('allowed_profiles');
$relation_config = array(
    'subject_profiles' => $subject_profiles,
    'object_profiles' => $object_profiles,
    'allowed_profiles' => $allowed_profiles,
);

// comprobamos si existe la relacion
$relation = prp_get_relation_name($relation_name);
if ($relation === NULL){// se trata de un alta nueva
    // Creamos el tipo de relacion
    $result = prp_add_relation_name($relation_name, $relation_title, $relation_config);        
} else {
    // guardamos la relacion
    $result = prp_save_relation_name($relation_name, $relation_title, $relation_config);        
}
if (!$result) {
    register_error(elgg_echo('prp:actions:relations:names:save:error'));
} else {
    system_message(elgg_echo('prp:actions:relations:names:save:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERER);
} else {
    forward($url_to_forward);
}
