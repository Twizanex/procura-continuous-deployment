<?php

/*
 * Muestra un objeto ElggTreatmentExecution
 */

// recuperamos el tratamiento ejecutado
/* @var $treatment_execution ElggTreatmentExecution */
$treatment_execution = $vars['entity'];

// recuperamos el tratamiento asignado
/* @var $treatment_prescription ElggTreatmentPrescription */
$treatment_prescription = treatments_get_prescribed_treatment($treatment_execution->prescription_guid);

// recuperamos el tratamiento
/* @var $treatment ElggTreatment */
$treatment = treatments_get_treatment($treatment_prescription->treatment_guid);

// comprobamos si se trata de la vista reducida o ampliada
if ($vars['full_view']) {
    // mostramos todos los atributos
    $title = elgg_view_title($treatment->name);
    $body = elgg_view_entity($treatment_prescription,array("full_view"=>FALSE));
    // resultado de la ejecucion
    if ($treatment_execution->not_executed){
        $body .= elgg_view_module('treatment-execution-execution-result', 
                elgg_echo('treatments:object:treatment_execution:label:execution_result'), 
                elgg_echo('treatments:object:treatment_execution:treatment_not_executed'));
        $body .= elgg_view_module('treatment-execution-date-executed', 
                elgg_echo('treatments:object:treatment_execution:label:date_not_executed'), 
                $treatment_execution->date_executed);
    } else {
        $body .= elgg_view_module('treatment-execution-result', 
                elgg_echo('treatments:object:treatment_execution:label:execution_result'), 
                $treatment_execution->execution_result);
        $body .= elgg_view_module('treatment-execution-date-executed', 
                elgg_echo('treatments:object:treatment_execution:label:date_executed'), 
                $treatment_execution->date_executed);
        $body .= elgg_view_module('treatment-execution-user-feedback', 
                elgg_echo('treatments:object:treatment_execution:label:user_feedback'), 
                $treatment_execution->user_feedback);
    }
    if (!$treatment_execution->date_evaluated){
        $treatment_evaluation_result = elgg_echo('treatments:object:treatment_execution:treatment_not_evaluated');
    } else {
        $treatment_evaluation_result = elgg_view_module('treatment-execution-date-evaluated', 
                elgg_echo('treatments:object:treatment_execution:label:date_evaluated'), 
                $treatment_execution->date_evaluated);
        $treatment_evaluation_result .= elgg_view_module('treatment-execution-prescriptor_evaluation', 
                elgg_echo('treatments:object:treatment_execution:label:prescriptor_evaluation'), 
                $treatment_execution->prescriptor_evaluation);
    }
    $body .= elgg_view_module('treatment-execution-evaluation-result', elgg_echo('treatments:object:treatment_execution:label:evaluation_result'), $treatment_evaluation_result);
    echo elgg_view_module('treatment-execution-full-view', $title, $body);
} else {
    // mostramos una vista resumida
    $title = elgg_view_title($treatment->name);
    $body = elgg_view_entity($treatment, array("full_view"=>FALSE));
    if ($treatment_execution->not_executed){
        $treatment_is_executed = elgg_echo('treatments:object:treatment_execution:treatment_not_executed');
    } else {
        $treatment_is_executed = elgg_echo('treatments:object:treatment_execution:treatment_executed');
    }
    $body .= elgg_view_module('treatment-execution-is-executed', elgg_echo('treatments:object:treatment_execution:label:is_executed'), $treatment_is_executed);
    if (!$treatment_execution->date_evaluated){
        $treatment_is_evaluated = elgg_echo('treatments:object:treatment_execution:treatment_not_evaluated');
    } else {
        $treatment_is_evaluated = elgg_echo('treatments:object:treatment_execution:treatment_evaluated');
    }
    $body .= elgg_view_module('treatment-execution-is-evaluated', elgg_echo('treatments:object:treatment_execution:label:is_evaluated'), $treatment_is_evaluated);
    echo elgg_view_module('treatment-execution-summary-view', $title, $body);
}

