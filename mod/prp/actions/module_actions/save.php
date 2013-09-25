<?php
/**
 * module_actions/save
 * Modifica los permisos de una acción de módulo
 */


// Recuperamos los datos del formulario
$module_name = get_input('module_name');
$action_name = get_input('action_name');

$requires_profile = get_input('requires_profile');
$requires_relation = get_input('requires_relation');
$requires_owner = get_input('requires_owner');
$required_profiles = get_input('required_profiles');
$required_relations = get_input('required_relations');
$action_permissions = array(
    'requires_profile' => ($requires_profile == 1),
    'requires_relation' => ($requires_relation == 1),
    'requires_owner' => ($requires_owner == 1),
    'required_profiles' => $required_profiles,
    'required_relations' => $required_relations,
);

// guardamos los permisos de la acción
$result = prp_save_module_action($module_name, $action_name, $action_permissions);

if (!$result) {
    register_error(elgg_echo('prp:actions:module_actions:save:error'));
} else {
    system_message(elgg_echo('prp:actions:module_actions:save:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERER);
} else {
    forward($url_to_forward);
}