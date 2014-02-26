<?php

/**
 * actions/treatment_prescription/executed
 * Crea una ejecuión de tratamiento asicnado
 */

// Recuperamos los datos del formulario
$treatment_prescription_guid = get_input('treatment_prescription_guid', null);
$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$date_executed = get_input('date_executed', date(time()));
$execution_result = get_input('execution_result', null);

$treatment_execution_information = array(
    'execution_result'=>$execution_result,
    'date_executed'=>$date_executed,
    'user_guid'=>$user_guid,    
);
        
$result = treatments_register_treatment_execution($treatment_prescription_guid, $treatment_execution_information);

if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment_prescription:executed:error'));
    forward(REFERRER);
} else {
    system_message(elgg_echo('treatments:actions:treatment_prescription:executed:ok'));
}

// comprobamos si tenemos una pÃ¡gina de redireccion
$url_to_forward = get_input('url_to_forward', null);
if ($url_to_forward === NULL) {
    forward("treatments/treatment_execution/register?treatment_execution_guid=$result->guid");
} else {
    forward($url_to_forward);
}