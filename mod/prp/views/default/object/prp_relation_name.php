<?php

/*
 * Muestra un objeto ElggPRPRelationName
 * Admite varaibles de configuracion:
 * - vars['show_edit_icon']
 * - vars['show_delete_icon']
 */

// recuperamos el tipo de relación
$relation_name_entity = $vars['entity'];


// preparamos variables
$relation_name = $relation_name_entity->name;
$relation_title = $relation_name_entity->title;
$subject_profiles = prp_get_selected_profiles_labels($relation_name_entity->subject_profiles);
$object_profiles = prp_get_selected_profiles_labels($relation_name_entity->object_profiles);

if ($vars['show_edit_icon']) {
    $edit_relation_name_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('edit'),
        "href" => $vars["url"] . "prp/forms/relation_name?relation_name=$relation_name",
        "class" => "elgg-icon elgg-icon-settings-alt prp-popup"));
}
if ($vars['show_delete_icon']) {
    $delete_relation_name_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('delete'),
        "onclick" => "prpDeleteRelationName('$relation_name')",        
        "class" => "elgg-icon elgg-icon-delete"));
}


// Componemos la presentacion
$relation_name_view = "<h4>$relation_title $edit_relation_name_button $delete_relation_name_button</h4>";

$relation_name_view .= '{name: ' . $relation_name . '} <br/>';
$relation_name_view .= "<i>$subject_profiles >> $object_profiles</i>";


echo $relation_name_view;
?>
