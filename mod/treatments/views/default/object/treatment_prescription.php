<?php

/*
 * Muestra un objeto ElggTreatmentPrescription
 */

// recuperamos el tratamiento asignado
/* @var $treatment_prescription ElggTreatmentPrescription */
$treatment_prescription = $vars['entity'];

// recuperamos el tratamiento
/* @var $treatment ElggTreatment */
//$treatment = treatments_get_treatment($treatment_prescription->treatment_guid);
$treatment = get_entity($treatment_prescription->treatment_guid);

// recuperamos la programacion
$treatment_schedule = get_entity($treatment_prescription->treatment_schedule_guid);


// informacion de la asignacion de tratamiento
/* @property int      $treatment_guid               Guid del tratamiento (plantilla)
 * @property ElggUser $user_guid                    Guid del usuario al que se prescribe el tratamiento
 * @property DateTime $date_assigned                Fecha de asignacion
 * @property String   $user_instructions            Instrucciones especificas para el usuario (para mostrar como pop-up)
 * @property bool     $is_viewed                    Registra si el usuario ha visualizado el tratamiento
 * @property String   $treatment_schedule_guid      Programacion del tratamiento (guid de la entidad)
 * @property Array    $treatment_execution_guids    Vector para almacenar las ejecuciones del tratamiento
 * @property bool     $is_archived     Flag para marcar que la prescripción está archivada (no eliminado) (invisible)
*/


// comprobamos si se trata de la vista reducida o ampliada
if ($vars['full_view']) {
    // mostramos todos los atributos
    $title = elgg_view_title($treatment->name);
    // programacion tratamiento
    $body = elgg_view_entity($treatment_schedule, array('full_view'=>TRUE));
    // instrucciones
    $body .= elgg_view_module('treatment-user-instructions', elgg_echo('treatments:object:treatment_prescription:label:user_instructions'), $treatment_prescription->user_instructions);
    // tratamiento
    $body .= elgg_view_entity($treatment, array('full_view'=>TRUE));
    echo elgg_view_module('treatment-prescription-full-view', $title, $body);    
} else {
    // mostramos una vista resumida
    $title = elgg_view_title($treatment->name);
    // tratamiento
    $body = elgg_view_entity($treatment, array('full_view'=>FALSE));
    // programacion tratamiento
    $body .= elgg_view_entity($treatment_schedule, array('full_view'=>FALSE));
    echo elgg_view_module('treatment-prescription-summary-view', $title, $body);
}

