<?php
/**
 * View for paciente objects
 *
 */

$paciente = elgg_extract('entity', $vars, FALSE);

if (!$paciente) {
	return TRUE;
}

//$owner = $tratamiento->getOwnerEntity();
//$container = $tratamiento->getContainerEntity();
//$categories = elgg_view('output/categories', $vars);
//$description = $tratamiento->description;

$paciente_icon = elgg_view_entity_icon($paciente, 'small');
//$owner_link = elgg_view('output/url', array(
//	'href' => "user/$paciente->username",
//	'text' => $paciente->name,
//	'is_trusted' => true,
//));
$params = array(
		'entity' => $paciente,
		'title' => $paciente->name,
//		'metadata' => $metadata,
//		'subtitle' => $subtitle,
//		'tags' => $tags,
	);
$paciente_text = elgg_view('object/elements/summary', $params);
echo $paciente_icon . "" . $paciente_text;


//echo elgg_view("profile/icon", array('entity' => $paciente,'size' => 'tiny','override' => true));

return;
//$author_text = elgg_echo('byline', array($owner_link));
//$tags = elgg_view('output/tags', array('tags' => $tratamiento->tags));
//$date = elgg_view_friendly_time($tratamiento->time_created);

//// The "on" status changes for comments, so best to check for !Off
//if ($tratamiento->comments_on != 'Off') {
//	$comments_count = $tratamiento->countComments();
//	//only display if there are commments
//	if ($comments_count != 0) {
//		$text = elgg_echo("comments") . " ($comments_count)";
//		$comments_link = elgg_view('output/url', array(
//			'href' => $tratamiento->getURL() . '#tratamiento-comments',
//			'text' => $text,
//			'is_trusted' => true,
//		));
//	} else {
//		$comments_link = '';
//	}
//} else {
//	$comments_link = '';
//}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'paciente',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "";

// do not show the metadata and controls in widget view
//if (elgg_in_context('widgets')) {
//	$metadata = '';
//}

//if ($full) {

	$body = elgg_view('output/longtext', array(
		'value' => $paciente->name,
		'class' => 'tratamiento-post',
	));

	$params = array(
		'entity' => $paciente,
		'title' => $paciente->name,
		'metadata' => $metadata,
//		'subtitle' => $subtitle,
//		'tags' => $tags,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $body,
	));

//} else {
//	// brief view
//
//	$params = array(
//		'entity' => $tratamiento,
//		'metadata' => $metadata,
//		'subtitle' => $subtitle,
////		'tags' => $tags,
//		'content' => $description,
//	);
//	$params = $params + $vars;
//	$list_body = elgg_view('object/elements/summary', $params);
//
//	echo elgg_view_image_block($owner_icon, $list_body);
//}
