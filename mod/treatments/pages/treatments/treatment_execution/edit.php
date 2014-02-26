<?php
// Flujo general de páginas:
// 1. Comprobar perfil admitido, caso de que no, forward a la página principal
// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// 3. Generar menú de página (específico)
// 4. Recuperar contenido a visualizar
// 5. Generar vista de formulario
// 6. Acciones adicionales para el contenido (~page menu)
// 7. Vista completa de página

// recuperamos parámetros de la llamada
$treatment_execution_guid = get_input('treatment_execution_guid');
if (!$treatment_execution_guid){
    forward(REFERRER);
}

// Recuperamos la ejecucion del tratamiento
$treatment_execution= treatments_get_treatment_execution($treatment_execution_guid);

$popup = get_input('pop_up', false);

// comprobamos permisos
if (elgg_is_admin_logged_in()) {  // el administrador siempre tiene pemiso
    $manage_treatment_execution_permission = true;
} else {
    // para comprobar permisos, pasamos el usuario al que está asignado el tratamiento y el propio tratamiento
    $permission_options =array(
        'object'=>  $treatment_execution,
        'user'=>  get_user($treatment_execution->owner_guid),
        );
    
    $manage_treatment_execution_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::MANAGE_EXECUTED_TREATMENT, $permission_options);
}
if ($manage_treatment_execution_permission) {
    // permiso admitido, no hacemos nada            
} else {
    // no se verifican permisos
    forward(REFERRER, elgg_echo('treatments:pages:treatment_execution:edit:no_permission'));
}

// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// No hay menu de pestañas

// 3. Generar menú de página (específico)
// No hay menu de pagina

// 4. Recuperar contenido a visualizar
// No hay contenido a visualizar

// 5. Generar vista de formulario
$body_vars = array(
    'entity'=>$treatment_execution,
    'url_to_forward' => "treatments/treatment_execution/list?user_guid=$treatment_execution->owner_guid",
    );
$form = elgg_view_form('treatments/treatment_execution/edit', null, $body_vars);

// 6. Acciones adicionales para el contenido (~page menu)
// no hay acciones adicionales


// 7. Vista completa de página
if ($popup){
    echo $form;
} else {
    $page = elgg_view_layout('one_colum', array('content' => $form));
    echo elgg_view_page('treatments:pages:treatment_execution:edit:title', $page);
}
