<?php
/**
 * treatments/treatment/delete
 * Elimina un tratamiento
 */

// Recuperamos los datos del formulario
$treatment_guid = get_input('treatment_guid', null);

if ($treatment_guid){
    // eliminamos el tratamiento
    $result = treatments_delete_treatment($treatment_guid);
}
if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment:delete:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment:delete:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERRER);
} else {
    forward($url_to_forward);
}