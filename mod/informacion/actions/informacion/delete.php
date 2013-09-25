<?php
/**
 * Delete informacion entity
 *
 * @package informacion
 */

$informacion_guid = get_input('guid');
$informacion = get_entity($informacion_guid);

if (elgg_instanceof($informacion, 'object', 'informacion') && $informacion->canEdit()) {
	$container = get_entity($informacion->container_guid);
	if ($informacion->delete()) {
		system_message(elgg_echo('informacion:message:deleted_post'));
		if (elgg_instanceof($container, 'group')) {
			forward("informacion/group/$container->guid/all");
		} else {
			forward("informacion/owner/$container->username");
		}
	} else {
		register_error(elgg_echo('informacion:error:cannot_delete_post'));
	}
} else {
	register_error(elgg_echo('informacion:error:post_not_found'));
}

forward(REFERER);