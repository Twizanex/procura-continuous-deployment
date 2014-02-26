<?php
/*
 * treatments/treatment_prescription/edit
 * 
 * Formulario para asignar tratamientos
 * 
 * Utiliza:
 * - vars['entity'] => tratamiento asignado a modificar
 */

// recuperamos el tratamiento asignado
/* @var $treatment_prescription_entity ElggTreatmentPrescription */
$treatment_prescription_entity = elgg_extract('entity', $vars, null);
// Si no está definida, volvemos a la página anterior
if ($treatment_prescription_entity == null){
    forward(REFERRER);
}
$url_to_forward = elgg_extract('url_to_forward', $vars, null);

// informacion del formulario
$form_title = elgg_echo('treatments:forms:treatments_prescription:edit:title');
$form_info = elgg_echo('treatments:forms:treatments_prescription:edit:info');

// etiquetas para los campos
$treatment_label = elgg_echo('treatments:forms:treatments_prescription:edit:treatment_label');
$user_label = elgg_echo('treatments:forms:treatments_prescription:edit:user_label');
$user_instructions_label = elgg_echo('treatments:forms:treatments_prescription:edit:user_instructions_label');
$date_start_label = elgg_echo('treatments:forms:treatments_prescription:edit:date_start_label');
$date_end_label = elgg_echo('treatments:forms:treatments_prescription:edit:date_end_label');
$period_type_label = elgg_echo('treatments:forms:treatments_prescription:edit:period_type_label');
$period_label = elgg_echo('treatments:forms:treatments_prescription:edit:period_label');

// Tratamiento
$treatment = get_entity($treatment_prescription_entity->treatment_guid);
$treatment_output = elgg_view('output/text',array(
    'value'=>$treatment->name,
));

// Usuario
$user = get_user($treatment_prescription_entity->user_guid);
$user_output = elgg_view('output/text',array(
    'value'=>$user->name,
));

// Instrucciones
$user_instructions_input = elgg_view('input/longtext',array(
    'name' => 'user_instructions', 
    'value' => $treatment_prescription_entity->user_instructions, 
        ));

/* @var $treatment_schedule ElggTreatmentSchedule */
$treatment_schedule = get_entity($treatment_prescription_entity->treatment_schedule_guid);

// Date_start
$date_start_input = elgg_view('input/date', array(
    'name'=>'date_start',
    'value'=>$treatment_schedule->date_start,
        ));
// Date_end
$date_end_input = elgg_view('input/date', array(
    'name'=>'date_end',
    'value'=>$treatment_schedule->date_end,
        ));
// Period
$period_input = elgg_view('input/text',array(
    'name' => 'period', 
    'value'=>$treatment_schedule->period,
        ));

// Period_type
$period_type_options_values = array(
    elgg_echo('treatments:forms:treatments_prescription:edit:period_type:daily')=>1,
    elgg_echo('treatments:forms:treatments_prescription:edit:period_type:weekly')=>7,
    elgg_echo('treatments:forms:treatments_prescription:edit:period_type:monthly')=>30,
);
$period_type_input = elgg_view('input/radio',array(
    'name' => 'period_type',
    'align' => 'horizontal',
    'value'=>$treatment_schedule->period_type,
    'options' => $period_type_options_values,
        ));

// campos de formulario

$save_button = elgg_view('input/submit', array(
    'value' => elgg_echo('save')
));

$cancel_button = elgg_view("output/url", array(
    "text" => elgg_echo('cancel'),
    "title" => elgg_echo('cancel'),
    "href" => REFERRER,
    "class" => "elgg-button elgg-button-action"));


// campo oculto con la entidad
$treatment_prescription_guid_input_hidden = elgg_view('input/hidden', array(
    'name' => 'treatment_prescription_guid',
    'value' => $treatment_prescription_entity->guid,
        ));

// campo oculto con el tratamiento
$treatment_guid_input_hidden = elgg_view('input/hidden', array(
    'name' => 'treatment_guid',
    'value' => $treatment->guid,
        ));

// campo oculto con el usuario
$user_guid_input_hidden = elgg_view('input/hidden', array(
    'name' => 'user_guid',
    'value' => $user->guid,
        ));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $url_to_forward,
        ));

// composicion del formulario
$form_body = $treatment_prescription_guid_input_hidden;
$form_body .= $treatment_guid_input_hidden;
$form_body .= $user_guid_input_hidden;
$form_body .= $url_to_forward_input_hidden;
$form_body .= "<label>$treatment_label</label><br/>$treatment_output<br/>";
$form_body .= "<label>$user_label</label><br/>$user_output<br/>";
$form_body .= "<label>$user_instructions_label</label><br/>$user_instructions_input<br/>";
$form_body .= "<label>$date_start_label</label><br/>$date_start_input<br/>";
$form_body .= "<label>$date_end_label</label><br/>$date_end_input<br/>";
$form_body .= "<label>$period_type_label</label><br/>$period_type_input<br/>";
$form_body .= "<label>$period_label</label><br/>$period_input<br/>";
$form_body .= $cancel_button . $save_button;

//echo $form_body;
echo elgg_view_module('inline',$form_title, $form_body);
