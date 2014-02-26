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

//TODO: Comprobar si el tratamiento ya se ha realizado, y en caso contrario dar la opción de repetirlo

//TODO: Comprobar si ha vencido al programacion

if ($treatment_prescription->is_archived) {
    // no se pueden ejecutar tratamientos archivados
    forward(REFERRER, elgg_echo('treatments:pages:treatment_prescription:execute:treatment_prescription_is_archived'));
}

$popup = get_input('pop_up', false);

// comprobamos permisos
if (elgg_is_admin_logged_in()) {  // el administrador siempre tiene pemiso
    $execute_treatment_permission = true;
} else {
    // para comprobar permisos, pasamos el usuario al que está asignado el tratamiento y el propio tratamiento
    $permission_options =array(
        'object'=>  $treatment_prescription,
        'user'=>  get_user($treatment_prescription->user_guid),
        );
    
    $execute_treatment_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::EXECUTE_TREATMENT, $permission_options);
}
if ($execute_treatment_permission) {
    // permiso admitido, no hacemos nada            
} else {
    // no se verifican permisos
    forward(REFERRER, elgg_echo('treatments:pages:treatment_prescription:execute:no_permission'));
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
$treatment_prescription_executed_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:treatment_prescription:execute:button:executed'),
    "title" => elgg_echo('treatments:pages:treatment_prescription:execute:button:executed:title'),
    "href" => $vars["url"] . "treatments/treatment_prescription/executed?treatment_prescription_guid=$treatment_prescription->guid&pup_up=true",
    "class" => "elgg-button elgg-button-action elgg-lightbox"));
$back_button = elgg_view("output/url", array(
    "text" => elgg_echo('back'),
    "title" => elgg_echo('back'),
    "href" => REFERRER,
    "class" => "elgg-button elgg-button-action"));

// Determinamos las acciones a mostrar
$treatment_prescription_actions = $back_button . $treatment_prescription_executed_button;

$page_actions = elgg_view_module('treatment-actions', '', $treatment_prescription_actions);


// 7. Vista completa de página
$body = $module_menu . $page_menu . $content . $page_actions;
if ($popup) {
    echo $body;
} else {
    $page = elgg_view_layout('one_colum', array('content' => $body));
    echo elgg_view_page('treatments:pages:treatment_prescription:executed:title', $page);
}
