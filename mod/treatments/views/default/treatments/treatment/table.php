<?php

/*
 * treatments/treatment/table
 * Vista para mostrar una tabla con los tratamientos definidos
 * Utiliza:
 * - $vars['treatments_list']: lista de tratamientos
 * - $vars['manage_permission']: Indica si se tienen permisos para gestionar tratamientos, añadiendo los botones correspondientes (edit, archive)
 * - $vars['prescribe_permission']: Indica si se tienen permisos para asignar tratamientos, añadiendo el botón correspondiente (prescribe)
 * 
 * Nota. Para el administrator, se incluyen las accines delete y restore
 */

// recuperamos los tratamientos
$treatments_list = elgg_extract('treatment_list', $vars);
$manage_permission = elgg_extract('manage_permission', $vars, false);
$prescribe_permission = elgg_extract('prescribe_permission', $vars, false);

// preparamos los encabezados
$table_header = array(
    elgg_echo('treatments:views:treatment:table:name'),
    elgg_echo('treatments:views:treatment:table:category'),
    elgg_echo('treatments:views:treatment:table:level'),
    elgg_echo('treatments:views:treatment:table:actions'),
);


// preparamos el contenido
elgg_load_js('lightbox');
elgg_load_css('lightbox');


$table_rows = array();
/* @var $treatment ElggTreatment */
foreach ($treatments_list as $treatment) {
    // preparamos iconos para acciones sobre cada tratamiento
    $treatment_view_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment:table:button:view:title'),
        "href" => $vars["url"] . "treatments/treatment/view?treatment_guid=$treatment->guid&pop_up=yes",
        "class" => "elgg-icon elgg-icon-info elgg-lightbox"));
    $treatment_edit_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment:table:button:edit:title'),
        "href" => $vars["url"] . "treatments/treatment/edit?treatment_guid=$treatment->guid",
        "class" => "elgg-icon elgg-icon-settings-alt"));
    $treatment_archive_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment:table:button:archive:title'),
        "onclick" => "treatmentsArchiveTreatment('$treatment->guid');",
        "class" => "elgg-icon elgg-icon-trash"));
    $treatment_restore_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment:table:button:restore:title'),
        "onclick" => "treatmentsRestoreTreatment('$treatment->guid');",
        "class" => "elgg-icon elgg-icon-undo"));
    $treatment_delete_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment:table:button:delete:title'),
        "onclick" => "treatmentsDeleteTreatment('$treatment->guid');",
        "class" => "elgg-icon elgg-icon-delete"));
    $treatment_prescribe_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('treatments:views:treatment:table:button:prescribe:title'),
        "href" => $vars["url"] . "treatments/treatment/prescribe?treatment_guid=$treatment->guid",
        "class" => "elgg-icon elgg-icon-arrow_left"));

    // Determinamos las acciones a mostrar en función de si el tratamiento está 
    // activo o no y los permisos
    $treatment_actions = $treatment_view_button;
    if ($treatment->is_archived) {
        if (elgg_is_admin_logged_in()) {
            $treatment_actions .= $treatment_restore_button . $treatment_delete_button;
        }
    } else {
        if ($prescribe_permission) {
            $treatment_actions .= $treatment_prescribe_button;
        }
        if ($manage_permission) {
            $treatment_actions .= $treatment_edit_button . $treatment_archive_button;
        }
        if (elgg_is_admin_logged_in()) {
            $treatment_actions .= $treatment_delete_button;
        }
    }
    $treatment_url = elgg_get_site_url() . 'treatments/treatments/save/' . $treatment->guid;
    $treatment_url = $treatment->getURL();
    $table_row = array(
        $treatment->name,
        $treatment->category,
        $treatment->level,
        $treatment_actions,
    );

    // acumulamos la fila
    array_push($table_rows, $table_row);
}

// mostramos la tabla
echo elgg_view('page/components/table', array(
    'columns' => $table_header,
    'rows' => $table_rows,
));

