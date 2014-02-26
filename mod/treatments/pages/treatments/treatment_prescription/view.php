<?php
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
$treatment_prescription_guid = get_input('treatment_prescription_guid');
// Recuperamos el tratamiento
$treatment_prescription = treatments_get_prescribed_treatment($treatment_prescription_guid);

$popup = get_input('pop_up', false);

// comprobamos permisos
if (elgg_is_admin_logged_in()) {  // el administrador siempre tiene pemiso
    $view_treatment_prescription_permission = true;
    $execute_treatment_permission = true;
    $prescribe_treatment_permission = true;
    $delete_treatment_prescription_permission = true;
} else {
    // para comprobar permisos, pasamos el usaurio al que está asignado el tratamiento y el propio tratamiento
    $permission_options =array(
        'object'=>  $treatment_prescription,
        'user'=>  get_user($treatment_prescription->user_guid),
        );
    
    $view_treatment_prescription_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::VIEW_TREATMENT_PRESCRIPTION, $permission_options);
    $execute_treatment_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::EXECUTE_TREATMENT, $permission_options);
    $prescribe_treatment_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::PRESCRIBE_TREATMENT, $permission_options);
    $delete_treatment_prescription_permission = false;
}
if ($view_treatment_prescription_permission ||
        $execute_treatment_permission ||
        $prescribe_treatment_permission) {
    // permiso admitido, no hacemos nada            
} else {
    // no se verifican permisos
    forward(REFERRER, elgg_echo('treatments:pages:treatment_prescription:view:no_permission'));
}

// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// No hay menu de pestaña en la vista de tratamiento

// 3. Generar menú de página (específico)
// No hay menu de página en la vista de tratamiento

// 4. Recuperar contenido a visualizar
// Lo hemos hecho antes para poder comprobar persmisos

// 5. Generar vista de contenido
// componemos la lista de tratamientos
$content .= elgg_view_entity($treatment_prescription, array('full_view'=>true));

// 6. Acciones adicionales para el contenido (~page menu)
$treatment_prescription_edit_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_prescription:view:button:edit'),
    "title" => elgg_echo('treatments:pages:treatment_prescription:view:button:edit:title'),
    "href" => $vars["url"] . "treatments/treatment_prescription/edit?treatment_prescription_guid=$treatment_prescription->guid",
    "class" => "elgg-button elgg-button-action"));
$treatment_prescription_archive_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_prescription:view:button:archive'),
    "title" => elgg_echo('treatments:pages:treatment_prescription:view:button:archive:title'),
    "onclick" => "treatmentsArchiveTreatmentPrescription('$treatment_prescription->guid');",
    "class" => "elgg-button elgg-button-action"));
$treatment_prescription_restore_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_prescription:view:button:restore'),
    "title" => elgg_echo('treatments:pages:treatment_prescription:view:button:restore:title'),
    "onclick" => "treatmentsRestoreTreatmentPrescription('$treatment_prescription->guid');",
    "class" => "elgg-button elgg-button-action"));
$treatment_prescription_execute_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_prescription:view:button:execute'),
    "title" => elgg_echo('treatments:pages:treatment_prescription:view:button:execute:title'),
    "href" => $vars["url"] . "treatments/treatment_prescription/execute?treatment_prescription_guid=$treatment_prescription->guid",
    "class" => "elgg-button elgg-button-action"));
$treatment_prescription_delete_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_prescription:view:button:delete'),
    "title" => elgg_echo('treatments:pages:treatment_prescription:view:button:delete:title'),
    "onclick" => "treatmentsDeleteTreatmentPrescription('$treatment_prescription->guid');",
    "class" => "elgg-button elgg-button-action"));
$back_button = elgg_view("output/url", array(
    "text" => elgg_echo('back'),
    "title" => elgg_echo('back'),
    "href" => REFERRER,
    "class" => "elgg-button elgg-button-action"));

// Determinamos las acciones a mostrar en función de si el tratamiento está 
// activo o no y los permisos
$treatment_prescription_actions = $back_button;
if ($treatment_prescription->is_archived) {
    if (elgg_is_admin_logged_in()) {
        $treatment_prescription_actions .= $treatment_prescription_restore_button . $treatment_prescription_delete_button;
    }
} else {
    if ($prescribe_treatment_permission) {
        $treatment_prescription_actions .= $treatment_prescription_edit_button . $treatment_prescription_archive_button;
    }
    if ($execute_treatment_permission) {
        $treatment_prescription_actions .= $treatment_prescription_execute_button;
    }
    if (elgg_is_admin_logged_in()) {
        $treatment_prescription_actions .= $treatment_prescription_delete_button;
    }
}

$page_actions = elgg_view_module('treatment-actions', '', $treatment_prescription_actions);


// 7. Vista completa de página
$body = $module_menu . $page_menu . $content . $page_actions;
if ($popup) {
    echo $body;
} else {
    $page = elgg_view_layout('one_colum', array('content' => $body));
    echo elgg_view_page('treatments:pages:treatment_prescription:view:title', $page);
}
