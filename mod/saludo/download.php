<?php
/**
 * Elgg saludo download.
 * 
 * @package Elggsaludo
 */
require_once(dirname(dirname(dirname(__saludo__))) . "/engine/start.php");

// Get the guid
$saludo_guid = get_input("saludo_guid");

forward("saludo/download/$saludo_guid");
