<?php
/*
 * treatments/treatment/prescribe
 * 
 * Formulario para asignar tratamientos
 * 
 * Utiliza:
 * - vars['treatment_guid'] => para preseleccionar el tratamiento a asginar
 * - vars['user_guid'] => para preselecionar el usuario a asginar
 */

// recuperamos parámetros de entrada
$treatment_guid = elgg_extract('treatment_guid', $vars, null);
$user_guid = elgg_extract('user_guid', $vars, null);
$url_to_forward = elgg_extract('url_to_forward', $vars, REFERER);


// informacion del formulario
$form_title = elgg_echo('treatments:forms:treatment:prescribe:title');
$form_info = elgg_echo('treatments:forms:treatment:prescribe:info');

// etiquetas para los campos
$treatment_label = elgg_echo('treatments:forms:treatment:prescribe:treatment_label');
$user_label = elgg_echo('treatments:forms:treatment:prescribe:user_label');
$user_instructions_label = elgg_echo('treatments:forms:treatment:prescribe:user_instructions_label');
$date_start_label = elgg_echo('treatments:forms:treatment:prescribe:date_start_label');
$date_end_label = elgg_echo('treatments:forms:treatment:prescribe:date_end_label');
$period_type_label = elgg_echo('treatments:forms:treatment:prescribe:period_type_label');
$period_label = elgg_echo('treatments:forms:treatment:prescribe:period_label');

// TRATAMIENTOS
// recuperamos los tratamientos asignables (no archivados)
$treatment_list = treatments_get_treatments();
$treatment_options_values = array();
foreach ($treatment_list as $treatment) {
    /* @var $treatment ElggTreatment */
    $treatment_options_values["$treatment->guid"] = $treatment->name;
}
// dropdown para seleccionar el tratamiento
$treatment_input = elgg_view('input/dropdown', array(
    'name' => 'treatment_guid',
    'value' => $treatment_guid,
    'options_values' => $treatment_options_values,
        ));

// USUARIOS
// recuperamos los usuarios que tienen relación con el usuario actual
$user_list = prp_get_related_users(elgg_get_logged_in_user_entity());
$user_list = elgg_get_entities(array(
    'types' => 'user',    
    'limit' => false,
));
$user_options_values = array();
foreach ($user_list as $user) {
    /* @var $user ElggUser */
    $user_options_values["$user->guid"] = $user->name;
}
// dropdown para seleccionar el usuario
$user_input = elgg_view('input/dropdown', array(
    'name' => 'user_guid',
    'value' => $user_guid,
    'options_values' => $user_options_values,
        ));

// Instrucciones
$user_instructions_input = elgg_view('input/longtext',array(
    'name' => 'user_instructions', 
        ));

// Date_start
$date_start_input = elgg_view('input/date', array(
    'name'=>'date_start',
        ));
// Date_end
$date_end_input = elgg_view('input/date', array(
    'name'=>'date_end',
        ));
// Period
$period_input = elgg_view('input/text',array(
    'name' => 'period', 
        ));

// Period_type
$period_type_options_values = array(
    elgg_echo('treatments:forms:treatment:prescribe:period_type:daily')=>1,
    elgg_echo('treatments:forms:treatment:prescribe:period_type:weekly')=>7,
    elgg_echo('treatments:forms:treatment:prescribe:period_type:monthly')=>30,
);
$period_type_input = elgg_view('input/radio',array(
    'name' => 'period_type',
    'align' => 'horizontal',
    'value' => 1,
    'options' => $period_type_options_values,
        ));

//TODO: terminat formulario, añadir programación del tratamiento
// campos de formulario

$save_button = elgg_view('input/submit', array(
    'value' => elgg_echo('save')
));

$cancel_button = elgg_view("output/url", array(
    "text" => elgg_echo('cancel'),
    "title" => elgg_echo('cancel'),
    "href" => $url_to_forward,
    "class" => "elgg-button elgg-button-action"));


// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $url_to_forward,
        ));

// composicion del formulario
$form_body = $url_to_forward_input_hidden;
$form_body .= "<label>$treatment_label</label><br/>$treatment_input<br/>";
$form_body .= "<label>$user_label</label><br/>$user_input<br/>";
$form_body .= "<label>$user_instructions_label</label><br/>$user_instructions_input<br/>";
$form_body .= "<label>$date_start_label</label><br/>$date_start_input<br/>";
$form_body .= "<label>$date_end_label</label><br/>$date_end_input<br/>";
$form_body .= "<label>$period_type_label</label><br/>$period_type_input<br/>";
$form_body .= "<label>$period_label</label><br/>$period_input<br/>";
$form_body .= $cancel_button . $save_button;

//echo $form_body;
echo elgg_view_module('inline',$form_title, $form_body);
