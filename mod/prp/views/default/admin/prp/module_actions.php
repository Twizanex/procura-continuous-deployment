<?php
/*
 * admin/module_actions
 * Muestra las acciones de módulo registradas, permitiendo modificarlas
 */

// recuperamos las acciones existentes
$module_actions_list = prp_get_module_actions();

// Mostramos los tipos de relaciones, indicando que es tipo admin, para mostrar unos botones u otros
$vars = array(
    'module_actions_list' => $module_actions_list,
    'module_actions_view' => 'admin',
);
$module_actions  = elgg_view('prp/module_actions/list', $vars);

$actions = elgg_view("prp/module_actions/actions");

$page_data = $module_actions . $actions;

echo elgg_view("prp/admin/tabs", array("module_actions_selected" => true));
echo $page_data;