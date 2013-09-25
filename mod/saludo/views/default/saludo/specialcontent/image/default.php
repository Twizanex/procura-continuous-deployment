<?php
/**
 * Display an image
 *
 * @uses $vars['entity']
 */

$saludo = $vars['entity'];

$image_url = $saludo->getIconURL('large');
$image_url = elgg_format_url($image_url);
$download_url = elgg_get_site_url() . "saludo/download/{$saludo->getGUID()}";

if ($vars['full_view']) {
	echo <<<HTML
		<div class="saludo-photo">
			<a href="$download_url"><img class="elgg-photo" src="$image_url" /></a>
		</div>
HTML;
}
