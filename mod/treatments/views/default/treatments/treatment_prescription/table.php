<?php

/*
 * treatments/treatment_prescription/table
 * Vista para mostrar una tabla con los tratamientos asignados definidos
 * Utiliza:
 * - $vars['treatment_prescription_list']: lista de tratamientos asignados
 * - $vars['execute_treament_permission']: Indica si se tienen permisos para ejecutar tratamientos asignados, añadiendo el botón correspondientes (execute)
 * - $vars['prescribe_treatment_permission']: Indica si se tienen permisos para asignar tratamientos, añadiendo los botones correspondientes (edit, archive)
 * 
 * Nota. Para el administrator, se incluyen las acciones delete y restore
 */

// recuperamos los tratamientos asignados
$treatment_prescription_list = elgg_extract('treatment_prescription_list', $vars);
$execute_treament_permission = elgg_extract('execute_treament_permission', $vars, false);
$prescribe_treatment_permission = elgg_extract('prescribe_treatment_permission', $vars, false);

// preparamos los encabezados
$table_header = array(
    elgg_echo('treatments:views:treatment_prescription:table:name'),
    elgg_echo('treatments:views:treatment_prescription:table:category'),
    elgg_echo('treatments:views:treatment_prescription:table:level'),
    elgg_echo('treatments:views:treatment_prescription:table:date_end'),    
    elgg_echo('treatments:views:treatment_prescription:table:actions'),
);


// preparamos el contenido
elgg_load_js('lightbox');
elgg_load_css('lightbox');


$table_rows = array();
/* @var $treatment_prescription ElggTreatmentPrescription */
foreach ($treatment_prescription_list as $treatment_prescription) {
    // preparamos iconos para acciones sobre cada tratamiento
    $treatment_prescription_view_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_prescription:table:button:view:title'),
        "href" => $vars["url"] . "treatments/treatment_prescription/view?treatment_prescription_guid=$treatment_prescription->guid&pop_up=yes",
        "class" => "elgg-icon elgg-icon-info elgg-lightbox"));
    $treatment_prescription_edit_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_prescription:table:button:edit:title'),
        "href" => $vars["url"] . "treatments/treatment_prescription/edit?treatment_prescription_guid=$treatment_prescription->guid",
        "class" => "elgg-icon elgg-icon-settings-alt"));
    $treatment_prescription_archive_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_prescription:table:button:archive:title'),
        "onclick" => "treatmentsArchiveTreatmentPrescription('$treatment_prescription->guid');",
        "class" => "elgg-icon elgg-icon-trash"));
    $treatment_prescription_restore_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_prescription:table:button:restore:title'),
        "onclick" => "treatmentsRestoreTreatmentPrescription('$treatment_prescription->guid');",
        "class" => "elgg-icon elgg-icon-undo"));
    $treatment_prescription_delete_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_prescription:table:button:delete:title'),
        "onclick" => "treatmentsDeleteTreatmentPrescription('$treatment_prescription->guid');",
        "class" => "elgg-icon elgg-icon-delete"));
    $treatment_prescription_execute_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_prescription:table:button:execute:title'),
        "href" => $vars["url"] . "treatments/treatment_prescription/execute?treatment_prescription_guid=$treatment_prescription->guid",
        "class" => "elgg-icon elgg-icon-arrow_left"));

    // Determinamos las acciones a mostrar en función de si el tratamiento está 
    // activo o no y los permisos
    $treatment_prescription_actions = $treatment_prescription_view_button;
    if ($treatment_prescription->is_archived) {
        if (elgg_is_admin_logged_in()) {
            $treatment_prescription_actions .= $treatment_prescription_restore_button . $treatment_prescription_delete_button;
        }
    } else {
        if ($prescribe_treatment_permission) {
            $treatment_prescription_actions .= $treatment_prescription_edit_button . $treatment_prescription_archive_button;
        }
        if ($execute_treament_permission) {
            $treatment_prescription_actions .= $treatment_prescription_execute_button;
        }
        if (elgg_is_admin_logged_in()) {
            $treatment_prescription_actions .= $treatment_prescription_delete_button;
        }
    }
    $treatment = get_entity($treatment_prescription->treatment_guid);
    $treatment_schedule = get_entity($treatment_prescription->treatment_schedule_guid);
    $table_row = array(
        $treatment->name,
        $treatment->category,
        $treatment->level,
        $treatment_schedule->date_end,
        $treatment_prescription_actions,
    );

    // acumulamos la fila
    array_push($table_rows, $table_row);
}

// mostramos la tabla
echo elgg_view('page/components/table', array(
    'columns' => $table_header,
    'rows' => $table_rows,
));

