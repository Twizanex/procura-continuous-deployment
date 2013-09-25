<?php
/**
 * Elgg topbar
 * The standard elgg top toolbar
 */

// Elgg logo
?>
	<div id="social_topbar">
		<div style="width:930px;margin:0px auto;">
			<?php if (elgg_is_logged_in()):
				echo elgg_view_menu('topbar', array('sort_by' => 'priority', array('elgg-menu-hz')));
			endif ?>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>
<?php

// elgg tools menu
// need to echo this empty view for backward compatibility.
$content = elgg_view("navigation/topbar_tools");
if ($content) {
	elgg_deprecated_notice('navigation/topbar_tools was deprecated. Extend the topbar menus or the page/elements/topbar view directly', 1.8);
	echo $content;
}
