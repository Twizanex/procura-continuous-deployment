<?php

/**
 * relations/names/delete
 * Elimina una relación existente
 */


// Recuperamos los datos del formulario
$relation_name = get_input('relation_name');

// eliminamos la relacion
$result = prp_delete_relation_name($relation_name);
if (!$result) {
    register_error(elgg_echo('prp:actions:relations:names:delete:error'));
} else {
    system_message(elgg_echo('prp:actions:relations:names:delete:ok'));
}
// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERER);
} else {
    forward($url_to_forward);
}
