<?php
/**
 * profile_permissions/delete
 * Elimina un permiso de campo de perfil
 */


// Recuperamos los datos del formulario
$permission_name = get_input('permission_name');

// eliminamos el permiso
$result = prp_delete_field_profile_permission($permission_name);
if (!$result) {
    register_error(elgg_echo('prp:actions:profile_permissions:delete:error'));
} else {
    system_message(elgg_echo('prp:actions:profile_permissions:delete:ok'));
}
// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERER);
} else {
    forward($url_to_forward);
}
