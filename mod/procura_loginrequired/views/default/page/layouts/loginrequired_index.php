<?php
/**
 * procura_loginrequired Login page layout
 * Right section of the page has been removed.
 *
 */

$mod_params = array('class' => 'elgg-module-highlight');
?>

<div class="loginrequired-index elgg-main elgg-grid clearfix">
	<div class="elgg-col elgg-col-1of1">
		<div class="elgg-inner pvm prl">
<?php
$top_box = $vars['login'];

echo elgg_view_module('',  '', $top_box, $mod_params);

echo elgg_view("index/lefthandside");
?>
		</div>
	</div>
</div>

