<?php
/**
 * Elgg saludo uploader/edit action
 *
 * @package Elggsaludo
 */

// Get variables
$paciente = get_input("paciente");
$title = get_input("title");
$desc = get_input("description");
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('saludo_guid');
$tags = get_input("tags");

if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('saludo');

// check if upload failed
if (!empty($_FILES['upload']['name']) && $_FILES['upload']['error'] != 0) {
	register_error(elgg_echo('saludo:cannotload'));
	forward(REFERER);
}

// check whether this is a new saludo or an edit
$new_saludo = true;
if ($guid > 0) {
	$new_saludo = false;
}

if ($new_saludo) {
	// must have a saludo if a new saludo upload
	if (empty($_FILES['upload']['name'])) {
		$error = elgg_echo('saludo:nosaludo');
		register_error($error);
		forward(REFERER);
	}

	$saludo = new ElggSaludo();

	// if no title on new upload, grab saludoname
	if (empty($title)) {
		$title = $_FILES['upload']['name'];
	}

} else {
	// load original saludo object
	$saludo = new ElggSaludo($guid);
	if (!$saludo) {
		register_error(elgg_echo('saludo:cannotload'));
		forward(REFERER);
	}

	// user must be able to edit saludo
	if (!$saludo->canEdit()) {
		register_error(elgg_echo('saludo:noaccess'));
		forward(REFERER);
	}

	if (!$title) {
		// user blanked title, but we need one
		$title = $saludo->title;
	}
}

$saludo->title = $title;
$saludo->paciente = $paciente;
$saludo->description = $desc;
$saludo->access_id = $access_id;
$saludo->container_guid = $container_guid;

$tags = explode(",", $tags);
$saludo->tags = $tags;

// we have a saludo upload, so process it
if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {

	$prefix = "saludo/";

	// if previous saludo, delete it
	if ($new_saludo == false) {
		$saludoname = $saludo->getFilenameOnFilestore();
		if (file_exists($saludoname)) {
			unlink($saludoname);
		}

		// use same saludoname on the disk - ensures thumbnails are overwritten
		$saludostorename = $saludo->getFilename();
		$saludostorename = elgg_substr($saludostorename, elgg_strlen($prefix));
	} else {
		$saludostorename = elgg_strtolower(time().$_FILES['upload']['name']);
	}

	$mime_type = $saludo->detectMimeType($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);
	$saludo->setFilename($prefix . $saludostorename);
	$saludo->setMimeType($mime_type);
	$saludo->originalfilename = $_FILES['upload']['name'];
	$saludo->simpletype = saludo_get_simple_type($mime_type);

	// Open the saludo to guarantee the directory exists
	$saludo->open("write");
	$saludo->close();
	move_uploaded_file($_FILES['upload']['tmp_name'], $saludo->getFilenameOnFilestore());

	var_dump($saludo);
	$guid = $saludo->save();

	// if image, we need to create thumbnails (this should be moved into a function)
	if ($guid && $saludo->simpletype == "image") {
		$saludo->icontime = time();
		
		$thumbnail = get_resized_image_from_existing_saludo($saludo->getFilenameOnFilestore(), 60, 60, true);
		if ($thumbnail) {
			$thumb = new ElggSaludo();
			$thumb->setMimeType($_FILES['upload']['type']);

			$thumb->setsaludoname($prefix."thumb".$saludostorename);
			$thumb->open("write");
			$thumb->write($thumbnail);
			$thumb->close();

			$saludo->thumbnail = $prefix."thumb".$saludostorename;
			unset($thumbnail);
		}

		$thumbsmall = get_resized_image_from_existing_saludo($saludo->getsaludonameOnsaludostore(), 153, 153, true);
		if ($thumbsmall) {
			$thumb->setsaludoname($prefix."smallthumb".$saludostorename);
			$thumb->open("write");
			$thumb->write($thumbsmall);
			$thumb->close();
			$saludo->smallthumb = $prefix."smallthumb".$saludostorename;
			unset($thumbsmall);
		}

		$thumblarge = get_resized_image_from_existing_saludo($saludo->getsaludonameOnsaludostore(), 600, 600, false);
		if ($thumblarge) {
			$thumb->setsaludoname($prefix."largethumb".$saludostorename);
			$thumb->open("write");
			$thumb->write($thumblarge);
			$thumb->close();
			$saludo->largethumb = $prefix."largethumb".$saludostorename;
			unset($thumblarge);
		}
	}
} else {
	// not saving a saludo but still need to save the entity to push attributes to database
	$saludo->save();
}

// saludo saved so clear sticky form
elgg_clear_sticky_form('saludo');


// handle results differently for new saludos and saludo updates
if ($new_saludo) {
	if ($guid) {
		$message = elgg_echo("saludo:saved");
		system_message($message);
		add_to_river('river/object/saludo/create', 'create', elgg_get_logged_in_user_guid(), $saludo->guid);
	} else {
		// failed to save saludo object - nothing we can do about this
		$error = elgg_echo("saludo:uploadfailed");
		register_error($error);
	}

	$container = get_entity($container_guid);
	if (elgg_instanceof($container, 'group')) {
		forward("saludo/group/$container->guid/all");
	} else {
		forward("saludo/owner/$container->username");
	}

} else {
	if ($guid) {
		system_message(elgg_echo("saludo:saved"));
	} else {
		register_error(elgg_echo("saludo:uploadfailed"));
	}

	forward($saludo->getURL());
}	
