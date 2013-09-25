<?php
/**
 * Elgg tratamiento plugin settings.
 *
 */

$scormEnabled = $vars['entity']->scormEnabled;
if (!$scormEnabled) {
	$scormEnabled = 'No';
}
$scormAPIKey = $vars['entity']->scormAPIKey;

$options = array(
	"type" => "object",
	"subtype" => "tratamientoCategory",
	"full_view" => false,
	"limit" => false,
); 

$categories = elgg_list_entities($options);
	
?>
<div>
	<?php echo elgg_echo('Categorias tratamientos'); ?> <br />
	<?php
		echo $categories;
	?>
	<br />
	<?php echo elgg_echo('Agregar categoria'); ?> <br />
	<?php
		echo elgg_view('input/text', array(
			'name' => 'title',
			'value' => $vars['title'],
		));
	?>
	<br />
	
<!--	Puramente estético: estamos ya dentro de un form, no puede haber forms anidados, y es un form añadido automáticamente por Elgg... -->
	<?php
		echo elgg_view('input/submit', array(
			'value' => 'Agregar',
			'id' => 'buttonAddCategory',
			'style' => "width:150px;"
		));
	?>
	<br /><br />

	<?php echo elgg_echo('SCORM habilitado'); ?>
	<br />
	<?php
		echo elgg_view('input/dropdown', array(
			'name' => 'params[scormEnabled]',
			'options_values' => array(
				'Si' => 'Si',
				'No' => 'No',
			),
			'value' => $scormEnabled
		));
	?>
	<br /><br />
	
	<?php echo elgg_echo('SCORM API Key'); ?>
	<br />
	<?php
		echo elgg_view('input/text', array(
			'name' => 'params[scormAPIKey]',
			'value' => $scormAPIKey
		));
	?>
	<br /><br />

</div>