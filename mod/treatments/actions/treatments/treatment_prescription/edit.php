<?php

/**
 * actions/treatment_prescription/edit
 * Modifica un tratamento asignado
 */

// recuperamos el tratamiento asignado
// Recuperamos los datos del formulario
$treatment_prescription_guid = get_input('treatment_prescription_guid', null);
$treatment_guid = get_input('treatment_guid', null);
$user_guid = get_input('user_guid', null);

// Informacion adicional de la prescricion del tratamiento
$user_instructions = get_input('user_instructions');

$treatment_schedule_array = array(
    'date_start' => get_input('treatment_date_start'),
    'date_end' => get_input('treatment_date_end'),
    'period' => get_input('period'),
    'period_type' => get_input('period_type'),
);
// informaciÃ³n completa de la prescripciÃ³n
$treatment_prescription_information = array(
    'user_instructions' => $user_instructions,
    'treatment_schedule' => $treatment_schedule_array,
);

// modificamos la asignacion
if ($treatment_guid){
    $treatment_prescription_information['treatment_guid'] = $treatment_guid;
}
if ($user_guid){
        $treatment_prescription_information['user_guid'] = $user_guid;
}

$result = treatments_save_treatment_prescription($treatment_prescription_guid, $treatment_prescription_information);
if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment_prescription:edit:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment_prescription:edit:ok'));
}

// comprobamos si tenemos una pagina de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward('treatments/treatment_prescription/list');
} else {
    forward($url_to_forward);
}