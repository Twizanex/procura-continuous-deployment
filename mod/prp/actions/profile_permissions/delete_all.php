<?php
/**
 * relations/delete_all
 * Elimina todos los permisos de campo de perfil
 */

// No hay que recuperar datos del formulario, eliminamos directamente

// eliminamos las relaciones
$result = prp_delete_all_field_profile_permissions();
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
