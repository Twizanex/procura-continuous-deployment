<?php
/**
 * Delete tratamiento entity
 *
 * @package Tratamiento
 */

$tratamiento_guid = get_input('guid');
$tratamiento = get_entity($tratamiento_guid);

if (elgg_instanceof($tratamiento, 'object', 'tratamiento')) {
	if ($tratamiento->delete()) {
		forward(REFERER);
	} else {
		register_error(elgg_echo('tratamiento:error:cannot_delete_post'));
	}
}
else if (elgg_instanceof($tratamiento, 'object', 'tratamientoCategory')) { // Añadido para tratamientoCategory
	if ($tratamiento->delete()) {
		forward(REFERER);
	} else {
		register_error(elgg_echo('tratamiento:error:cannot_delete_post'));
	}
}
else if (elgg_instanceof($tratamiento, 'object', 'tratamientoPlantilla')) { // Añadido para tratamientoPlantilla
	$container = get_entity($tratamiento->container_guid);
	if (!$tratamiento->oculto) { // En lugar de borrarlo, lo ocultamos
		$tratamiento->oculto = true;
		$tratamiento->save();
		forward(REFERER);
	}
	else { // Borramos (como admin, sino es imposible) definitivamente una plantilla
		admin_gatekeeper();
		if ($tratamiento->delete()) {
			forward(REFERER);
		} else {
			register_error(elgg_echo('tratamiento:error:cannot_delete_post'));
		}
	}
}
else {
	register_error(elgg_echo('tratamiento:error:post_not_found'));
}

forward(REFERER);