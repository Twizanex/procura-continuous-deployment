<?php
/**
* Elgg saludo delete
* 
* @package Elggsaludo
*/

$guid = (int) get_input('guid');

$saludo = new ElggSaludo($guid);
if (!$saludo->guid) {
	register_error(elgg_echo("saludo:deletefailed"));
	forward('saludo/all');
}

if (!$saludo->canEdit()) {
	register_error(elgg_echo("saludo:deletefailed"));
	forward($saludo->getURL());
}

$container = $saludo->getContainerEntity();

if (!$saludo->delete()) {
	register_error(elgg_echo("saludo:deletefailed"));
} else {
	system_message(elgg_echo("saludo:deleted"));
}

if (elgg_instanceof($container, 'group')) {
	forward("saludo/group/$container->guid/all");
} else {
	forward("saludo/owner/$container->username");
}
