<?php

/*
 * Muestra un objeto ElggPRPModuleAction
 * Admite varaibles de configuracion:
 * - vars['show_module_name'] ==> true|false para indicar si se muestra el nombre del módulo
 * - vars['show_edit_icon'] ==> true|false para indicar si se muestra el botón para editar la acción
 * - vars['show_delete_icon'] ==> true|false para indicar si se muestra el botón para eliminar la acción
 * - vars['check_profile_permission'] ==> true|false para indicar si se comprueba si el usuario actual verifica los permisos de perfil
 */

// recuperamos la accion
/* @var $module_action_entity ElggPRPModuleAction */
$module_action_entity = $vars['entity'];


// preparamos variables
$action_name = $module_action_entity->action_name;
$action_title = $module_action_entity->title;
$module_name = $module_action_entity->module_name;

$requires_profile = $module_action_entity->requires_profile;
$requires_relation = $module_action_entity->requires_relation;
$requires_owner = $module_action_entity->requires_owner;

$required_relations = prp_get_selected_relations_labels($module_action_entity->required_relations);

if ($vars['show_edit_icon']) {
    $edit_module_action_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('edit'),
        "href" => $vars["url"] . "prp/forms/module_action?module_name=$module_name&action_name=$action_name",
        "class" => "elgg-icon elgg-icon-settings-alt prp-popup"));
}
if ($vars['show_delete_icon']) {
    $delete_module_action_button = elgg_view("output/url", array(
        "text" => "",
        "title" => elgg_echo('delete'),
        "onclick" => "prpDeleteModuleAction('$module_name', '$action_name');",        
        "class" => "elgg-icon elgg-icon-delete"));
}
// maquetamos la presentacion
$module_action_view = "<h4>$action_title $edit_module_action_button $delete_module_action_button </h4>";

if ($vars['check_profile_permission']) {
    $has_permission = prp_check_module_action_profile_permission($module_action_entity);
    if ($has_permission){
        $module_action_view .= 'User VERIFIES profile permission </br>';
    } else {        
        $module_action_view .= 'User DOES NOT VERIFY profile permission </br>';
    }
}
// mostramos el nombre del modulo
if ($vars['show_module_name']){
    /* @var $module ElggPlugin */
    $module = elgg_get_plugin_from_id($module_name);
    $module_label = $module->title;
    $module_action_view .= $module_label . ' <br/>';        
}
// codigo de la accion
$module_action_view .= '{name: ' .$module_name . '::' . $action_name . '} <br/>';

// requisitos de perfiles
if ($requires_profile){
    $required_profiles = prp_get_selected_profiles_labels($module_action_entity->required_profiles);    
    $module_action_view .= '<div>' . elgg_echo('prp:object:prp_module_action:required_profiles_label', array($required_profiles)) . '</div>';
} else {
    $module_action_view .= '<div>'. elgg_echo('prp:object:prp_module_action:no_require_profiles_label') . '</div>';
}
// requisitos relaciones
if ($requires_relation){
    $required_relations = prp_get_selected_relations_labels($module_action_entity->required_relations);    
    $module_action_view .= '<div>'. elgg_echo('prp:object:prp_module_action:required_relations_label', array($required_relations)) . '</div>';
} else {
    $module_action_view .= '<div>'. elgg_echo('prp:object:prp_module_action:no_require_relations_label') . '</div>';
}

// requisitos propietario
if ($requires_owner){
    $module_action_view .= '<div>'. elgg_echo('prp:object:prp_module_action:requires_owner') . '</div>';
} else {
    $module_action_view .= '<div>'. elgg_echo('prp:object:prp_module_action:no_requires_owner') . '</div>';
}

echo $module_action_view;
?>
