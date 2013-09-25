<?php
/**
 * View for tratamientoCategory objects
 *
 * @package Tratamiento
 */

$full = elgg_extract('full_view', $vars, FALSE);
$tratamiento = elgg_extract('entity', $vars, FALSE);

if (!$tratamiento) {
	return TRUE;
}

$owner = $tratamiento->getOwnerEntity();
$container = $tratamiento->getContainerEntity();
$title = $tratamiento->title;

$tags = elgg_view('output/tags', array('tags' => $tratamiento->tags));
$date = elgg_view_friendly_time($tratamiento->time_created);


$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'tratamiento',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full) {

	$body = elgg_view('output/longtext', array(
		'value' => $tratamiento->description,
		'class' => 'tratamiento-post',
	));

	$params = array(
		'entity' => $tratamiento,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $body,
	));

} else {
	// brief view	

	$params = array(
		'entity' => $tratamiento,
		'metadata' => $metadata,
		'content' => $title,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($owner_icon, $list_body);
}
