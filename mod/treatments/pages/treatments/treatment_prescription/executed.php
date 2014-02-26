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
$treatment_prescription_guid = get_input('treatment_prescription_guid');
if (!$treatment_prescription_guid){
    forward(REFERRER);
}

// Recuperamos el tratamiento
$treatment_prescription = treatments_get_prescribed_treatment($treatment_prescription_guid);

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
    forward(REFERRER, elgg_echo('treatments:pages:treatment_prescription:executed:no_permission'));
}

// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// No hay menu de pestañas

// 3. Generar menú de página (específico)
// No hay menu de pagina

// 4. Recuperar contenido a visualizar
// No hay contenido a visualizar

// 5. Generar vista de formulario
$body_vars = array(
    'entity'=>$treatment_prescription,
    'url_to_forward' => 'treatments/treatment_prescription/list',
    );
$form = elgg_view_form('treatments/treatment_prescription/executed', null, $body_vars);

// 6. Acciones adicionales para el contenido (~page menu)
// no hay acciones adicionales


// 7. Vista completa de página
if ($popup){
    echo $form;
} else {
    $page = elgg_view_layout('one_colum', array('content' => $form));
    echo elgg_view_page('treatments:pages:treatment_prescription:executed:title', $page);
}
