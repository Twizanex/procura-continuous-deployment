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
$treatment_execution_guid = get_input('treatment_execution_guid');
// Recuperamos el tratamiento
$treatment_execution = treatments_get_treatment_execution($treatment_execution_guid);

$popup = get_input('pop_up', false);

// comprobamos permisos
if (elgg_is_admin_logged_in()) {  // el administrador siempre tiene pemiso
    $view_treatment_execution_permission = true;
    $manage_treatment_execution_permission = true;
    $delete_treatment_execution_permission = true;
} else {
    // para comprobar permisos, pasamos el usaurio al que está asignado el tratamiento y el propio tratamiento
    $permission_options =array(
        'object'=>  $treatment_execution,
        'user'=>  get_user($treatment_execution->user_guid),
        );
    
    $view_treatment_execution_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::VIEW_TREATMENT_EXECUTION, $permission_options);
    $manage_treatment_execution_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::MANAGE_TREATMENT_EXECUTION, $permission_options);
    $delete_treatment_execution_permission = false;
}
if ($view_treatment_execution_permission ||
        $manage_treatment_execution_permission) {
    // permiso admitido, no hacemos nada            
} else {
    // no se verifican permisos
    forward(REFERRER, elgg_echo('treatments:pages:treatment_execution:view:no_permission'));
}

// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// No hay menu de pestaña en la vista de tratamiento

// 3. Generar menú de página (específico)
// No hay menu de página en la vista de tratamiento

// 4. Recuperar contenido a visualizar
// Lo hemos hecho antes para poder comprobar persmisos

// 5. Generar vista de contenido
// componemos la lista de tratamientos
$content .= elgg_view_entity($treatment_execution, array('full_view'=>true));

// 6. Acciones adicionales para el contenido (~page menu)
$treatment_execution_edit_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_execution:view:button:edit'),
    "title" => elgg_echo('treatments:pages:treatment_execution:view:button:edit:title'),
    "href" => $vars["url"] . "treatments/treatment_execution/edit?treatment_execution_guid=$treatment_execution->guid",
    "class" => "elgg-button elgg-button-action"));
$treatment_execution_archive_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_execution:view:button:archive'),
    "title" => elgg_echo('treatments:pages:treatment_execution:view:button:archive:title'),
    "onclick" => "treatmentsArchiveTreatmentExecution('$treatment_execution->guid');",
    "class" => "elgg-button elgg-button-action"));
$treatment_execution_restore_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_execution:view:button:restore'),
    "title" => elgg_echo('treatments:pages:treatment_execution:view:button:restore:title'),
    "onclick" => "treatmentsRestoreTreatmentExecution('$treatment_execution->guid');",
    "class" => "elgg-button elgg-button-action"));
$treatment_execution_evaluate_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_execution:view:button:evaluate'),
    "title" => elgg_echo('treatments:pages:treatment_execution:view:button:evaluate:title'),
    "href" => $vars["url"] . "treatments/treatment_execution/evaluate?treatment_execution_guid=$treatment_execution->guid",
    "class" => "elgg-button elgg-button-action"));
$treatment_execution_delete_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_execution:view:button:delete'),
    "title" => elgg_echo('treatments:pages:treatment_execution:view:button:delete:title'),
    "onclick" => "treatmentsDeleteTreatmentExecution('$treatment_execution->guid');",
    "class" => "elgg-button elgg-button-action"));
$back_button = elgg_view("output/url", array(
    "text" => elgg_echo('back'),
    "title" => elgg_echo('back'),
    "href" => REFERRER,
    "class" => "elgg-button elgg-button-action"));

// Determinamos las acciones a mostrar en función de si el tratamiento está 
// activo o no y los permisos
$treatment_execution_actions = $back_button;
if ($treatment_execution->is_archived) {
    if (elgg_is_admin_logged_in()) {
        $treatment_execution_actions .= $treatment_execution_restore_button . $treatment_execution_delete_button;
    }
} else {
    if ($manage_treatment_execution_permission) {
        $treatment_execution_actions .= $treatment_execution_evaluate_button . $treatment_execution_archive_button . $treatment_execution_edit_button ;
    }
    if (elgg_is_admin_logged_in()) {
        $treatment_execution_actions .= $treatment_execution_delete_button;
    }
}

$page_actions = elgg_view_module('treatment-actions', '', $treatment_execution_actions);


// 7. Vista completa de página
$body = $module_menu . $page_menu . $content . $page_actions;
if ($popup) {
    echo $body;
} else {
    $page = elgg_view_layout('one_colum', array('content' => $body));
    echo elgg_view_page('treatments:pages:treatment_execution:view:title', $page);
}
