<?php
/**
 * View for informacion objects
 *
 * @package informacion
 */

$full = elgg_extract('full_view', $vars, FALSE);
$informacion = elgg_extract('entity', $vars, FALSE);

if (!$informacion) {
	return TRUE;
}

$owner = $informacion->getOwnerEntity();
$container = $informacion->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $informacion->excerpt;
if (!$excerpt) {
	$excerpt = elgg_get_excerpt($informacion->description);
}

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "informacion/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$tags = elgg_view('output/tags', array('tags' => $informacion->tags));
$date = elgg_view_friendly_time($informacion->time_created);

// The "on" status changes for comments, so best to check for !Off
if ($informacion->comments_on != 'Off') {
	$comments_count = $informacion->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $informacion->getURL() . '#informacion-comments',
			'text' => $text,
			'is_trusted' => true,
		));
	} else {
		$comments_link = '';
	}
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'informacion',
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
		'value' => $informacion->description,
		'class' => 'informacion-post',
	));

	$params = array(
		'entity' => $informacion,
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
		'entity' => $informacion,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($owner_icon, $list_body);
}
