<?php

/*
 * Muestra un objeto ElggTreatmentSchedule
 */

// recuperamos la entidad
/* @var $treatment_schedule ElggTreatmentSchedule */
$treatment_schedule = $vars['entity'];
// TODO: comprobar tipo con elgg_instace_of

// comprobamos si se trata de la vista reducida o ampliada
if ($vars['full_view']) {
    // mostramos todos los atributos
    $title = elgg_view_title(elgg_echo('treatments:object:treatment_schedule:title'));
    $body = elgg_view_module('treatment-schedule-date-start', elgg_echo('treatments:object:treatment_schedule:label:date_start'), $treatment_schedule->date_start);
    $body .= elgg_view_module('treatment-schedule-date-end', elgg_echo('treatments:object:treatment_schedule:label:date_end'), $treatment_schedule->date_end);
    $treatment_period = $treatment_schedule->period . " " . $treatment_schedule->period_type;
    $body .= elgg_view_module('treatment-schedule-period', elgg_echo('treatments:object:treatment_schedule:label:period'), $treatment_period);
    echo elgg_view_module('treatment-schedule-full-view', $title, $body);
} else {
    // mostramos una vista resumida
    $title = elgg_view_title(elgg_echo('treatments:object:treatment_schedule:title'));
    $body = elgg_view_module('treatment-schedule-date-end', elgg_echo('treatments:object:treatment_schedule:label:date_end'), $treatment_schedule->date_end);
    echo elgg_view_module('treatment-schedule-summary-view', $title, $body);
}

