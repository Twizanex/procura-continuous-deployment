<?php 
	/**
	* PRP
	* 
	* Relation_Names actions view
        * (realizado a partir del extraido del modulo profile_manager)
	* 
	*/

// añadimos el botón para añadir relacion
$add_relation_name_button = elgg_view("output/url", array(
    "text" => elgg_echo("prp:views:relation_names:actions:add"), 
    "title" => elgg_echo("prp:views:relation_names:actions:add:description"), 
    "href" => $vars["url"] . "prp/forms/relation_name",
    "class" => "elgg-button elgg-button-action prp-popup"));

// añadimos el botón para exportar
$export_button = elgg_view("output/confirmlink", array(
    "title" => elgg_echo("prp:views:relation_names:actions:export:description"),
    "text" => elgg_echo("prp:views:relation_names:actions:export"), 
    "href" => $vars['url'] . "action/prp/relations/names/export", 
    "confirm" => elgg_echo("prp:views:relation_names:actions:export:confirm"), 
    "class" => "elgg-button elgg-button-action")); 

// añadimos el botón para importar
$import_button = elgg_view("output/url", array(
    "text" => elgg_echo("prp:views:relation_names:actions:import"), 
    "title" => elgg_echo("prp:views:relation_names:actions:import:description"), 
    "href" => $vars['url'] . "prp/forms/import_relation_names", 
    "class" => "elgg-button elgg-button-action prp-popup")); 

?>
<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<h3>
			<?php echo elgg_echo('prp:views:relation_names:actions:title'); ?>
			<span class='custom_fields_more_info' id='more_info_actions'></span>
		</h3>
	</div>
	<div class="elgg-body profile-manager-actions">
		<?php 
			echo $add_relation_name_button;
			echo $import_button;
			echo $export_button;
		?>
	</div>
</div>

<div class="custom_fields_more_info_text" id="text_more_info_actions"><?php echo elgg_echo("prp:views:relation_names:actions:more_info");?></div>