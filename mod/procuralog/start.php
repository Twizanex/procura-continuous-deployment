<?php

include "lib/procuralog.php";

elgg_register_event_handler('init', 'system', 'procuralog_init');

/**
 * Init procuralog plugin.
 */
function procuralog_init() {

	elgg_register_library('elgg:procuralog', elgg_get_plugins_path() . 'procuralog/lib/procuralog.php');

	elgg_register_entity_type('object', 'procuralog');
	
	// add a site navigation item
	if (elgg_is_admin_logged_in()) {
		$item = new ElggMenuItem('procuralog', 'Log de eventos', 'procuralog');
		elgg_register_menu_item('site', $item);
	}

	// routing of urls
	elgg_register_page_handler('procuralog', 'procuralog_page_handler');

	// override the default url to view a procuralog object
	elgg_register_entity_url_handler('object', 'procuralog', 'procuralog_url_handler');


//	// register actions
//	$action_path = elgg_get_plugins_path() . 'procuralog/actions/procuralog';
//	elgg_register_action('procuralog/save', "$action_path/save.php");
//	elgg_register_action('procuralog/auto_save_revision', "$action_path/auto_save_revision.php");
//	elgg_register_action('procuralog/delete', "$action_path/delete.php");
//
//	// entity menu
//	elgg_register_plugin_hook_handler('register', 'menu:entity', 'procuralog_entity_menu_setup');
//
//	// ecml
//	elgg_register_plugin_hook_handler('get_views', 'ecml', 'procuralog_ecml_views_hook');
}

function procuralog_page_handler($page) {
	
	admin_gatekeeper();
	
	$options = array(
		'type' => 'object',
		'subtype' => 'procuralog',
		'limit' => '20',
	);
// 	$options['metadata_name_value_pairs'] = array(
//		array('name' => 'paciente', 'value' => $user->guid), // Busca sólo los saludos que me referencian a mí!!
// 	);

	
	$body = '';
	$body .= '<table class="elgg-table" width="100\%">';
	$body .= '<tr>';
	$body .= '<th>';
	$body .= 'GUID';
	$body .= '</th>';
	$body .= '<th>';
	$body .= 'Nombre';
	$body .= '</th>';
	$body .= '<th>';
	$body .= 'Evento';
	$body .= '</th>';
	$body .= '<th>';
	$body .= 'Fecha';
	$body .= '</th>';
	$body .= '</tr>';
	
	$list = elgg_get_entities_from_metadata($options);
//	var_dump($list);
//	$list2 = elgg_list_entities_from_metadata($options);
	foreach($list as $ent) {
//		$file = new ElggSaludo($f->guid); // $f por alguna razón es de tipo ElggObject, no ElggFile, y no permite invocar getFilenameOnFilestore.
		$entradaLog = get_entity($ent->guid);
		if ($entradaLog->getMetaData('userGUID')==null) continue;
//		var_dump($entradaLog);
		// Curiosamente, se guardan como metadatos (en la función logProcura() no funciona $entity->save()). Igualmente, pueden ser accedidos.
		$body .= '<tr>';
		
		$body .= '<td>';
		$body .= $entradaLog->getMetaData('userGUID');
		$body .= '</td>';
		
		$body .= '<td>';
		$body .= get_user($entradaLog->getMetaData('userGUID'))->name;
		$body .= '</td>';
		
		$body .= '<td>';
		$body .= $entradaLog->getMetaData('eventType');
		$body .= '</td>';
		
		$body .= '<td>';
		$body .= date('l jS \of F Y h:i:s A',$entradaLog->getMetaData('timestamp'));
		$body .= '</td>';
		
		$body .= '</tr>';

//		var_dump($entradaLog->getMetaData('userGUID'));
//		var_dump($entradaLog->getMetaData('timestamp'));
//		var_dump($entradaLog->getMetaData('eventType'));

	}
	$body .= '</table>';
//	$return['content'] = $body;			
//	$body2 .= elgg_view_layout('one_column', $return);
	echo elgg_view_page('Log Procura', $body);
	return true;
}
	