<?php
/**
 * Link to download the saludo
 *
 * @uses $vars['entity']
 */

if (elgg_instanceof($vars['entity'], 'object', 'saludo')) {
	$download_url = elgg_get_site_url() . 'saludo/download/' . $vars['entity']->getGUID();
	$size = $vars['entity']->size();
	$mime_type = $vars['entity']->getMimeType();
	echo <<<END

	<enclosure url="$download_url" length="$size" type="$mime_type" />";
END;
}
