<?php
/**
 * treatments/treatment/archive
 * Archiva un tratamiento
 */

// Recuperamos los datos del formulario
$treatment_guid = get_input('treatment_guid', null);

if ($treatment_guid){
    // archivamos el tratamiento
    $result = treatments_archive_treatment($treatment_guid);
}
if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment:archive:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment:archive:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERRER);
} else {
    forward($url_to_forward);
}