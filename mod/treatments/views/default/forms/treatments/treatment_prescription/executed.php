<?php
/*
 * treatments/treatment_prescription/executed
 * 
 * Formulario para registrar una ejecucion de tratamiento asignado
 * 
 * Utiliza:
 * - vars['entity'] => tratamiento asignado
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
$form_title = elgg_echo('treatments:forms:treatments_prescription:executed:title');
$form_info = elgg_echo('treatments:forms:treatments_prescription:executed:info');

// etiquetas para los campos
$execution_result_label = elgg_echo('treatments:forms:treatments_prescription:executed:label:execution_result');

// execution_result
$execution_result_options_values = array(
    elgg_echo('treatments:forms:treatments_prescription:executed:options:execution_result:ok')=>"OK",
    elgg_echo('treatments:forms:treatments_prescription:executed:options:execution_result:nok')=>"NOK",
);
$execution_result_input = elgg_view('input/radio',array(
    'name' => 'execution_result',
    'align' => 'vertical',
    'value'=>"OK",
    'options' => $execution_result_options_values,
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

// campo oculto con el usuario
$user_guid_input_hidden = elgg_view('input/hidden', array(
    'name' => 'user_guid',
    'value' => elgg_get_logged_in_user_guid(),
        ));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $url_to_forward,
        ));

// composicion del formulario
$form_body = $treatment_prescription_guid_input_hidden;
$form_body .= $user_guid_input_hidden;
$form_body .= $url_to_forward_input_hidden;
$form_body .= "<label>$execution_result_label</label><br/>$execution_result_input<br/>";
$form_body .= $cancel_button . $save_button;

//echo $form_body;
echo elgg_view_module('inline',$form_title, $form_body);
