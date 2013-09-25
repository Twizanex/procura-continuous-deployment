<?php 
	/**
	* PRP
	* 
	* Module_Actions actions view
        * (realizado a partir del extraido del modulo profile_manager)
	* 
	*/

// añadimos el botón para importar
$import_button = elgg_view("output/url", array(
    "text" => elgg_echo("prp:views:module_actions:actions:import"), 
    "title" => elgg_echo("prp:views:module_actions:actions:import:description"), 
    "href" => $vars['url'] . "prp/forms/import_module_actions", 
//    "confirm" => elgg_echo("prp:views:module_actions:actions:import:confirm"), 
    "class" => "elgg-button elgg-button-action prp-popup")); 

// añadimos el botón para exportar
$export_button = elgg_view("output/confirmlink", array(
    "title" => elgg_echo("prp:views:module_actions:actions:export:description"),
    "text" => elgg_echo("prp:views:module_actions:actions:export"), 
    "href" => $vars['url'] . "action/prp/module_actions/export", 
    "confirm" => elgg_echo("prp:views:module_actions:actions:export:confirm"), 
    "class" => "elgg-button elgg-button-action")); 

?>
<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<h3>
			<?php echo elgg_echo('prp:views:module_actions:actions:title'); ?>
			<span class='custom_fields_more_info' id='more_info_actions'></span>
		</h3>
	</div>
	<div class="elgg-body profile-manager-actions">
		<?php 
			echo $import_button; 
			echo $export_button; 

                        //echo elgg_view("output/url", array(
                        //  "text" => elgg_echo("profile_manager:actions:configuration:restore"), 
                        //  "js" => "onclick=\"$('#restoreForm').toggle();\"", 
                        //  "class" => "elgg-button elgg-button-action")); 
//			$form_body = "<div>" . elgg_echo("profile_manager:actions:configuration:restore:description") . "</div>";
//			$form_body .= elgg_view("input/file", array("name" => "restoreFile"));
//			$form_body .= elgg_view("input/submit", array("value" => elgg_echo("profile_manager:actions:configuration:restore:upload")));
//
//			$form = elgg_view("input/form", array(
//                            "action" => "action/profile_manager/configuration/restore?fieldtype=" .CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE, 
//                            "id" => "restoreForm", 
//                            "body" => $form_body,
//                            "enctype" => "multipart/form-data"));
//
//			echo $form;
		?>
	</div>
</div>

<div class="custom_fields_more_info_text" id="text_more_info_actions"><?php echo elgg_echo("prp:views:module_actions:actions:more_info");?></div>