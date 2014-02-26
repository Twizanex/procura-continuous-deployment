<?php

/**
 * actions/treatment_execution/register
 * Permite proporcionar la evaluación del usuario sobre un tratamiento realizado
 */

// Recuperamos los datos del formulario
$treatment_execution_guid = get_input('treatment_execution_guid', null);
$user_feedback = get_input('user_feedback', null);

// informacion completa de la ejecucion
$treatment_execution_information = array();
if ($user_feedback){
    $treatment_execution_information['user_feedback'] = $user_feedback;
}


$result = treatments_save_treatment_execution($treatment_execution_guid, $treatment_execution_information);
if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment_execution:register:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment_execution:register:ok'));
}

// comprobamos si tenemos una pÃ¡gina de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward('treatments/treatment_prescription/list');
} else {
    forward($url_to_forward);
}