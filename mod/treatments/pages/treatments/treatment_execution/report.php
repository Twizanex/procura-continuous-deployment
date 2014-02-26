<?php

/*
 * Pagina para mostrar una vista de los tratamientos definidos
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

if (!elgg_is_admin_logged_in()) {  // el administrador siempre tiene pemiso
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
    forward(REFERRER, elgg_echo('El usuario no tiene permiso para visualizar tratamientos'));
}

// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// Recuperamos el menú del módulo tratamientos para el prescriptor
$module_menu = treatments_get_prescriptor_menu();

// test...
$module_menu = treatments_get_evaluator_menu();



// 3. Generar menú de página (específico)
// esta página no tiene un meú específico
// $page_menu = elgg_view_menu('title');
// 4. Recuperar contenido a visualizar
// Recuperamos los tratamientos
if ($delete_treatment_permission) {
    $treatment_list = treatments_get_treatments_all();
} else {
    $treatment_list = treatments_get_treatments();
}

// 5. Generar vista de contenido
// componemos la lista de tratamientos
$content .= elgg_view('treatments/treatment/table', array(
    'treatment_list' => $treatment_list,
    'show_view_button' => $view_treatment_permission,
    'show_edit_button' => $manage_treatment_permission,
    'show_prescribe_button' => $manage_treatment_permission,
    'show_archive_button' => $manage_treatment_permission,
    'show_delete_button' => $delete_treatment_permission,
        ));

//$content = elgg_view_entity_list($treatment_list,array("full_view"=>false));
// 6. Acciones adicionales para el contenido (~page menu)
//// pruebas de control de visualizacion
//$vars['full_view'] = true;
$vars['show_prescribe_button'] = true;
$vars['show_delete_button'] = true;
$vars['show_archive_button'] = true;
$vars['show_edit_button'] = true;

if ($vars['show_edit_button']) {
    $treatment_edit_button = elgg_view("output/url", array(
        "text" => "Edit",
        "title" => elgg_echo('edit'),
        "href" => $vars["url"] . "treatments/treatment/edit?treatment_guid=$treatment->guid&pop_up=yes",
        "class" => "elgg-button elgg-button-action elgg-lightbox"));
    elgg_register_menu_item('page', new ElggMenuItem(
                    'edit-treatment',
                    'Edit',
                    $vars["url"] . "treatments/treatment/edit?treatment_guid=$treatment->guid&pop_up=yes"));
}
if ($vars['show_prescribe_button']) {
    $treatment_prescribe_button = elgg_view("output/url", array(
        "text" => "Prescribe",
        "title" => elgg_echo('prescribe'),
        "href" => $vars["url"] . "treatments/treatment/prescribe?treatment_guid=$treatment->guid&pop_up=yes",
        "class" => "elgg-button elgg-button-action elgg-lightbox"));
    elgg_register_menu_item('page', new ElggMenuItem(
                    'prescribe-treatment',
                    'Prescribe',
                    $vars["url"] . "treatments/treatment/prescribe?treatment_guid=$treatment->guid&pop_up=yes"));
}
if ($vars['show_archive_button']) {
    $treatment_archive_button = elgg_view("output/url", array(
        "text" => "Archive",
        "title" => elgg_echo('archive'),
        "onclick" => "treatmentsArchiveTreatment('$treatment->guid');",
        "class" => "elgg-button elgg-button-action"));
}
if ($vars['show_delete_button']) {
    $treatment_delete_button = elgg_view("output/url", array(
        "text" => "Delete",
        "title" => elgg_echo('delete'),
        "onclick" => "treatmentsDeleteTreatment('$treatment->guid');",
        "class" => "elgg-button elgg-button-action"));
}
$page_actions = elgg_view_module('treatment-actions', '', $treatment_edit_button . $treatment_prescribe_button . $treatment_archive_button . $treatment_delete_button);


// 7. Vista completa de página
$body = $module_menu . $page_menu . $content . $page_actions;
$page = elgg_view_layout('one_colum', array('content' => $body));
echo elgg_view_page("lista tratamientos", $page);

