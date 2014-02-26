<?php
/**
 * treatments/treatment_execution/restore
 * Restaura una ejecución de tratamiento asignado
 */

// Recuperamos los datos del formulario
$treatment_execution_guid = get_input('treatment_execution_guid', null);

if ($treatment_execution_guid){
    // restauramos la ejecución del tratamiento asignado
    $result = treatments_restore_treatment_execution($treatment_execution_guid);
}
if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment_execution:restore:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment_execution:restore:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERRER);
} else {
    forward($url_to_forward);
}