<?php
/**
 * Procura footer
 * 
 * The standard HTML footer that displays across the site
 * Incluye los logos de los socios participantes en el proyecto y el del ministerio correspondiente.
 */


//echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

// Logos de los socios
$powered_url = elgg_get_site_url() . "mod/procura_alzheimer_theme/graphics/logo-ministerio.png";
$logica_url = elgg_get_site_url() . "mod/procura_alzheimer_theme/graphics/logica.jpeg";
$aiju_url = elgg_get_site_url() . "mod/procura_alzheimer_theme/graphics/logo-aiju1.gif";
$flowlab_url = elgg_get_site_url() . "mod/procura_alzheimer_theme/graphics/flowlab.jpeg";
$solutio_url = elgg_get_site_url() . "mod/procura_alzheimer_theme/graphics/solutio.jpg";
$uSevilla_url = elgg_get_site_url() . "mod/procura_alzheimer_theme/graphics/uSevilla.jpg";
$uZaragoza_url = elgg_get_site_url() . "mod/procura_alzheimer_theme/graphics/logoUZ.png";


echo '<div class="mts clearfloat center">'; //float-alt


echo elgg_view('output/url', array(
	'href' => 'http://www.aiju.es',
	'text' => "<img src=\"$aiju_url\" alt=\"Aiju\" width=\"106\" height=\"20\" />",
	'class' => '',
	'is_trusted' => true,
));

echo elgg_view('output/url', array(
	'href' => 'http://www.flowlab.es',
	'text' => "<img src=\"$flowlab_url\" alt=\"Flowlab\" width=\"106\" height=\"20\" />",
	'class' => '',
	'is_trusted' => true,
));

echo elgg_view('output/url', array(
	'href' => 'http://www.logica.com.es',
	'text' => "<img src=\"$logica_url\" alt=\"Logica, now part of CGI\" width=\"106\" height=\"20\" />",
	'class' => '',
	'is_trusted' => true,
));

echo elgg_view('output/url', array(
	'href' => 'http://www.gruposolutio.com',
	'text' => "<img src=\"$solutio_url\" alt=\"Solutio\" width=\"106\" height=\"20\" />",
	'class' => '',
	'is_trusted' => true,
));

echo elgg_view('output/url', array(
	'href' => 'http://www.us.es',
	'text' => "<img src=\"$uSevilla_url\" alt=\"Universidad de Sevilla\" width=\"106\" height=\"20\" />",
	'class' => '',
	'is_trusted' => true,
));

echo elgg_view('output/url', array(
	'href' => 'http://www.unizar.es',
	'text' => "<img src=\"$uZaragoza_url\" alt=\"Universidad de Zaragoza\" width=\"106\" height=\"20\" />",
	'class' => '',
	'is_trusted' => true,
));

echo elgg_view('output/url', array(
	'href' => 'http://www.minetur.gob.es/es-ES/Paginas/Index.aspx',
	'text' => "<img src=\"$powered_url\" alt=\"Ministerio de Industria, Energía y Turismo\" width=\"106\" height=\"20\" />",
	'class' => '',
	'is_trusted' => true,
));

echo '</div>';