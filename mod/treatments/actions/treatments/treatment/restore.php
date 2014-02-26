<?php
/**
 * treatments/treatment/restore
 * Recupera un tratamiento archivado
 */

// Recuperamos los datos del formulario
$treatment_guid = get_input('treatment_guid', null);

if ($treatment_guid){
    // restauramos el tratamiento
    $result = treatments_restore_treatment($treatment_guid);
}
if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment:restore:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment:restore:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERRER);
} else {
    forward($url_to_forward);
}