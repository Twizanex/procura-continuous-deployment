<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Flujo general de páginas:
// 1. Comprobar perfil admitido, caso de que no, forward a la página principal
// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// 3. Generar menú de página (específico)
// 4. Recuperar contenido a visualizar
// 5. Generar vista de contenido
// 6. Acciones adicionales para el contenido (~page menu)
// 7. Vista completa de página
// 1. Comprobar perfil admitido, caso de que no, forward a la página principal
// recuperamos parámetros de la llamada
$treatment_guid = get_input('treatment_guid');
$popup = get_input('pop_up', false);

// comprobamos permisos
if (elgg_is_admin_logged_in()) {  // el administrador siempre tiene pemiso
    $view_treatment_permission = true;
    $manage_treatment_permission = true;
    $prescribe_treatment_permission = true;
    $delete_treatment_permission = true;
} else {
    $view_treatment_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT, null);
    $manage_treatment_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::MANAGE_TREATMENT, null);
    $prescribe_treatment_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::PRESCRIBE_TREATMENT, null);
    $delete_treatment_permission = false;
}
if ($view_treatment_permission ||
        $manage_treatment_permission ||
        $prescribe_treatment_permission) {
    // permiso admitido, no hacemos nada            
} else {
    // no se verifican permisos
    forward(REFERRER, elgg_echo('treatments:pages:treatment:view:no_permission'));
}

// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// No hay menu de pestaña en la vista de tratamiento

// 3. Generar menú de página (específico)
// No hay menu de página en la vista de tratamiento

// 4. Recuperar contenido a visualizar
// Recuperamos el tratamiento
$treatment = get_entity($treatment_guid);

// 5. Generar vista de contenido
// componemos la lista de tratamientos
$content .= elgg_view_entity($treatment, array('full_view'=>true));

// 6. Acciones adicionales para el contenido (~page menu)
$treatment_edit_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment:view:button:edit'),
    "title" => elgg_echo('treatments:pages:treatment:view:button:edit:title'),
    "href" => $vars["url"] . "treatments/treatment/edit?treatment_guid=$treatment->guid",
    "class" => "elgg-button elgg-button-action"));
$treatment_archive_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment:view:button:archive'),
    "title" => elgg_echo('treatments:pages:treatment:view:button:archive:title'),
    "onclick" => "treatmentsArchiveTreatment('$treatment->guid');",
    "class" => "elgg-button elgg-button-action"));
$treatment_restore_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment:view:button:restore'),
    "title" => elgg_echo('treatments:pages:treatment:view:button:restore:title'),
    "onclick" => "treatmentsRestoreTreatment('$treatment->guid');",
    "class" => "elgg-button elgg-button-action"));
$treatment_prescribe_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment:view:button:prescribe'),
    "title" => elgg_echo('treatments:pages:treatment:view:button:prescribe:title'),
    "href" => $vars["url"] . "treatments/treatment/prescribe?treatment_guid=$treatment->guid",
    "class" => "elgg-button elgg-button-action"));
$treatment_delete_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment:view:button:delete'),
    "title" => elgg_echo('treatments:pages:treatment:view:button:delete:title'),
    "onclick" => "treatmentsDeleteTreatment('$treatment->guid');",
    "class" => "elgg-button elgg-button-action"));

$back_button = elgg_view("output/url", array(
    "text" => elgg_echo('back'),
    "title" => elgg_echo('back'),
    "href" => 'treatments/treatment/list',
    "class" => "elgg-button elgg-button-action"));


// Determinamos las acciones a mostrar en función de si el tratamiento está 
// activo o no y los permisos
$treatment_actions = $back_button;
if ($treatment->is_archived) {
    if (elgg_is_admin_logged_in()) {
        $treatment_actions .= $treatment_restore_button . $treatment_delete_button;
    }
} else {
    if ($prescribe_treatment_permission) {
        $treatment_actions .= $treatment_prescribe_button;
    }
    if ($manage_treatment_permission) {
        $treatment_actions .= $treatment_edit_button . $treatment_archive_button;
    }
    if (elgg_is_admin_logged_in()) {
        $treatment_actions .= $treatment_delete_button;
    }
}

$page_actions = elgg_view_module('treatment-actions', '', $treatment_actions);


// 7. Vista completa de página
$body = $module_menu . $page_menu . $content . $page_actions;
if ($popup) {
    echo $body;
} else {
    $page = elgg_view_layout('one_colum', array('content' => $body));
    echo elgg_view_page('treatments:pages:treatment:view:title', $page);
}
