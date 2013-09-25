<?php
/**
 * Elgg saludo upload/save form
 *
 * @package Elggsaludo
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use 
$title = elgg_extract('title', $vars, '');
$paciente = elgg_extract('paciente', $vars, '');
$desc = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
if (!$container_guid) {
	$container_guid = elgg_get_logged_in_user_guid();
}
$guid = elgg_extract('guid', $vars, null);

if ($guid) {
	$saludo_label = elgg_echo("saludo:replace");
	$submit_label = elgg_echo('save');
} else {
	$saludo_label = elgg_echo("saludo:saludo");
	$submit_label = elgg_echo('upload');
}

$friends = elgg_get_logged_in_user_entity()->getFriends();
$friendsArray = array();
foreach($friends as $friend) {
	if (getPerfil($friend->guid)==="Paciente") $friendsArray[$friend->guid] = $friend->name." (ID ".$friend->guid.")";
	// Concatenamos "ID" por un problema al pasar variables POST cuyos índices son enteros.
}

?>
<div>
	<label><?php echo $saludo_label; ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload')); ?>
</div>
<div>
	<label><?php echo elgg_echo('saludo:paciente'); ?></label><br />
	<?php echo elgg_view('input/dropdown', array(
		'name' => 'paciente',
		'id' => 'tratamiento_pacientes',
		'value' => $paciente,
		'options_values' => $friendsArray
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>
<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'saludo_guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => $submit_label));

?>
</div>
