<?php
/**
 * profile_permissions/save
 * Añade un nuevo permiso de campo o modifica uno existente
 */


// Recuperamos los datos del formulario
$permission_name = get_input('permission_name');
$permission_title = get_input('permission_title');

$field_profiles = get_input('field_profiles');
$hide_to_owner = get_input('hide_to_owner');
$lock_to_owner = get_input('lock_to_owner');
$public_field = get_input('public_field');
$allowed_profiles = get_input('allowed_profiles');
$required_relations = get_input('required_relations');
$permission_config = array(
    'field_profiles' => $field_profiles,
    'hide_to_owner' => $hide_to_owner,
    'lock_to_owner' => $lock_to_owner,
    'public_field' => $public_field,
    'allowed_profiles' => $allowed_profiles,
    'required_relations' => $required_relations,
);

// comprobamos si existe el permiso
$profile_permission = prp_get_profile_permission($permission_name);
if ($profile_permission === NULL){// se trata de un alta nueva
    // Creamos el permiso
    $result = prp_add_profile_permission($permission_name, $permission_title, $permission_config);
} else {
    // guardamos el permiso
    $result = prp_save_profile_permission($permission_name, $permission_title, $permission_config);
}
if (!$result) {
    register_error(elgg_echo('prp:actions:profile_permissions:save:error'));
} else {
    system_message(elgg_echo('prp:actions:profile_permissions:save:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERER);
} else {
    forward($url_to_forward);
}
