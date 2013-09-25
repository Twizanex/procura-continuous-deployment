<?php
/**
 * Elgg saludo plugin language pack
 *
 * @package Elggsaludo
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	'saludo' => "Saludos",
	'saludo:user' => "%s's saludos",
	'saludo:friends' => "Friends' saludos",
	'saludo:all' => "All site saludos",
	'saludo:edit' => "Edit saludo",
	'saludo:more' => "More saludos",
	'saludo:list' => "list view",
	'saludo:group' => "Group saludos",
	'saludo:gallery' => "gallery view",
	'saludo:gallery_list' => "Gallery or list view",
	'saludo:num_FILES' => "Number of saludos to display",
	'saludo:user:gallery'=>'View %s gallery',
	'saludo:via' => 'via saludos',
	'saludo:upload' => "Upload a saludo",
	'saludo:replace' => 'Replace saludo content (leave blank to not change saludo)',
	'saludo:list:title' => "%s's %s %s",
	'saludo:title:friends' => "Friends'",

	'saludo:add' => 'Upload a saludo',

	'saludo:saludo' => "saludo",
	'saludo:title' => "Title",
	'saludo:desc' => "Description",
	'saludo:tags' => "Tags",

	'saludo:list:list' => 'Switch to the list view',
	'saludo:list:gallery' => 'Switch to the gallery view',

	'saludo:types' => "Uploaded saludo types",

	'saludo:type:' => 'saludos',
	'saludo:type:all' => "All saludos",
	'saludo:type:video' => "Videos",
	'saludo:type:document' => "Documents",
	'saludo:type:audio' => "Audio",
	'saludo:type:image' => "Pictures",
	'saludo:type:general' => "General",

	'saludo:user:type:video' => "%s's videos",
	'saludo:user:type:document' => "%s's documents",
	'saludo:user:type:audio' => "%s's audio",
	'saludo:user:type:image' => "%s's pictures",
	'saludo:user:type:general' => "%s's general saludos",

	'saludo:friends:type:video' => "Your friends' videos",
	'saludo:friends:type:document' => "Your friends' documents",
	'saludo:friends:type:audio' => "Your friends' audio",
	'saludo:friends:type:image' => "Your friends' pictures",
	'saludo:friends:type:general' => "Your friends' general saludos",

	'saludo:widget' => "saludo widget",
	'saludo:widget:description' => "Showcase your latest saludos",

	'groups:enablesaludos' => 'Enable group saludos',

	'saludo:download' => "Download this",

	'saludo:delete:confirm' => "Are you sure you want to delete this saludo?",

	'saludo:tagcloud' => "Tag cloud",

	'saludo:display:number' => "Number of saludos to display",

	'river:create:object:saludo' => '%s uploaded the saludo %s',
	'river:comment:object:saludo' => '%s commented on the saludo %s',

	'item:object:saludo' => 'saludos',

	'saludo:newupload' => 'A new saludo has been uploaded',

	/**
	 * Embed media
	 **/

		'saludo:embed' => "Embed media",
		'saludo:embedall' => "All",

	/**
	 * Status messages
	 */

		'saludo:saved' => "Your saludo was successfully saved.",
		'saludo:deleted' => "Your saludo was successfully deleted.",

	/**
	 * Error messages
	 */

		'saludo:none' => "No saludos.",
		'saludo:uploadfailed' => "Sorry; we could not save your saludo.",
		'saludo:downloadfailed' => "Sorry; this saludo is not available at this time.",
		'saludo:deletefailed' => "Your saludo could not be deleted at this time.",
		'saludo:noaccess' => "You do not have permissions to change this saludo",
		'saludo:cannotload' => "There was an error uploading the saludo",
		'saludo:nosaludo' => "You must select a saludo",
);

add_translation("en", $english);