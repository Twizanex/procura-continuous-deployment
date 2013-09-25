<?php
/**
 * Tratamiento sidebar
 *
 * @package Tratamiento
 */

// fetch & display latest comments
if ($vars['page'] == 'all') {
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'tratamiento',
	));
} elseif ($vars['page'] == 'owner') {
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'tratamiento',
		'owner_guid' => elgg_get_page_owner_guid(),
	));
}

// only users can have archives at present
if (elgg_instanceof(elgg_get_page_owner_entity(), 'user')) {
	echo elgg_view('tratamiento/sidebar/archives', $vars);
}

if ($vars['page'] != 'friends') {
	echo elgg_view('page/elements/tagcloud_block', array(
		'subtypes' => 'tratamiento',
		'owner_guid' => elgg_get_page_owner_guid(),
	));
}
