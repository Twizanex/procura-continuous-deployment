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
$treatment_guid = get_input('treatment_guid');
$popup = get_input('pop_up', false);

// comprobamos permisos
if (elgg_is_admin_logged_in()) {  // el administrador siempre tiene pemiso
    $manage_treatment_permission = true;
} else {
    $manage_treatment_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::MANAGE_TREATMENT, null);
}
if ($manage_treatment_permission) {
    // permiso admitido, no hacemos nada            
} else {
    // no se verifican permisos
    forward(REFERRER, elgg_echo('treatments:pages:treatment:edit:no_permission'));
}

// 2. Generar menú de módulo (pestañas), en función del profile (register + view)
// No hay menu de pestañas

// 3. Generar menú de página (específico)
// No hay menu de pagina

// 4. Recuperar contenido a visualizar
// No hay contenido a visualizar

// 5. Generar vista de formulario
$body_vars = array(
    'entity'=>get_entity($treatment_guid),
    'url_to_forward' => 'treatments/treatment/list',
    );
$form = elgg_view_form('treatments/treatment/edit', null, $body_vars);

// 6. Acciones adicionales para el contenido (~page menu)
// no hay acciones adicionales


// 7. Vista completa de página
if ($popup){
    echo $form;
} else {
    $page = elgg_view_layout('one_colum', array('content' => $form));
    echo elgg_view_page('treatments:pages:treatment:edit:title', $page);
}
