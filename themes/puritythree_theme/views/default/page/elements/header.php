<?php
/**
 * Elgg page header
 * In the default theme, the header lives between the topbar and main content area.
 */

// link back to main site.
echo elgg_view('page/elements/header_logo', $vars);

// drop-down login
echo elgg_view('core/account/login_dropdown');

// insert site-wide navigation
?>
<div id="social_menu_holder">
	<div id="social_menu">
		<?php echo elgg_view_menu('site'); ?>
			<div style="clear:both;"></div>
	</div>
<?php echo elgg_view('page/elements/topbar', $vars); ?>
<div style="clear:both;"></div>
