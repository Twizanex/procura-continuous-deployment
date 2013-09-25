<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title'] The page title
 * @uses $vars['body'] The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// backward compatability support for plugins that are not using the new approach
// of routing through admin. See reportedcontent plugin for a simple example.
if (elgg_get_context() == 'admin') {
	elgg_deprecated_notice("admin plugins should route through 'admin'.", 1.8);
	elgg_admin_add_plugin_settings_menu();
	elgg_unregister_css('elgg');
	echo elgg_view('page/admin', $vars);
	return true;
}

// Set the content type
header("Content-type: text/html; charset=UTF-8");
if (!$bodyc) $bodyc = 'ffffff';
$pagec = elgg_get_plugin_setting('pagec','puritythree_theme');
if (!$pagec) $pagec = 'dddddd';
$logoc = elgg_get_plugin_setting('logoc','puritythree_theme');
if (!$logoc) $logoc = 'ffffff';
$desc = elgg_get_plugin_setting('desc','puritythree_theme');
if (!$desc) $desc = '333333';
$socc = elgg_get_plugin_setting('socc','puritythree_theme');
if (!$socc) $socc = '3B5998';
$page = elgg_get_plugin_setting('page','puritythree_theme');
if (!$page) $page = '1E9833';
$pagea = elgg_get_plugin_setting('pagea','puritythree_theme');
if (!$pagea) $pagea = '3B5998';
$bodypattern = elgg_get_plugin_setting('bodypattern','puritythree_theme');
if (!$bodypattern) $bodypattern = '13';
$pagepattern = elgg_get_plugin_setting('pagepattern','puritythree_theme');
if (!$pagepattern) $pagepattern = '10';
$smpattern = elgg_get_plugin_setting('smpattern','puritythree_theme');
if (!$smpattern) $smpattern = '11';

$pagepattern
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo elgg_view('page/elements/head', $vars); if ($bodypattern == 'none') { ?>
<style>
body, .elgg-page {
	background:#<?php echo $bodyc; ?>;
	}
</style>
<?php } else { ?>
<style>
body, .elgg-page {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/<?php echo $bodypattern; ?>.png) #<?php echo $bodyc; ?>;
	}
</style>
<?php } if ($pagepattern == 'none') { ?>
<style>
.rounded-corners {
	background:#<?php echo $pagec; ?>;
	}
</style>
<?php } else { ?>
<style>
.rounded-corners {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/<?php echo $pagepattern; ?>.png) #<?php echo $pagec; ?>;
	}
</style>
<?php } if ($smpattern == 'none') { ?>
<style>
#social_menu_holder, .elgg-menu-site-more > li > a {
	background:#<?php echo $socc; ?>;
	}
</style>
<?php } else { ?>
<style>
#social_menu_holder, .elgg-menu-site-more > li > a {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/<?php echo $smpattern; ?>.png) #<?php echo $socc; ?>;
	}
</style>
<?php } ?>
<style>
a.elgg-heading-site, a.elgg-heading-site:hover {
	color:#<?php echo $logoc; ?>;
	}
.site_description {
	color:#<?php echo $desc; ?>
	}
.elgg-menu-page a:hover {
	background:#<?php echo $page; ?>;
	}
.elgg-menu-page li.elgg-state-selected > a {
	background:#<?php echo $pagea; ?>;
</style>

</head>
<body>
<div class="elgg-page elgg-page-default">
	<div class="elgg-page-messages">
		<?php echo elgg_view('page/elements/messages', array('object' => $vars['sysmessages'])); ?>
	</div>
	
<div class="rounded-corners">
	<div class="elgg-page-header">
		<div class="elgg-inner">
			<?php echo elgg_view('page/elements/header', $vars); ?>
		</div>
	</div>
	<div class="elgg-page-body">
		<div class="elgg-inner">
			<?php echo elgg_view('page/elements/body', $vars); ?>
		</div>
	</div>
	<div class="elgg-page-footer">
		<div class="elgg-inner">
			<?php echo elgg_view('page/elements/footer', $vars); ?>
		</div>
	</div>
</div>
<?php echo elgg_view('page/elements/foot'); ?>
</body>
</html>