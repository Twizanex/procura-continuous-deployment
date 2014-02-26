<?php

/**
 * actions/treatment/prescribe
 * Asigna uno o varios tratamientos a uno o varios usuarios, indicando informacion adicional y programacion temporal
 */
// Recuperamos los datos del formulario: treatment_guids, users_guids
$treatment_guids = get_input('treatment_guids', null);
if ($treatment_guids == null){
    $treatment_guids = array();
}
$user_guids = get_input('user_guids', null);
if ($user_guids == null){
    $user_guids = array();
}
$treatment_guid = get_input('treatment_guid', null);
if ($treatment_guid != null){
    array_push($treatment_guids, $treatment_guid);
}
$user_guid = get_input('user_guid', null);
if ($user_guid != null){
    array_push($user_guids, $user_guid);
}

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

// creamos las asignaciones
foreach ($treatment_guids as $treatment_guid) {
    foreach ($user_guids as $user_guid) {
        $result = treatments_prescribe_treatment($treatment_guid, $user_guid, $treatment_prescription_information);
        if (!$result) {
            break 2; // para salir de los dos foreach
        }
    }
}

if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment:prescribe:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment:prescribe:ok'));
    // Si el módulo de Procura_Notifications está activo, enviar notificación al usuario afectado
    if (elgg_is_active_plugin('procura_notifications')){
        $origen = elgg_get_logged_in_user_entity()->username;
        $usuario = get_user($user_guid);

        procura_notifications_send_notification(elgg_echo('treatments:notification:treatment_prescription:ok'), $origen, $usuario->username);
    }
}

// comprobamos si tenemos una pÃ¡gina de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward('treatments/treatment/list');
} else {
    forward($url_to_forward);
}