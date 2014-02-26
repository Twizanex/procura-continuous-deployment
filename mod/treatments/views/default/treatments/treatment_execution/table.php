<?php

/*
 * treatments/treatment_execution/table
 * Vista para mostrar una tabla con las ejecuciones de tratamientos asignados
 * Utiliza:
 * - $vars['treatment_execution_list']: lista de tratamientos ejecutados
 * - $vars['manage_treatment_execution_permission']: Indica si se tienen permisos para gestioanr ejecuciones de tratamientos, añadiendo los botónes correspondientes (evaluate, archive, edit)
 * 
 * Nota. Para el administrator, se incluyen las acciones delete y restore
 */

// recuperamos los tratamientos asignados
$treatment_execution_list = elgg_extract('treatment_prescription_list', $vars);
$manage_treatment_execution_permission = elgg_extract('manage_treatment_execution_permission', $vars, false);

// preparamos los encabezados
$table_header = array(
    elgg_echo('treatments:views:treatment_execution:table:name'),
    elgg_echo('treatments:views:treatment_execution:table:category'),
    elgg_echo('treatments:views:treatment_execution:table:is_executed'),
    elgg_echo('treatments:views:treatment_execution:table:date_executed'),
    elgg_echo('treatments:views:treatment_execution:table:is_evaluated'),
    elgg_echo('treatments:views:treatment_execution:table:date_evaluated'),
    elgg_echo('treatments:views:treatment_execution:table:actions'),
);


// preparamos el contenido
elgg_load_js('lightbox');
elgg_load_css('lightbox');


$table_rows = array();
/* @var $treatment_execution ElggTreatmentExecution */
foreach ($treatment_execution_list as $treatment_execution) {
    // preparamos iconos para acciones sobre cada tratamiento
    $treatment_execution_view_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_execution:table:button:view:title'),
        "href" => $vars["url"] . "treatments/treatment_prescription/view?treatment_prescription_guid=$treatment_execution->guid&pop_up=yes",
        "class" => "elgg-icon elgg-icon-info elgg-lightbox"));
    $treatment_execution_edit_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_execution:table:button:edit:title'),
        "href" => $vars["url"] . "treatments/treatment_prescription/edit?treatment_prescription_guid=$treatment_execution->guid",
        "class" => "elgg-icon elgg-icon-settings-alt"));
    $treatment_execution_archive_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_execution:table:button:archive:title'),
        "onclick" => "treatmentsArchiveTreatmentPrescription('$treatment_execution->guid');",
        "class" => "elgg-icon elgg-icon-trash"));
    $treatment_execution_restore_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_execution:table:button:restore:title'),
        "onclick" => "treatmentsRestoreTreatmentPrescription('$treatment_execution->guid');",
        "class" => "elgg-icon elgg-icon-undo"));
    $treatment_execution_delete_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_execution:table:button:delete:title'),
        "onclick" => "treatmentsDeleteTreatmentPrescription('$treatment_execution->guid');",
        "class" => "elgg-icon elgg-icon-delete"));
    $treatment_execution_evaluate_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment_execution:table:button:evaluate:title'),
        "href" => $vars["url"] . "treatments/treatment_execution/evaluate?treatment_prescription_guid=$treatment_execution->guid",
        "class" => "elgg-icon elgg-icon-arrow_left"));

    // Determinamos las acciones a mostrar en función de si el tratamiento está 
    // activo o no y los permisos
    $treatment_execution_actions = $treatment_execution_view_button;
    if ($treatment_execution->is_archived) {
        if (elgg_is_admin_logged_in()) {
            $treatment_execution_actions .= $treatment_execution_restore_button . $treatment_execution_delete_button;
        }
    } else {
        if ($manage_treatment_execution_permission) {
            $treatment_execution_actions .= $treatment_execution_evaluate_button . $treatment_execution_archive_button. $treatment_execution_edit_button;
        }
        if (elgg_is_admin_logged_in()) {
            $treatment_execution_actions .= $treatment_execution_delete_button;
        }
    }
    $treatment_prescription = treatments_get_prescribed_treatment($treatment_execution->prescription_guid);
    $treatment = treatments_get_treatment($treatment_prescription->treatment_guid);
    if ($treatment_execution->not_executed){
        $treatment_is_executed = elgg_echo('treatments:views:treatment_execution:table:treatment_is_not_executed');
    } else {
        $treatment_is_executed = elgg_echo('treatments:views:treatment_execution:table:treatment_is_executed');        
    }
    if ($treatment_execution->prescriptor_evaluation){
        $treatment_is_evaluated = elgg_echo('treatments:views:treatment_execution:table:treatment_is_not_evaluated');
    } else {
        $treatment_is_evaluated = elgg_echo('treatments:views:treatment_execution:table:treatment_is_evaluated');        
    }
    
    $table_row = array(
        $treatment->name,
        $treatment->category,
        $treatment_is_executed,
        $treatment_execution->date_executed,
        $treatment_is_evaluated,
        $treatment_execution->date_evaluated,
        $treatment_execution_actions,
    );

    // acumulamos la fila
    array_push($table_rows, $table_row);
}

// mostramos la tabla
echo elgg_view('page/components/table', array(
    'columns' => $table_header,
    'rows' => $table_rows,
));

