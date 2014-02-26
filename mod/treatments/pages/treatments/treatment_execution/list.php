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

// recuperamos el usuario del que queremos consultar las ejecuciones de tratamientos
$user_guid = get_input('user_guid',  elgg_get_logged_in_user_guid());
$user = get_entity($user_guid);

if (elgg_is_admin_logged_in()) {  // el administrador siempre tiene pemiso
    $prescribe_treatment_permission = true;
    $view_treatment_execution_permission = true;
    $manage_treatment_execution_permission = true;
    $admin_permission = true;
} else {
    // para comprobar permisos, comprobamos si el usuario logado es el usuario 
    // solicitado, en cuyo caso no habrá que indicarlo en la llamada
    if ($user_guid == elgg_get_logged_in_user_guid()){
        $permission_options = null;
    } else {
        $permission_options =array('user'=>$user);
    }
    $prescribe_treatment_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::PRESCRIBE_TREATMENT, $permission_options);
    $view_treatment_execution_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::VIEW_TREATMENT_EXECUTION, $permission_options);
    $manage_treatment_execution_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::MANAGE_TREATMENT_EXECUTION, $permission_options);
    $admin_permission = false;
}

if ($view_treatment_execution_permission ||
        $manage_treatment_execution_permission) {
    // permiso admitido, no hacemos nada            
} else {
    // no se verifican permisos
    forward(REFERRER, elgg_echo('treatments:pages:treatment_execution:list:no_permission'));
}

// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// Enlaces a tratamientos asignados, ejecuciones de tratamientos (medico) e informe

// 3. Generar menú de página (específico)
// esta página no tiene un menú específico


// 4. Recuperar contenido a visualizar
// Recuperamos los tratamientos asignados
if ($admin_permission) {
    $treatment_prescription_list = treatments_get_user_treatment_executions_all($user_guid);
} else {
    $treatment_prescription_list = treatments_get_user_treatment_executions($user_guid);
}

// 5. Generar vista de contenido
// componemos la lista de tratamientos
$content .= elgg_view('treatments/treatment_execution/table', array(
    'treatment_execution_list' => $treatment_execution_list,
    'manage_treatment_execution_permission' => $manage_treatment_execution_permission,
        ));

//$content = elgg_view_entity_list($treatment_list,array("full_view"=>false));
// 6. Acciones adicionales para el contenido (~page menu)
if ($prescribe_treatment_permission) {
    $treatment_prescription_prescribe_button = elgg_view("output/url", array(
        "text" => elgg_echo('treatments:pages:treatment_execution:list:button:prescribe'),
        "title" => elgg_echo('treatments:pages:treatment_execution:list:button:prescribe:title'),
        "href" => "treatments/treatment/prescribe?user_guid=$user->guid&pop_up=true",
        "class" => "elgg-button elgg-button-action elgg-lightbox"));
}
$page_actions = elgg_view_module('treatment-execution-actions', '', $treatment_prescription_prescribe_button);

// 7. Vista completa de página
$body = $module_menu . $content . $page_actions ; 
$page = elgg_view_layout('one_colum', array('content' => $body));
echo elgg_view_page('treatments:pages:treatment_execution:list:title', $page);

