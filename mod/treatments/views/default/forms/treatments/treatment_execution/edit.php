<?php
/*
 * treatments/treatment_execution/edit
 * 
 * Formulario para modificar un registro de ejecucion de un tratamiento
 * 
 * Utiliza:
 * - vars['entity'] => ejecución de tratamiento asignado
 */

// recuperamos la ejecución del tratamiento
/* @var $treatment_execution_entity ElggTreatmentExecution */
$treatment_execution_entity = elgg_extract('entity', $vars, null);
// Si no está definida, volvemos a la página anterior
if ($treatment_execution_entity === null){
    forward(REFERRER);
}
$url_to_forward = elgg_extract('url_to_forward', $vars, null);

// informacion del formulario
$form_title = elgg_echo('treatments:forms:treatments_execution:edit:title');
$form_info = elgg_echo('treatments:forms:treatments_execution:edit:info');

// Tratamiento asignado
/* @var $treatment_prescription_entity ElggTreatmentPrescription */
$treatment_prescription_entity = get_entity($treatment_execution_entity->prescription_guid);
$treatment_prescription_view = elgg_view_entity($treatment_prescription_entity, array('full_view'=>false));

// Usuario
$user = get_user($treatment_execution_entity->user_guid);
$user_view = elgg_view_entity($user, array('full_view'=>false));

// not_executed
$not_executed_label = elgg_echo('treatments:forms:treatments_execution:edit:not_executed');
$not_executed_input = elgg_view('input/checkbox', array(
    'name'=>'not_executed',
    'value' => 1,
    'checked' => ($treatment_execution_entity->not_executed == true),
        ));

// Date_executed
$date_executed_label = elgg_echo('treatments:forms:treatments_execution:edit:date_executed');
$date_executed_input = elgg_view('input/date', array(
    'name'=>'date_executed',
    'value'=>$treatment_execution_entity->date_executed,
        ));

// execution_result
$execution_result_label = elgg_echo('treatments:forms:treatments_prescription:edit:label:execution_result');
$execution_result_options_values = array(
    elgg_echo('treatments:forms:treatments_prescription:edit:options:execution_result:ok')=>"OK",
    elgg_echo('treatments:forms:treatments_prescription:edit:options:execution_result:nok')=>"NOK",
);
$execution_result_input = elgg_view('input/radio',array(
    'name' => 'execution_result',
    'align' => 'vertical',
    'value'=>"OK",
    'options' => $execution_result_options_values,
        ));


// user_feedback
$user_feedback_label = elgg_echo('treatments:forms:treatments_execution:edit:user_feedback');
$user_feedback_input = elgg_view('input/longtext', array(
    'name'=>'user_feedback',
    'value'=>$treatment_execution_entity->user_feedback,
        ));


// Date_evaluated
$date_evaluated_label = elgg_echo('treatments:forms:treatments_execution:edit:date_evaluated');
$date_evaluated_input = elgg_view('input/date', array(
    'name'=>'date_evaluated',
    'value'=>$treatment_execution_entity->date_evaluated,
        ));

// prescriptor_evaluation
$prescriptor_evaluation_label = elgg_echo('treatments:forms:treatments_execution:edit:prescriptor_evaluation');
$prescriptor_evaluation_input = elgg_view('input/longtext', array(
    'name'=>'prescriptor_evaluation',
    'value'=>$treatment_execution_entity->prescriptor_evaluation,
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
$treatment_execution_guid_input_hidden = elgg_view('input/hidden', array(
    'name' => 'treatment_execution_guid',
    'value' => $treatment_execution_entity->guid,
        ));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $url_to_forward,
        ));

// composicion del formulario
$form_body = $treatment_execution_guid_input_hidden;
$form_body .= $url_to_forward_input_hidden;
$form_body .= elgg_view_module('inline', '', $treatment_prescription_view);
$form_body .= elgg_view_module('inline', '', $user_view);
$form_body .= elgg_view_module('inline', '', $execution_view);
$form_body .= "<label>$date_executed_label</label><br/>$date_executed_input<br/>";
$form_body .= "<label>$execution_result_label</label><br/>$execution_result_input<br/>";
$form_body .= "<label>$user_feedback_label</label><br/>$user_feedback_input<br/>";
$form_body .= "<label>$not_executed_label</label><br/>$not_executed_input<br/>";
$form_body .= "<label>$date_evaluated_label</label><br/>$date_evaluated_input<br/>";
$form_body .= "<label>$prescriptor_evaluation_label</label><br/>$prescriptor_evaluation_input<br/>";
$form_body .= $cancel_button . $save_button;

//echo $form_body;
echo elgg_view_module('inline',$form_title, $form_body);
