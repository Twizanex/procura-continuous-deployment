<?php
/**
 * treatments/treatment_prescription/restore
 * Recupera un tratamiento asignado
 */

// Recuperamos los datos del formulario
$treatment_prescription_guid = get_input('treatment_prescription_guid', null);

if ($treatment_prescription_guid){
    // restauramos el tratamiento asignado
    $result = treatments_restore_treatment_prescription($treatment_prescription_guid);
}
if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment_prescription:delete:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment_prescription:delete:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERRER);
} else {
    forward($url_to_forward);
}