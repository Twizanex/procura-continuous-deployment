<?php
/**
 * Alzheimer topbar
 * Elgg topbar
 * The standard elgg top toolbar
 */

// Remove elgg_logo from topbar menu
elgg_unregister_menu_item('topbar', 'elgg_logo');

echo elgg_view_menu('topbar', array('sort_by' => 'priority', array('elgg-menu-hz')));

// elgg tools menu
// need to echo this empty view for backward compatibility.
$content = elgg_view("navigation/topbar_tools");
if ($content) {
	elgg_deprecated_notice('navigation/topbar_tools was deprecated. Extend the topbar menus or the page/elements/topbar view directly', 1.8);
	echo $content;
}
