<?php

/*
 * prp/module_actions/list
 * Vista para mostrar las acciones de modulos, y botones para 
 * añadir/importar/exportar acciones. Utiliza:
 * - $vars['module_actions_list']: lista de acciones de modulos
 * - $vars['module_actions_view']: 'admin'|'test', indica el tipo de vista a generar
 */

// recuperamos los tipos de relaciones
$module_actions_list = $vars['module_actions_list'];
$module_actions_view = $vars['module_actions_view'];

$list_options = array(
    'show_edit_icon' => (strcasecmp($module_actions_view, 'admin') == 0),
    'show_delete_icon' => (strcasecmp($module_actions_view, 'test') == 0),
    'check_profile_permission' => (strcasecmp($module_actions_view, 'test') == 0),
);
$list = elgg_view_entity_list($module_actions_list, $list_options);

if ((strcasecmp($module_actions_view, 'test') == 0)){
    $module_actions_info = elgg_echo("prp:tooltips:more_info_module_actions_test_list");
} else {
    $module_actions_info = elgg_echo("prp:tooltips:more_info_module_actions_list");
}


?>

<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<h3>
			<?php echo elgg_echo('prp:views:module_actions:list:title'); ?>
                    <span class='custom_fields_more_info' id='more_info_module_actions_list'></span>
		</h3>
	</div>
    <div class="elgg-body" id="custom_fields_profile_types_list_custom"> 
		<?php echo $list; ?>
	</div>
</div>
<div class="custom_fields_more_info_text" id="text_more_info_module_actions_list"><?php echo $module_actions_info;?></div>