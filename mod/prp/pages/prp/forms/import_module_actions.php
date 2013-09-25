<?php
/*
 * prp/forms/import_module_actions
 * Pagina para mostrar un formulario para importar las acciones de modulo
 */

// only admins should see this page
admin_gatekeeper();

// context will be help so we need to set to admin
elgg_set_context('admin');

$form_vars = array(
    'enctype' =>'multipart/form-data',
);

// mostramos el formulario
$content = elgg_view_form('prp/module_actions/import', $form_vars);

echo $content;
