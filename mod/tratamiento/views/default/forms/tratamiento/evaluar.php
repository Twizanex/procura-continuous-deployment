<?php
/**
 * Edit tratamiento form
 *
 * @package Tratamiento
 */

$tratamiento = get_entity($vars['guid']);
$vars['entity'] = $tratamiento;

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="message warning">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/tratamiento/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/confirmlink', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete elgg-state-disabled float-alt'
	));
}

// published tratamientos do not get the preview button
if (!$vars['guid'] || ($tratamiento && $tratamiento->status != 'published')) {
	$preview_button = elgg_view('input/submit', array(
		'value' => elgg_echo('preview'),
		'name' => 'preview',
		'class' => 'mls',
	));
}

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'name' => 'save',
));
$action_buttons = $save_button . $preview_button . $delete_link;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'tratamiento_title',
	'value' => $vars['title'],
//	'disabled' => true,
));

$options = array(
	"type" => "object",
	"subtype" => "tratamientoCategory",
	"full_view" => false,
	"limit" => false,
);
$list = elgg_get_entities_from_metadata($options);

$categoriasArray = array();
foreach($list as $f) {
	$categoriasArray[$f->guid] = $f->title;
}

$categorias_label = elgg_echo('tratamiento:categorias');
$categorias_input = elgg_view('input/checkboxes', array(
	'name' => 'categorias',
	'id' => 'tratamiento_categorias',
	'value' => $vars['categorias'],
	'disabled' => true, // No permitimos cambiar las categorías, parece razonable.
	'options' => $categoriasArray,
));

$pacientesArray = array();

$options = array(
	'type' => 'object',
	'subtype' => 'PRPRelacion',
	'full_view' => false,
	'limit' => FALSE,
);
 $options['metadata_name_value_pairs'] = array(
 		array('name' => 'entidad2', 'value' => elgg_get_logged_in_user_guid())
 );
 
$list = elgg_get_entities_from_metadata($options);
foreach ($list as $relation) {
	if (get_entity($relation->tipoRelacion)->title==="Paciente - Medico") {
		$pacientesArray[$relation->entidad1] = $relation->entidad1 . ": " . get_user($relation->entidad1)->name;
	}
	else if (get_entity($relation->tipoRelacion)->title==="Paciente - Terapeuta") {
		$pacientesArray[$relation->entidad1] = $relation->entidad1 . ": " . get_user($relation->entidad1)->name;
	}
}

$pacientesArray[] = "No asignado";		
$paciente_label = elgg_echo('tratamiento:paciente')."<br>";
$paciente_input = elgg_view('input/dropdown', array(
		'name' => 'paciente',
		'id' => 'tratamiento_paciente',
		'value' => $vars['paciente'],
		'disabled' => true,
		'options' => $pacientesArray
));

$scorm_label = elgg_echo('scorm');
$scorm_input = elgg_view('input/text', array(
	'name' => 'scorm',
	'id' => 'tratamiento_scorm',
	'value' => $vars['scorm']
));

$scorm_label = elgg_echo('scorm');
$scorm_input = elgg_view('input/text', array(
	'name' => 'scorm',
	'id' => 'tratamiento_scorm',
	'value' => $vars['scorm'],
	'disabled' => true,
));

// $pacientes_input = "<select name='send_to'>";
// foreach($friends as $friend) {
// 	$pacientes_input .= "<option value='{$friend->guid}'>" . $friend->name . "</option>";
// }

// $pacientes_input .= "</select>";

$body_label = elgg_echo('tratamiento:body');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'tratamiento_description',
	'value' => $vars['description'],
//	'disabled' => true,
));

$save_status = elgg_echo('tratamiento:save_status');
if ($vars['guid']) {
	$entity = get_entity($vars['guid']);
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('tratamiento:never');
}

$status_label = elgg_echo('tratamiento:status');
$status_input = elgg_view('input/dropdown', array(
	'name' => 'status',
	'id' => 'tratamiento_status',
	'value' => $vars['status'],
	'options_values' => array(
		'draft' => elgg_echo('tratamiento:status:draft'),
		'published' => elgg_echo('tratamiento:status:published')
	),
	'disabled' => true,
));

$evaluacionLibre_label = elgg_echo('tratamiento:evaluacionLibre');
$evaluacionLibre_input = elgg_view('input/longtext', array(
	'name' => 'evaluacionEvaluacionLibre',
	'id' => 'tratamiento_evaluacionLibre',
	'value' => $vars['evaluacionEvaluacionLibre'],
));

// $comments_label = elgg_echo('comments');
// $comments_input = elgg_view('input/dropdown', array(
// 	'name' => 'comments_on',
// 	'id' => 'tratamiento_comments_on',
// 	'value' => $vars['comments_on'],
// 	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
// ));

// $tags_label = elgg_echo('tags');
// $tags_input = elgg_view('input/tags', array(
// 	'name' => 'tags',
// 	'id' => 'tratamiento_tags',
// 	'value' => $vars['tags']
// ));

 $access_label = elgg_echo('access');
 $access_input = elgg_view('input/access', array(
 	'name' => 'access_id',
 	'id' => 'tratamiento_access_id',
 	'value' => $vars['access_id'],
 	'disabled' => true,
 ));

$categories_input = elgg_view('input/categories', $vars);

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));

$scormRegistrationID_input = elgg_view('input/hidden', array('name' => 'scormRegistrationID', 'value' => uniqid(time(),true)));

//var_dump($vars);

echo <<<___HTML

$draft_warning

<div>
	<label for="tratamiento_title">$title_label</label>
	$title_input
</div>

<div>
	<label for="tratamiento_categorias">$categorias_label</label>
	$categorias_input
</div>

<div>
	<label for="tratamiento_paciente">$paciente_label</label>
	$paciente_input
</div>

<div>
	<label for="tratamiento_scorm">$scorm_label</label>
	$scorm_input
</div>

<label for="tratamiento_description">$body_label</label>
$body_input
<br />

<label for="tratamiento_evaluacionLibre">$evaluacionLibre_label</label>
	$evaluacionLibre_input
</div>

$categories_input

<div>
	<label for="tratamiento_access_id">$access_label</label>
	$access_input
</div>

<div>
	<label for="tratamiento_status">$status_label</label>
	$status_input
</div>

<div class="elgg-foot">
	<div class="elgg-subtext mbm">
	$save_status <span class="tratamiento-save-status-time">$saved</span>
	</div>

	$container_guid_input
	$guid_input
	$scormRegistrationID_input

	$action_buttons
</div>

___HTML;
