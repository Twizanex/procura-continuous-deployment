<?php
/*
 * prp/module_actions/save form body
 * Formulario para configurar los permisos de una acción de módulo
 * usa: 
 * - vars['module_action_entity'] ==> acción de modulo a configurar
 */


// recuperamos la accion del modulo
$module_action_entity = $vars['module_action_entity'];
// preparamos variables
$action_name = $module_action_entity->action_name;

$module_name = $module_action_entity->module_name;

$requires_profile = $module_action_entity->requires_profile;
$requires_relation = $module_action_entity->requires_relation;
$requires_owner = $module_action_entity->requires_owner;

$required_relations = $module_action_entity->required_relations;
$required_profiles = $module_action_entity->required_profiles;

// ELEMENTOS DEL FORMULARIO

$module_action_title = elgg_echo('prp:forms:module_actions:save:title');
$module_action_info = elgg_echo('prp:forms:module_actions:save:info');

// campos ocultos
$action_name_hidden_input = elgg_view('input/hidden', array(
    'name' => 'action_name',
    'value' => $action_name,
));
$module_name_hidden_input = elgg_view('input/hidden', array(
    'name' => 'module_name',
    'value' => $module_name,
));


// identificación de la acción
$action_title = $module_action_entity->title;
$action_title_label = elgg_echo('prp:forms:module_actions:save:name_label');
$module = elgg_get_plugin_from_id($module_name);
$module_title = $module->title;
$module_title_label = elgg_echo('prp:forms:module_actions:save:module_label');

// PERFILES
$requires_profile_label = elgg_echo('prp:forms:module_actions:save:requires_profile_label');
$requires_profile_input = elgg_view('input/checkbox', array(
    'name' => 'requires_profile',
    'value' => 1,
    'checked' => ($requires_profile == true),
));
// recuperamos la lista de custom_profiles
$options = array(
    'type' => 'object',
    'subtype' => 'custom_profile_type',
);
$profile_list = elgg_get_entities($options);
$profile_options = array();
foreach ($profile_list as $profile_type) {
    $name = $profile_type->metadata_name;
    $label = $profile_type->metadata_label;  
    $profile_options[$label] = $name;
}
$required_profiles_label = elgg_echo('prp:forms:module_actions:save:required_profiles_label');
$required_profiles_input = elgg_view('input/checkboxes', array(
    'name' => 'required_profiles',
    'value' => $required_profiles,
    'align' => 'horizontal',
    'options' => $profile_options,
));

// RELATIONS
$requires_relation_label = elgg_echo('prp:forms:module_actions:save:requires_relation_label');
$requires_relation_input = elgg_view('input/checkbox', array(
    'name' => 'requires_relation',
    'value' => 1,
    'checked'=> ($requires_relation == true),
));
// recuperamos la lista de relation_names
$options = array(
    'type' => 'object',
    'subtype' => 'custom_profile_type',
);
$relation_names_list = prp_get_relation_names();
$relation_names_options = array();
foreach ($relation_names_list as $relation_name) {
    $name = $relation_name->name;
    $label = $relation_name->title;  
    $relation_names_options[$label] = $name;
}
$required_relations_label = elgg_echo('prp:forms:module_actions:save:required_relations_label');
$required_relations_input = elgg_view('input/checkboxes', array(
    'name' => 'required_relations',
    'value' => $required_relations,
    'align' => 'horizontal',
    'options' => $relation_names_options,
));

// OWNER
$requires_owner_label = elgg_echo('prp:forms:module_actions:save:requires_owner_label');
$requires_owner_input = elgg_view('input/checkbox', array(
    'name' => 'requires_owner',
    'value' => 1,
    'checked'=> ($requires_owner == true),
));


$save_button = elgg_view('input/submit', array(
    'value' => elgg_echo('save')
));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $vars["url"] . "admin/prp/module_actions",
        ));

// composicion del formulario
$form_body = $action_name_hidden_input . $module_name_hidden_input. $url_to_forward_input_hidden ;
$form_body .= "<h4>$action_title_label $action_title</h4>";
$form_body .= "<i>$module_title_label $module_title</i></br>";
$form_body .= "</br>";
$form_body .= "<hr>";
$form_body .= "$requires_profile_input <label>$requires_profile_label</label><br/>";
$form_body .= "</br>";
$form_body .= "<label>$required_profiles_label</label><br/>$required_profiles_input";
$form_body .= "</br>";
$form_body .= "<hr>";
$form_body .= "$requires_relation_input <label>$requires_relation_label</label><br/>";
$form_body .= "</br>";
$form_body .= "<label>$required_relations_label</label><br/>$required_relations_input";
$form_body .= "</br>";
$form_body .= "<hr>";
$form_body .= "$requires_owner_input <label>$requires_owner_label</label><br/>";
$form_body .= "</br>";
$form_body .= $save_button;

?>
<div class="elgg-module elgg-module-inline" id="custom_fields_profile_type_form">
	<div class="elgg-head">
		<h3>
			<?php echo $module_action_title; ?>
			<span class='custom_fields_more_info' id='more_info_module_action_save'></span>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo $form_body; ?>
	</div>
</div>
<div class="custom_fields_more_info_text" id="text_more_info_module_action_save"><?php echo $module_action_info;?></div>