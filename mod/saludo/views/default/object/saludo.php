<?php
/**
 * saludo renderer.
 *
 * @package Elggsaludo
 */

$full = elgg_extract('full_view', $vars, FALSE);
$saludo = elgg_extract('entity', $vars, FALSE);

if (!$saludo) {
	return TRUE;
}

$owner = $saludo->getOwnerEntity();
$container = $saludo->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = elgg_get_excerpt($saludo->description);
$mime = $saludo->mimetype;
$base_type = substr($mime, 0, strpos($mime,'/'));

$owner_link = elgg_view('output/url', array(
	'href' => "saludo/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$saludo_icon = elgg_view_entity_icon($saludo, 'small');

$tags = elgg_view('output/tags', array('tags' => $saludo->tags));
$date = elgg_view_friendly_time($saludo->time_created);

$comments_count = $saludo->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $saludo->getURL() . '#saludo-comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'saludo',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {

	$extra = '';
	if (elgg_view_exists("saludo/specialcontent/$mime")) {
		$extra = elgg_view("saludo/specialcontent/$mime", $vars);
	} else if (elgg_view_exists("saludo/specialcontent/$base_type/default")) {
		$extra = elgg_view("saludo/specialcontent/$base_type/default", $vars);
	}

	$params = array(
		'entity' => $saludo,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$text = elgg_view('output/longtext', array('value' => $saludo->description));
	$body = "$text $extra";

	echo elgg_view('object/elements/full', array(
		'entity' => $saludo,
		'title' => false,
		'icon' => $saludo_icon,
		'summary' => $summary,
		'body' => $body,
	));

} elseif (elgg_in_context('gallery')) {
	echo '<div class="saludo-gallery-item">';
	echo "<h3>" . $saludo->title . "</h3>";
	echo elgg_view_entity_icon($saludo, 'medium');
	echo "<p class='subtitle'>$owner_link $date</p>";
	echo '</div>';
} else {
	// brief view

	$params = array(
		'entity' => $saludo,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($saludo_icon, $list_body);
}
