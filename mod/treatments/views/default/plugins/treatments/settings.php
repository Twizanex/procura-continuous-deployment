<?php
/*
 * Formulario para establecer la configuracion del plugin de tratamientos
 * - Niveles de dificultad
 * - Grupos de tratamiento
 */


// Niveles de dificultad
$treatment_levels_label = elgg_echo('treatments:plugins:treatments:settings:levels:label');
$treatment_levels_info = elgg_echo('treatments:plugins:treatments:settings:levels:info');
$treatment_levels_input = elgg_view('input/plaintext',array(
    'name' => 'params[treatment_levels]', 
    'value' => elgg_get_plugin_setting('treatment_levels', 'treatments'),
        ));
$treatment_levels_content = $treatment_levels_info . $treatment_levels_input;
echo elgg_view_module('inline', $treatment_levels_label, $treatment_levels_content);

// etiquetas de parametros
$treatment_categories_label = elgg_echo('treatments:plugins:treatments:settings:categories:label');
$treatment_categories_info = elgg_echo('treatments:plugins:treatments:settings:categories:info');
$treatment_categories_input = elgg_view('input/plaintext',array(
    'name' => 'params[treatment_categories]', 
    'value' => elgg_get_plugin_setting('treatment_categories', 'treatments'),
        ));
$treatment_categories_content = $treatment_categories_info . $treatment_categories_input;
echo elgg_view_module('inline', $treatment_categories_label, $treatment_categories_content);

$button_module_actions = elgg_view('output/url', array(
        "text" => elgg_echo('treatments:plugins:treatments:settings:button:module_actions:text'),
        "title" => elgg_echo('treatments:plugins:treatments:settings:button:module_actions:title'),
        "href" => "admin/prp/module_actions?module_name=treatments",
        "class" => "elgg-button elgg-button-action"    
));

echo $button_module_actions;
