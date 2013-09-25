<?php
/*
 * prp/relations/names/save form body
 * Formulario para componer las características de una relacion nueva
 */


// comprobamos si tenemos definida la entidad
$relation_name_entity = $vars['relation_name_entity'];

$relation_name_title = elgg_echo('prp:forms:relations:names:save:title');
$relation_name_info = elgg_echo('prp:forms:relations:names:save:info');


$relation_name_label = elgg_echo('prp:forms:relations:names:save:relation_name_label');
$relation_name_input = elgg_view('input/text',array(
    'name' => 'relation_name', 
    'value' => $relation_name_entity->name,
        ));

$relation_title_label = elgg_echo('prp:forms:relations:names:save:relation_title_label');
$relation_title_input = elgg_view('input/text',array(
    'name' => 'relation_title', 
    'value' => $relation_name_entity->title,
        ));

// recuperamos la lista de custom_profiles
$options = array(
    'type' => 'object',
    'subtype' => 'custom_profile_type',
);
$profile_list = elgg_get_entities($options);
//$profile_list = elgg_list_entities($options);

$custom_profile_options = array();
foreach ($profile_list as $profile_type) {
    $name = $profile_type->metadata_name;
    $label = $profile_type->metadata_label;  
    $custom_profile_options[$label] = $name;
}

$subject_profiles_label = elgg_echo('prp:forms:relations:names:save:subject_profiles_label');
$subject_profiles_input = elgg_view('input/checkboxes', array(
    'name' => 'subject_profiles',
    'value' => $relation_name_entity->subject_profiles,
    'align' => 'horizontal',
    'options' => $custom_profile_options,
));

$object_profiles_label = elgg_echo('prp:forms:relations:names:save:object_profiles_label');
$object_profiles_input = elgg_view('input/checkboxes', array(
    'name' => 'object_profiles',
    'value' => $relation_name_entity->object_profiles,
    'align' => 'horizontal',
    'options' => $custom_profile_options,
));

$allowed_profiles_label = elgg_echo('prp:forms:relations:names:save:allowed_profiles_label');
$allowed_profiles_input = elgg_view('input/checkboxes', array(
    'name' => 'allowed_profiles',
    'value' => $relation_name_entity->allowed_profiles,
    'align' => 'horizontal',
    'options' => $custom_profile_options,
));

$save_button = elgg_view('input/submit', array(
    'value' => elgg_echo('save')
));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $vars["url"] . "admin/prp/relation_names",
        ));

// composicion del formulario
$form_body = $relation_name_hidden_input . $url_to_forward_input_hidden ;
$form_body .= "<label>$relation_name_label</label><br/>$relation_name_input";
$form_body .= "</br>";
$form_body .= "<label>$relation_title_label</label><br/>$relation_title_input";
$form_body .= "</br>";
$form_body .= "<hr>";
$form_body .= "<label>$subject_profiles_label</label><br/>$subject_profiles_input";
$form_body .= "</br>";
$form_body .= "<hr>";
$form_body .= "<label>$object_profiles_label</label><br/>$object_profiles_input";
$form_body .= "</br>";
$form_body .= "<hr>";
$form_body .= "<label>$allowed_profiles_label</label><br/>$allowed_profiles_input";
$form_body .= "</br>";
$form_body .= $save_button;

?>
<div class="elgg-module elgg-module-inline" id="custom_fields_profile_type_form">
	<div class="elgg-head">
		<h3>
			<?php echo $relation_name_title; ?>
			<span class='custom_fields_more_info' id='more_info_relation_name_save'></span>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo $form_body; ?>
	</div>
</div>
<div class="custom_fields_more_info_text" id="text_more_info_relation_name_save"><?php echo $relation_name_info;?></div>