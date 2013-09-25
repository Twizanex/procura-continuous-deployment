<?php
/*
 * admin/relation_names
 * Muestra los tipos de relaciones permitidas, permitiendo modificarlas y dar de alta nuevas relaciones
 */

// recuperamos los tipos de relaciones existentes
$relation_names_list = prp_get_relation_names();

// Mostramos los tipos de relaciones
$vars = array(
    'relation_names_list' => $relation_names_list,
);
$relation_names = elgg_view('prp/relations/names/list', $vars);

$actions = elgg_view("prp/relations/names/actions");

$page_data = $relation_names . $actions;

echo elgg_view("prp/admin/tabs", array("relation_names_selected" => true));
echo $page_data;
