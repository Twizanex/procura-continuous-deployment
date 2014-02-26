<?php
/*
 * treatments/treatment/save
 * 
 * Formulario para definir los datos de un tratamiento (bien existente o nuevo)
 * 
 * Utiliza:
 * - vars['entity'] => para indicar si es un alta o modificacion (si esta definida)
 */

// comprobamos si se pasa la entidad, lo que significa que estamos editando el 
// tratamiento, o no está definida, con lo que sería un nuevo tratamiento
/* @var $treatment_entity ElggTreatment */
$treatment_entity = elgg_extract('entity', $vars, null);
$url_to_forward = elgg_extract('url_to_forward', $vars, REFERER);


// informacion del formulario
$form_title = elgg_echo('treatments:forms:treatment:edit:title');
$form_info = elgg_echo('treatments:forms:treatment:edit:info');

// etiquetas para los campos
$treatment_name_label = elgg_echo('treatments:forms:treatment:edit:treatment_name_label');
$treatment_description_label = elgg_echo('treatments:forms:treatment:edit:treatment_description_label');
$treatment_benefits_label = elgg_echo('treatments:forms:treatment:edit:treatment_benefits_label');
$treatment_instructions_label = elgg_echo('treatments:forms:treatment:edit:treatment_instructions_label');
$treatment_category_label = elgg_echo('treatments:forms:treatment:edit:treatment_category_label');
$treatment_level_label = elgg_echo('treatments:forms:treatment:edit:treatment_level_label');

// campos de formulario
$treatment_name_input = elgg_view('input/text',array(
    'name' => 'treatment_name', 
    'value' => $treatment_entity->name,
        ));
$treatment_description_input = elgg_view('input/longtext',array(
    'name' => 'treatment_description', 
    'value' => $treatment_entity->description,
        ));
$treatment_benefits_input = elgg_view('input/longtext',array(
    'name' => 'treatment_benefits', 
    'value' => $treatment_entity->benefits,
        ));
$treatment_instructions_input = elgg_view('input/longtext',array(
    'name' => 'treatment_instructions', 
    'value' => $treatment_entity->instructions,
        ));

// categorias
$allowed_categories = explode(PHP_EOL, elgg_get_plugin_setting('treatment_categories', 'treatments'));
$allowed_categories_options_values = array();
foreach ($allowed_categories as $category) {
    $allowed_categories_options_values["$category"] = $category;
}
$treatment_category_input = elgg_view('input/dropdown',array(
    'name' => 'treatment_category',
    'value' => $treatment_entity->category,
    'options_values' => $allowed_categories_options_values,
));

// niveles
$allowed_levels = explode(PHP_EOL, elgg_get_plugin_setting('treatment_levels', 'treatments'));
$allowed_levels_options_values = array();
foreach ($allowed_levels as $level) {
    $allowed_levels_options_values["$level"] = $level;
}
$treatment_level_input = elgg_view('input/dropdown',array(
    'name' => 'treatment_level',
    'value' => $treatment_entity->level,
    'options_values' => $allowed_levels_options_values,
));

$save_button = elgg_view('input/submit', array(
    'value' => elgg_echo('save')
));

$cancel_button = elgg_view("output/url", array(
    "text" => elgg_echo('cancel'),
    "title" => elgg_echo('cancel'),
    "href" => $url_to_forward,
    "class" => "elgg-button elgg-button-action"));


// campo oculto con la entidad (para modificacion)
$treatment_guid_input_hidden = elgg_view('input/hidden', array(
    'name' => 'treatment_guid',
    'value' => $treatment_entity->guid,
        ));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $url_to_forward,
        ));

// composicion del formulario
$form_body = $treatment_guid_input_hidden;
$form_body .= $url_to_forward_input_hidden;
$form_body .= "<label>$treatment_name_label</label><br/>$treatment_name_input<br/>";
$form_body .= "<label>$treatment_description_label</label><br/>$treatment_description_input<br/>";
$form_body .= "<label>$treatment_benefits_label</label><br/>$treatment_benefits_input<br/>";
$form_body .= "<label>$treatment_instructions_label</label><br/>$treatment_instructions_input<br/>";
$form_body .= "<label>$treatment_category_label</label><br/>$treatment_category_input<br/>";
$form_body .= "<label>$treatment_level_label</label><br/>$treatment_level_input<br/>";
$form_body .= $cancel_button . $save_button;

//echo $form_body;
echo elgg_view_module('inline',$form_title, $form_body);
