<?php
/**
 * Loginrequired Login page layout
 *
 */

$mod_params = array('class' => 'elgg-module-highlight');
?>

<div class="loginrequired-index elgg-main elgg-grid clearfix">
	<div class="elgg-col elgg-col-1of2">
		<div class="elgg-inner pvm prl">
<?php
$top_box = $vars['login'];

echo elgg_view_module('featured',  '', $top_box, $mod_params);

echo elgg_view("index/lefthandside");
?>
		</div>
	</div>

        <div class="elgg-col elgg-col-1of2">
                <div class="elgg-inner pvm">
<?php

// right column

// a view for plugins to extend
echo elgg_view("index/righthandside");

$infobox = '';
$infobox .= '<img src="./procura.png" alt="Procura">';

echo elgg_view_module('featured',  elgg_echo(" "), $infobox, $mod_params);

?>

                </div>
        </div>
</div>

