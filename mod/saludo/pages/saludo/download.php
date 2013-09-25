<?php
/**
 * Elgg saludo download.
 *
 * @package Elggsaludo
 */

// Get the guid
$saludo_guid = get_input("guid");

// Get the saludo
$saludo = get_entity($saludo_guid);
if (!$saludo) {
	register_error(elgg_echo("saludo:downloadfailed"));
	forward();
}

$mime = $saludo->getMimeType();
if (!$mime) {
	$mime = "application/octet-stream";
}

$saludoname = $saludo->originalsaludoname;

// fix for IE https issue
header("Pragma: public");

header("Content-type: $mime");
if (strpos($mime, "image/") !== false) {
	header("Content-Disposition: inline; saludoname=\"$saludoname\"");
} else {
	header("Content-Disposition: attachment; saludoname=\"$saludoname\"");
}

ob_clean();
flush();
readfile($saludo->getFilenameOnFilestore());
exit;
