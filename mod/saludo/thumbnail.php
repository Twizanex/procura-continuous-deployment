<?php
/**
 * Elgg saludo thumbnail
 *
 * @package Elggsaludo
 */

// Get engine
require_once(dirname(dirname(dirname(__saludo__))) . "/engine/start.php");

// Get saludo GUID
$saludo_guid = (int) get_input('saludo_guid', 0);

// Get saludo thumbnail size
$size = get_input('size', 'small');

$saludo = get_entity($saludo_guid);
if (!$saludo || $saludo->getSubtype() != "saludo") {
	exit;
}

$simpletype = $saludo->simpletype;
if ($simpletype == "image") {

	// Get saludo thumbnail
	switch ($size) {
		case "small":
			$thumbsaludo = $saludo->thumbnail;
			break;
		case "medium":
			$thumbsaludo = $saludo->smallthumb;
			break;
		case "large":
		default:
			$thumbsaludo = $saludo->largethumb;
			break;
	}

	// Grab the saludo
	if ($thumbsaludo && !empty($thumbsaludo)) {
		$readsaludo = new Elggsaludo();
		$readsaludo->owner_guid = $saludo->owner_guid;
		$readsaludo->setsaludoname($thumbsaludo);
		$mime = $saludo->getMimeType();
		$contents = $readsaludo->grabsaludo();

		// caching images for 10 days
		header("Content-type: $mime");
		header('Expires: ' . date('r',time() + 864000));
		header("Pragma: public", true);
		header("Cache-Control: public", true);
		header("Content-Length: " . strlen($contents));

		echo $contents;
		exit;
	}
}
