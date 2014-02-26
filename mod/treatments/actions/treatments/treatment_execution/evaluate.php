<?php

/**
 * actions/treatment_execution/evaluate
 * Evalua la ejecución de un tratamento asignado
 */

// Recuperamos los datos del formulario
$treatment_execution_guid = get_input('treatment_execution_guid', null);
$date_executed = get_input('date_executed', null);
$execution_result = get_input('execution_result', null);
$not_executed = get_input('not_executed', null);
$user_feedback = get_input('user_feedback', null);
$date_evaluated = get_input('date_evaluated', null);
$prescriptor_evaluation = get_input('prescriptor_evaluation', null);

// informacion completa de la ejecucion
$treatment_execution_information = array();
if ($date_executed){
    $treatment_execution_information['date_executed'] = $date_executed;
}
if ($execution_result){
    $treatment_execution_information['execution_result'] = $execution_result;
}
if ($not_executed != null){
    $treatment_execution_information['not_executed'] = $not_executed;
}
if ($user_feedback){
    $treatment_execution_information['user_feedback'] = $user_feedback;
}
if ($date_evaluated){
    $treatment_execution_information['date_evaluated'] = $date_evaluated;
}
if ($prescriptor_evaluation){
    $treatment_execution_information['prescriptor_evaluation'] = $prescriptor_evaluation;
}


$result = treatments_save_treatment_execution($treatment_execution_guid, $treatment_execution_information);
if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment_execution:evaluate:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment_execution:evaluate:ok'));
}

// comprobamos si tenemos una pÃ¡gina de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward('treatments/treatment_execution/list');
} else {
    forward($url_to_forward);
}