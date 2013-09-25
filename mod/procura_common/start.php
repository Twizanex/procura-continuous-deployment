<?php

include "lib/procura_common.php";

function procura_common_init() {
// 	print 'Aqui llego';
	elgg_extend_view('core/walled_garden/body', 'procura_common/walled_garden'); // No funciona por alguna razón
	
	date_default_timezone_set('Europe/Madrid');
	
	// Eliminamos elemento menú "Activity". No se puede eliminar por plugin por lo visto.
	elgg_unregister_menu_item('site', 'activity');
	elgg_unregister_page_handler('activity');
	elgg_register_page_handler('activity', 'tratamiento_page_handler');
}

elgg_register_event_handler('init', 'system', 'procura_common_init');

/**
 * Init procura_common plugin.
 */
?>