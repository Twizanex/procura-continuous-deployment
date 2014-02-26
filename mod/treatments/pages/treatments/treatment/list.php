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
    forward(REFERRER, elgg_echo('treatments:pages:treatment:list:no_permission'));
}

// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// No hay un menu de modulo específico

// 3. Generar menú de página (específico)
// esta página no tiene un menú específico
//// Menús de acciones sobre el tratamiento
//if ($manage_treatment_permission) {
//    elgg_register_menu_item('page', new ElggMenuItem('treatment-new', elgg_echo('treatments:page:treatment:list:new'), "/treatments/treatment/new"));
//}
//if ($prescribe_treatment_permission) {
//    elgg_register_menu_item('page', new ElggMenuItem('treatment-assign', elgg_echo('treatments:page:treatment:list:assign'), "/treatments/treatment/assign"));
//}
//$page_menu = elgg_view_menu('page');


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
    'manage_permission' => $manage_treatment_permission,
    'prescribe_permission' => $prescribe_treatment_permission,
        ));

//$content = elgg_view_entity_list($treatment_list,array("full_view"=>false));
// 6. Acciones adicionales para el contenido (~page menu)
if ($prescribe_treatment_permission) {
    $treatment_prescribe_button = elgg_view("output/url", array(
        "text" => elgg_echo('treatments:pages:treatment:list:button:prescribe'),
        "title" => elgg_echo('treatments:pages:treatment:list:button:prescribe:title'),
        "href" => $vars["url"] . "treatments/treatment/prescribe",
        "class" => "elgg-button elgg-button-action"));
}
if ($manage_treatment_permission) {
    $treatment_new_button = elgg_view("output/url", array(
        "text" => elgg_echo('treatments:pages:treatment:list:button:new'),
        "title" => elgg_echo('treatments:pages:treatment:list:button:new:title'),
        "href" => $vars["url"] . "treatments/treatment/new",
        "class" => "elgg-button elgg-button-action"));
}
$page_actions = elgg_view_module('treatment-actions', '', $treatment_new_button . $treatment_prescribe_button);

// 7. Vista completa de página
$body = $module_menu . $page_menu . $content . $page_actions;
$page = elgg_view_layout('one_colum', array('content' => $body));
echo elgg_view_page('treatments:pages:treatment:list:title', $page);

