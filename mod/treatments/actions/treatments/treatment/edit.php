<?php
/**
 * treatments/treatment/save
 * Establece la informacion de un tratamiento
 * 
 */

// Recuperamos los datos del formulario
$treatment_guid = get_input('treatment_guid', null);

$treatment_information = array(
    'name' => get_input('treatment_name'),
    'description' => get_input('treatment_description'),
    'benefits' => get_input('treatment_benefits'),
    'instructions' => get_input('treatment_instructions'),
    'resources' => get_input('treatment_resources'),
    'category' => get_input('treatment_category'),
    'level'=> get_input('treatment_level'),
);

if ($treatment_guid){
    // guardamos los datos del tratamiento
    $result = treatments_save_treatment($treatment_guid, $treatment_information);
} else {
    // creamos el tratamiento
    $result = treatments_create_treatment($treatment_information);    
}
if (!$result) {
    register_error(elgg_echo('treatments:actions:treatment:edit:error'));
} else {
    system_message(elgg_echo('treatments:actions:treatment:edit:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERRER);
} else {
    forward($url_to_forward);
}