<?php
/**
 * Tratamientos
 *
 * @package Tratamiento
 *
 * @todo
 * - Either drop support for "publish date" or duplicate more entity getter
 * functions to work with a non-standard time_created.
 * - Pingbacks
 * - Notifications
 * - River entry for posts saved as drafts and later published
 */

elgg_register_event_handler('init', 'system', 'tratamiento_init');

/**
 * Init tratamiento plugin.
 */
function tratamiento_init() {

	elgg_register_library('tratamiento', elgg_get_plugins_path() . 'tratamiento/lib/tratamiento.php');
	elgg_register_library('tratamientoPlantilla', elgg_get_plugins_path() . 'tratamiento/lib/tratamientoPlantilla.php');

	// add a site navigation item
	$item = new ElggMenuItem('tratamiento', elgg_echo('Tratamientos'), 'tratamiento');
	elgg_register_menu_item('site', $item);

	elgg_register_event_handler('upgrade', 'upgrade', 'tratamiento_run_upgrades');

	// add to the main css
	elgg_extend_view('css/elgg', 'tratamiento/css');

	// register the tratamiento's JavaScript
	$tratamiento_js = elgg_get_simplecache_url('js', 'tratamiento/save_draft');
	elgg_register_simplecache_view('js/tratamiento/save_draft');
	elgg_register_js('elgg.tratamiento', $tratamiento_js);

	// routing of urls
	elgg_register_page_handler('tratamiento', 'tratamiento_page_handler');

	// override the default url to view a tratamiento object
	elgg_register_entity_url_handler('object', 'tratamiento', 'tratamiento_url_handler');

	// notifications
	register_notification_object('object', 'tratamiento', elgg_echo('tratamiento:newpost'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'tratamiento_notify_message');

	// add tratamiento link to
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'tratamiento_owner_block_menu');

	// pingbacks
	//elgg_register_event_handler('create', 'object', 'tratamiento_incoming_ping');
	//elgg_register_plugin_hook_handler('pingback:object:subtypes', 'object', 'tratamiento_pingback_subtypes');

	// Register for search.
	elgg_register_entity_type('object', 'tratamiento');
	elgg_register_entity_type('object', 'tratamientoCategory');
	elgg_register_entity_type('object', 'tratamientoPlantilla');

	// Add group option
	add_group_tool_option('tratamiento', elgg_echo('tratamiento:enabletratamiento'), true);
	elgg_extend_view('groups/tool_latest', 'tratamiento/group_module');

	// add a tratamiento widget
//	elgg_register_widget_type('tratamiento', elgg_echo('tratamiento'), elgg_echo('tratamiento:widget:description'), 'profile');

	// register actions
	$action_path = elgg_get_plugins_path() . 'tratamiento/actions/tratamiento';
	elgg_register_action('tratamiento/settings/save', "$action_path/settings/save.php");
	elgg_register_action('tratamiento/addcategory', "$action_path/addcategory.php");
	elgg_register_action('tratamiento/save', "$action_path/save.php");
	elgg_register_action('tratamiento/evaluar', "$action_path/save.php");
	elgg_register_action('tratamiento/auto_save_revision', "$action_path/auto_save_revision.php");
	elgg_register_action('tratamiento/delete', "$action_path/delete.php");
	$action_path2 = elgg_get_plugins_path() . 'tratamiento/actions/tratamientoPlantilla';
	elgg_register_action('tratamientoPlantilla/save', "$action_path2/save.php");
	elgg_register_action('tratamientoPlantilla/delete', "$action_path2/delete.php");

	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'tratamiento_entity_menu_setup');

	// ecml
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'tratamiento_ecml_views_hook');
}

function tratamiento_page_handler_paciente($page) {
		var_dump("Soy paciente!!");
		
		// @todo remove the forwarder in 1.9
		// forward to correct URL for tratamiento pages pre-1.7.5
		tratamiento_url_forwarder($page);
	
		// push all tratamientos breadcrumb
		elgg_push_breadcrumb(elgg_echo('tratamiento:tratamientos'), "tratamiento/all");
	
		if (!isset($page[0])) {
			$page[0] = 'all';
		}
	
		$page_type = $page[0];
		switch ($page_type) {
			case 'view':
				$params = tratamiento_get_page_content_read($page[1]);
				$body = elgg_view_layout('one_column', $params);
				echo elgg_view_page($params['title'], $body);
				break;
			case 'tratamientoRealizado':
				var_dump($page);
				$trat = get_entity($page[1]);
				$trat->estadoRealizado = 'si'; // Este no funciona...
				$trat->save();
				$trat->evaluacionFechaRealizacion = time(); // Este sí.
				$trat->save();
				forward('tratamiento');
				break;
			case 'all':
//				$params = tratamiento_get_page_content_list();
				$body = "";
				
//				// Load mp3
//				$options = array(
//					'type' => 'object',
//					'subtype' => 'saludo',
//				);
//		 		$options['metadata_name_value_pairs'] = array(
//					array('name' => 'paciente', 'value' => $user->guid), // Busca sólo los saludos que me referencian a mí!!
//		 		);
//				$list = elgg_get_entities_from_metadata($options);
//				foreach($list as $f) {
//					$file = new ElggSaludo($f->guid); // $f por alguna razón es de tipo ElggObject, no ElggFile, y no permite invocar getFilenameOnFilestore.
//					var_dump($file);
//					var_dump($file->getFilenameOnFilestore());
//					$body .= '<SCRIPT TYPE="text/javascript">
//							<!-- 
//							var filename="' . $file->getFilenameOnFilestore() . '";
//							if (navigator.appName == "Microsoft Internet Explorer")
//							    document.writeln (\'<BGSOUND SRC="\' + filename + \'">\');
//							else
//							    document.writeln (\'<EMBED SRC="\' + filename + \'" AUTOSTART=TRUE WIDTH=144 HEIGHT=60 HIDDEN><P>\');
//							// -->
//							</SCRIPT>';
//					break; // If there is more than one saludo (error!!) only play first one. "First" is undefined (usually, older one).
//				}
				
				// Load tratamientos
//				$options = array(
//						'type' => 'object',
//						'subtype' => 'tratamiento',
//						'full_view' => FALSE,
//				);
//		 		$options['metadata_name_value_pairs'] = array(
//		 				array('name' => 'status', 'value' => 'published'),
//						array('name' => 'pacientes', 'value' => $user->guid), // Busca sólo los tratamientos que me referencian a mí!!
//		 		);

				// New: load only one tratamiento each time.
				
//				if (!isset($page[1])) $page[1] = 0;
				$options = array(
						'type' => 'object',
						'subtype' => 'tratamiento',
						'full_view' => FALSE,
						'limit' => 1,
//						'count' => $page[1],
				);
		 		$options['metadata_name_value_pairs'] = array(
		 				array('name' => 'status', 'value' => 'published'),
						array('name' => 'paciente', 'value' => $user->guid), // Busca sólo los tratamientos que me referencian a mí!!
						array('name' => 'estadoRealizado', 'value' => 'no'),
						array('name' => 'estadoEvaluado', 'value' => 'no'),
		 		);
		 		
		 		// Para funcionalidad "tratamiento visualizado" de cara a la evaluación. Chapuza nada óptima.
		 		$offset = get_input('offset');
		 		if (!$offset) $offset = 0;
		 		$trats = elgg_get_entities_from_metadata($options);
		 		$cont = 0;
		 		foreach ($trats as $t) {
		 			if ($cont==$offset) {
		 				var_dump('visualizado');
			 			$t->estadoVisualizado = 'si';
			 			$t->save();
		 			}
		 			$cont++;
		 		}
			
				$list = elgg_list_entities_from_metadata($options);
				if (!$list) {
					$return['content'] = elgg_echo('tratamiento:none');
				} else {
					$return['content'] = $list;
				}				
				
				$body .= elgg_view_layout('one_column', $return);
				$pagina = $saludo . $br . $body;
				$user = elgg_get_logged_in_user_entity();
				$userName = $user->username; // O $user->name
				echo elgg_view_page('Tratamientos de '.$userName, $pagina);
				break;
			default:
				return false;
		}
	return true;
}

function tratamiento_page_handler_familiar($page) {
//		var_dump("Soy cuidador o familiar!!");
		
		
		// @todo remove the forwarder in 1.9
		// forward to correct URL for tratamiento pages pre-1.7.5
		tratamiento_url_forwarder($page);
	
		// push all tratamientos breadcrumb
		elgg_push_breadcrumb(elgg_echo('tratamiento:tratamientos'), "tratamiento/all");
	
		if (!isset($page[0])) {
			$page[0] = 'all';
		}
	
		$page_type = $page[0];
		switch ($page_type) {
			case 'vertratamientos':
				$pacienteID = $page[1];
				$paciente = get_entity($pacienteID);
				$body = "";
				$body .= elgg_view_title('Tratamientos de '.$paciente->name);
				
				// Mostrar tratamientos del paciente
				$options = array(
						'type' => 'object',
						'subtype' => 'tratamiento',
						'full_view' => FALSE,
				);
		 		$options['metadata_name_value_pairs'] = array(
		 				array('name' => 'status', 'value' => 'published'),
						array('name' => 'pacientes', 'value' => $pacienteID),
		 		);
			
				$list = elgg_list_entities_from_metadata($options);
				if (!$list) {
					$return['content'] = elgg_echo('tratamiento:none');
				} else {
					$return['content'] = $list;
				}			
				$body .= elgg_view_layout('one_column', $return);
				echo elgg_view_page('Tratamientos de '.$paciente->name, $body);
				return true;
				break;
			case 'verprescriptores':
				$pacienteID = $page[1];
				$paciente = get_entity($pacienteID);
				
				// Version vieja
//				$friends = $paciente->getFriends();
//				$prescriptoresArray = array();
//				foreach($friends as $friend) {
////					if (tipoUsuario($friend)==="Prescriptor")
//					if ( (procura_exists_relacion($pacienteID,$friend->guid,'P-M')) ||
//							(procura_exists_relacion($pacienteID,$friend->guid,'P-T')) )
//						$prescriptoresArray[$friend->guid] = $friend; // S—lo mŽdicos
//				}

				$prescriptoresArray = array();
				$list = procura_get_user_with_relation($pacienteID,'P-M');
				foreach($list as $relation) {
					$prescriptoresArray[$relation->entidad2] = get_user($relation->entidad2); // S—lo mis pacientes
				}
				$list = procura_get_user_with_relation($pacienteID,'P-T');
				foreach($list as $user) {
					$prescriptoresArray[$relation->entidad2] = get_user($relation->entidad2); // S—lo mis pacientes
				}
				
				$body = "";
				$body .= elgg_view_title('Prescriptores de '.$paciente->name);	
				// A–adimos pacientes
				sort($prescriptoresArray);
				foreach($prescriptoresArray as $prescriptor) {
					$imagen = elgg_view('icon/user/default', array(
						'entity' => $prescriptor,
					));
					
					$formsEnviarMensajeIntro = '<form name="' . 'formenviarmensaje' . $prescriptor->guid . '" action="/messages/add/'. $prescriptor->guid . '" method="POST">';
					$botonEnviarMensaje = elgg_view('input/submit', array(
						'value' => 'Enviar mensaje',
						'id' => 'buttonenviarmensaje'.$prescriptor->guid,
						'style' => "width:150px;"
					));
					$formEnviarMensajeOutro = '</form><br>';
					
					$params = array(
						'entity' => $prescriptor,
						'subtitle' => '',
						'content' => $formsEnviarMensajeIntro . $botonEnviarMensaje . $formEnviarMensajeOutro,
					);
					$contenido = elgg_view('object/elements/summary', $params);
					$body .= elgg_view_image_block($imagen, $contenido);
					$body .= '<br>';
				}
		 		echo elgg_view_page('Prescriptores de '.$paciente->name, $body);
		 		return true;
				break;
			case 'view':
				$params = tratamiento_get_page_content_read($page[1]);
				$body = elgg_view_layout('one_column', $params);
				echo elgg_view_page($params['title'], $body);
				return true;
				break;
			case 'all':
				$friends = $user->getFriends();
				$pacientesArray = array();
				// Version vieja
//				foreach($friends as $friend) {
////					if (tipoUsuario($friend)==="Paciente")
//					if (procura_exists_relacion($user->guid,$friend->guid,'P-F')!=NULL)
//						$pacientesArray[$friend->guid] = $friend; // S—lo mis pacientes
//				}

				$list = procura_get_user_with_relation(elgg_get_logged_in_user_guid(),'F-P');
				foreach($list as $relation) {
					$pacientesArray[$relation->entidad2] = get_user($relation->entidad2); // S—lo mis pacientes
				}
				$list = procura_get_user_with_relation(elgg_get_logged_in_user_guid(),'C-P');
				foreach($list as $relation) {
					$pacientesArray[$relation->entidad2] = get_user($relation->entidad2); // S—lo mis pacientes
				}

				
				$body = "";
				$body .= elgg_view_title('Personas al cargo de '.$user->name);	
				// A–adimos pacientes
				sort($pacientesArray);
				foreach($pacientesArray as $paciente) {
					$imagen = elgg_view('icon/user/default', array(
						'entity' => $paciente,
						'size' => 'large'
					));
					
					$formTratamientosIntro = '<form name="' . 'formtratamientos' . $paciente->guid . '" action="/tratamiento/vertratamientos/'. $paciente->guid . '" method="POST">';
					$botonTratamientos = elgg_view('input/submit', array(
						'value' => 'Ver tratamientos',
						'id' => 'buttontratamientos'.$paciente->guid,
						'style' => "width:150px;"
					));
					$formTratamientosOutro = '</form><br>';
					
					$formPrescriptoresIntro = '<form name="' . 'formprescriptores' . $paciente->guid . '" action="/tratamiento/verprescriptores/'. $paciente->guid . '" method="POST">';
					$botonPrescriptores = elgg_view('input/submit', array(
						'value' => 'Ver prescriptores',
						'id' => 'buttonprescriptores'.$paciente->guid,
						'style' => "width:150px;"
					));
					$formPrescriptoresOutro = '</form><br>';
					
					$formsEnviarMensajeIntro = '<form name="' . 'formenviarmensaje' . $paciente->guid . '" action="/messages/add/'. $paciente->guid . '" method="POST">';
					$botonEnviarMensaje = elgg_view('input/submit', array(
						'value' => 'Enviar mensaje',
						'id' => 'buttonenviarmensaje'.$paciente->guid,
						'style' => "width:150px;"
					));
					$formEnviarMensajeOutro = '</form><br>';
					
					$params = array(
						'entity' => $paciente,
						'subtitle' => '',
						'content' => $formTratamientosIntro . $botonTratamientos . $formTratamientosOutro
									. $formPrescriptoresIntro . $botonPrescriptores . $formPrescriptoresOutro
									. $formsEnviarMensajeIntro . $botonEnviarMensaje . $formEnviarMensajeOutro,
					);
					$contenido = elgg_view('object/elements/summary', $params);
					$body .= elgg_view_image_block($imagen, $contenido);
					$body .= '<br>';
				}			
				
		 		echo elgg_view_page('Pacientes de '.elgg_get_logged_in_user_entity()->name, $body);
		 		return true;
				break;
			default:
				$body = "";
				$body .= elgg_view_title('Admin');
				echo elgg_view_page('Tratamientos de '.$userName, $body);
		}			
}

function tratamiento_page_handler_prescriptor($page) {
		gatekeeper();
//		var_dump("Soy profesional o medico!!");
		
//		// @todo remove the forwarder in 1.9
//		// forward to correct URL for tratamiento pages pre-1.7.5
//		tratamiento_url_forwarder($page);
	
//		// push all tratamientos breadcrumb
//		elgg_push_breadcrumb(elgg_echo('tratamiento:tratamientos'), "tratamiento/all");
	
		if (!isset($page[0])) {
			$page[0] = 'all';
		}
	
		$page_type = $page[0];
//		var_dump($page);
		switch ($page_type) {
			case 'vertratamientos':
				$pacienteID = $page[1];
				$paciente = get_entity($pacienteID);
				// Bot—n a–adir tratamiento. OJO al form (creo que es necesario para definir el "link" a la acci—n que queremos).
				$body = "";
				$body .= elgg_view_title('Tratamientos de '.$paciente->name);
//				$formAddTratamientoIntro = '<form name="addtratamiento" action="/tratamiento/add/'.$pacienteID.'" method="POST"><br>';
//				$botonAddTratamiento = elgg_view('input/submit', array(
//					'value' => 'Agregar tratamiento',
//				));
//				$formAddTratamientoOutro = '</form><br>';
//				$body .= $formAddTratamientoIntro . $botonAddTratamiento . $formAddTratamientoOutro;
				
				// Mostrar tratamientos del paciente
				$options = array(
						'type' => 'object',
						'subtype' => 'tratamiento',
						'full_view' => FALSE,
				);
		 		$options['metadata_name_value_pairs'] = array(
		 				array('name' => 'status', 'value' => 'published'),
		 				array('name' => 'oculto', 'value' => 'no'),
						array('name' => 'paciente', 'value' => $pacienteID),
		 		);
			
				$list = elgg_list_entities_from_metadata($options);
				if (!$list) {
					$return['content'] = elgg_echo('tratamiento:none');
				} else {
					$return['content'] = $list;
				}			
				$body .= elgg_view_layout('one_column', $return);
				echo elgg_view_page('Tratamientos de '.$paciente->name, $body);
				return true;
				break;
			case 'asignarPlantilla':
//				$plantilla = get_entity($page[1]);
				gatekeeper();
				$params = tratamiento_get_page_content_asignar($page[1]);
				break;
			case 'evaluarTratamiento':
				gatekeeper();
				if (elgg_instanceof(get_entity($page[1]), 'object', 'tratamiento'))
					$params = tratamiento_get_page_content_evaluar($page_type, $page[1], $page[2]);
				$body = elgg_view_layout('one_column', $params);
				echo elgg_view_page($params['title'], $body);
				return true;
			case 'verPlantillas':
				$body = "";
				// Mostrar plantillas
				$options = array(
						'type' => 'object',
						'subtype' => 'tratamientoPlantilla',
						'full_view' => false,
						'limit' => FALSE,
				);
		 		$options['metadata_name_value_pairs'] = array(
		 				array('name' => 'oculto', 'value' => 'no'),
		 		);
			
				$list = elgg_list_entities_from_metadata($options);
//				var_dump($list);
				if (!$list) {
					$return['content'] = elgg_echo('tratamiento:none');
				} else {
					$return['content'] = $list;
				}			
				$body .= elgg_view_layout('one_column', $return);
				echo elgg_view_page('Tratamientos', $body);
				return true;
				break;
			case 'verfamiliares':
				$pacienteID = $page[1];
				$paciente = get_entity($pacienteID);
				// Versión vieja
//				$friends = $paciente->getFriends();
//				$familiaresArray = array();
//				foreach($friends as $friend) {
////					if (tipoUsuario($friend)==="Cuidador")
//					if (procura_exists_relacion($friend->guid,'P-F',$pacienteID))
//						$familiaresArray[$friend->guid] = $friend; // S—lo familiares
//				}

				$familiaresArray = array();
				$list = procura_get_user_with_relation($pacienteID,'P-F');
				foreach($list as $relation) {
					$familiaresArray[$relation->entidad2] = get_user($relation->entidad2); // S—lo mis pacientes
				}
				
				$body = "";
				$body .= elgg_view_title('Familiares de '.$paciente->name);			
				// A–adimos pacientes
				sort($familiaresArray);
				foreach($familiaresArray as $familiar) {
					$imagen = elgg_view('icon/user/default', array(
						'entity' => $familiar,
					));
					
					$formsEnviarMensajeIntro = '<form name="' . 'formenviarmensaje' . $familiar->guid . '" action="/messages/add/'. $familiar->guid . '" method="POST">';
					$botonEnviarMensaje = elgg_view('input/submit', array(
						'value' => 'Enviar mensaje',
						'id' => 'buttonenviarmensaje'.$familiar->guid,
						'style' => "width:150px;"
					));
					$formEnviarMensajeOutro = '</form><br>';
					
					$params = array(
						'entity' => $familiar,
						'subtitle' => '',
						'content' => $formsEnviarMensajeIntro . $botonEnviarMensaje . $formEnviarMensajeOutro,
					);
					$contenido = elgg_view('object/elements/summary', $params);
					$body .= elgg_view_image_block($imagen, $contenido);
					$body .= '<br>';
				}
				
		 		echo elgg_view_page('Familiares de '.$paciente->name, $body);
		 		return true;
				break;
				break;
			case 'view':
				$params = tratamiento_get_page_content_read($page[1]);
				break;
			case 'add':
				gatekeeper();
				$params = tratamiento_get_page_content_edit($page_type, $page[1]);
				break;
			case 'addPlantilla':
				gatekeeper();
//				var_dump("addPlantilla");
				$params = tratamiento_plantilla_get_page_content_edit($page_type, $page[1]);
				break;
			case 'edit':
				// No hay editPlantilla, porque el handler que lo maneja está en engine/lib/navigation linea 366 forma parte del core y no lo
				// consigo modificar. Usaremos este truco:
				gatekeeper();
				$ent = get_entity($page[1]);
				$params = array();
				if (elgg_instanceof($ent, 'object', 'tratamiento')) {
//					var_dump("tratamiento");
					$params = tratamiento_get_page_content_edit($page_type, $page[1], $page[2]);
				}
				else if (elgg_instanceof($ent, 'object', 'tratamientoPlantilla')) {
//					var_dump("tratamientoPlantilla");
					$params = tratamiento_plantilla_get_page_content_edit($page_type, $page[1], $page[2]);
				}
				break;
//			case 'editPlantilla':
//				gatekeeper();
//				$params = tratamiento_plantilla_get_page_content_edit($page_type, $page[1], $page[2]);
//				break;
			case 'all':
//				var_dump("all");
//				error_log("PRUEBA: El usuario con GUID " . elgg_get_logged_in_user_guid() . ", es decir, ". elgg_get_logged_in_user_entity()->name . ", ha entrado en Tratamientos!!");
				// Instead, use procuralog function to save it as an entity en DB.
//				var_dump("Guardando acceso en log");
//				logProcura('accessTratamientos');
				
				// Versión vieja
//				$friends = $user->getFriends();
//				var_dump($friends);
//				$pacientesArray = array();
//				foreach($friends as $friend) {
////					if (tipoUsuario($friend)==="Paciente")
//					if (procura_exists_relacion($friend->guid,'M-P',$user->guid)!=NULL)
//						$pacientesArray[$friend->guid] = $friend; // S—lo mis pacientes
//				}

				$pacientesArray = array();
				
				// Mostrar mis pacientes
				$options = array(
						'type' => 'object',
						'subtype' => 'PRPRelacion',
						'full_view' => false,
						'limit' => FALSE,
				);
		 		$options['metadata_name_value_pairs'] = array(
		 				array('name' => 'entidad2', 'value' => elgg_get_logged_in_user_guid())
		 		);
		 		
				$list = elgg_get_entities_from_metadata($options);
				foreach ($list as $relation) {
					if (get_entity($relation->tipoRelacion)->title==="Paciente - Medico") {
						$pacientesArray[$relation->entidad1] = get_user($relation->entidad1);
					}
					else if (get_entity($relation->tipoRelacion)->title==="Paciente - Terapeuta") {
						$pacientesArray[$relation->entidad1] = get_user($relation->entidad1);
					}
				}

				$body = "";
				$body .= elgg_view_title('Pacientes de '.elgg_get_logged_in_user_entity()->name);	
				// A–adimos pacientes
				sort($pacientesArray);
//				var_dump($pacientesArray);
				foreach($pacientesArray as $paciente) {
					$imagen = elgg_view('icon/user/default', array(
						'entity' => $paciente,
						'size' => 'large',
					));

					$formFamiliaresIntro = '<form name="' . 'formfamiliares' . $paciente->guid . '" action="/tratamiento/verfamiliares/'. $paciente->guid . '" method="GET">';
					$botonFamiliares = elgg_view('input/submit', array(
						'value' => 'Ver familiares',
						'id' => 'buttonfamiliares'.$paciente->guid,
						'style' => "width:150px;",
					));
					$formFamiliaresOutro = '</form><br>';
					$formTratamientosIntro = '<form name="' . 'formtratamientos' . $paciente->guid . '" action="/tratamiento/vertratamientos/'. $paciente->guid . '" method="POST">';
					$botonTratamientos = elgg_view('input/submit', array(
						'value' => 'Ver tratamientos',
						'id' => 'buttontratamientos'.$paciente->guid,
						'style' => "width:150px;",
					));
					$formTratamientosOutro = '</form><br>';
					
					$formsEnviarMensajeIntro = '<form name="' . 'formenviarmensaje' . $paciente->guid . '" action="/messages/add/'. $paciente->guid . '" method="POST">';
					$botonEnviarMensaje = elgg_view('input/submit', array(
						'value' => 'Enviar mensaje',
						'id' => 'buttonenviarmensaje'.$paciente->guid,
						'style' => "width:150px;"
					));
					$formEnviarMensajeOutro = '</form><br>';
					$params = array(
						'entity' => $paciente,
						'subtitle' => '',
						'content' => $formFamiliaresIntro . $botonFamiliares . $formFamiliaresOutro
									. $formTratamientosIntro . $botonTratamientos . $formTratamientosOutro
									. $formsEnviarMensajeIntro . $botonEnviarMensaje . $formEnviarMensajeOutro,
					);
					$contenido = elgg_view('object/elements/summary', $params);
					$body .= elgg_view_image_block($imagen, $contenido);
					$body .= '<br>';
				}
				$body .= elgg_view_title('Gestion de plantillas de tratamientos');
				
				$formAddTratamientoIntro = '<form name="addPlantilla" action="/tratamiento/addPlantilla" method="POST">';
				$botonAddTratamiento = elgg_view('input/submit', array(
					'value' => 'Agregar plantilla',
					'style' => "width:150px;",
				));
				$formAddTratamientoOutro = '</form><br>';
				$body .= $formAddTratamientoIntro . $botonAddTratamiento . $formAddTratamientoOutro;
				
				$formViewTratamientoIntro = '<form name="verPlantillas" action="/tratamiento/verPlantillas" method="POST">';
				$botonViewTratamiento = elgg_view('input/submit', array(
					'value' => 'Ver plantillas',
					'style' => "width:150px;",
				));
				$formViewTratamientoOutro = '</form><br>';
				$body .= $formViewTratamientoIntro . $botonViewTratamiento . $formViewTratamientoOutro;
				
		 		echo elgg_view_page('Pacientes', $body);
		 		return true;
				break;
			default:
				$body = "";
				$body .= elgg_view_title('Admin');
				echo elgg_view_page('Tratamientos de '.$userName, $body);
		}
	$body = elgg_view_layout('one_column', $params);
	echo elgg_view_page($params['title'], $body);
	return true;
}

function tratamiento_page_handler_admin($page) {
	admin_gatekeeper();
	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$page_type = $page[0];
	switch ($page_type) {
		case 'addcategory':
			$category = new ElggTratamientoCategory();
			$tratamiento->subtype = 'tratamientoCategory';
			
			if (!isset($page[1])) {
				$page[1] = 'FALLO';
			}
			// set defaults and required values.
			$values = array(
				'title' => '',
				'access_id' => ACCESS_DEFAULT,
			);
			
			// fail if a required entity isn't set
			$required = array('title');
			
			// load from POST and do sanity and access checking
			foreach ($values as $name => $default) {
				$value = get_input($name, $default);
				if (in_array($name, $required) && empty($value)) {
					$error = elgg_echo("tratamiento:error:missing:$name");
				}
			
				if ($error) {
					break;
				}
			
				switch ($name) {
					case 'guid':
						unset($values['guid']);
						break;
			
					default:
						$values[$name] = $value;
						break;
				}
			}
			
			// assign values to the entity, stopping on error.
			if (!$error) {
				foreach ($values as $name => $value) {
					if (FALSE === ($category->$name = $value)) {
						$error = elgg_echo('tratamiento:error:cannot_save' . "$name=$value");
						break;
					}
				}
			}
			
			// only try to save base entity if no errors
			if (!$error)
				if ($category->save())
					system_message(elgg_echo('tratamiento:message:saved'));
			forward('admin/plugin_settings/tratamiento');
			return true;
			break;
		case 'edit':
			gatekeeper();
			if (elgg_instanceof(get_entity($page[1]), 'object', 'tratamiento'))
				$params = tratamiento_get_page_content_edit($page_type, $page[1], $page[2]);
			else if (elgg_instanceof(get_entity($page[1]), 'object', 'tratamientoPlantilla'))
				$params = tratamiento_plantilla_get_page_content_edit($page_type, $page[1], $page[2]);
			$body = elgg_view_layout('one_column', $params);
			echo elgg_view_page($params['title'], $body);
			return true;
		case 'verPlantillas':
		case 'all':
			$body = "";
			$body .= elgg_view_title('Plantillas');
			// Mostrar plantillas
			$options = array(
					'type' => 'object',
					'subtype' => 'tratamientoPlantilla',
					'full_view' => false,
					'limit' => FALSE,
			);
		
			$list = elgg_list_entities_from_metadata($options);
			if (!$list) {
				$return['content'] = elgg_echo('tratamiento:none');
			} else {
				$return['content'] = $list;
			}			
			$body .= elgg_view_layout('one_column', $return);
			$body .= elgg_view_title('Tratamientos');
			// Mostrar tratamientos
			$options = array(
					'type' => 'object',
					'subtype' => 'tratamiento',
					'full_view' => false,
					'limit' => FALSE,
			);
		
			$list = elgg_list_entities_from_metadata($options);
			if (!$list) {
				$return['content'] = elgg_echo('tratamiento:none');
			} else {
				$return['content'] = $list;
			}			
			$body .= elgg_view_layout('one_column', $return);
			echo elgg_view_page('Tratamientos', $body);
			return true;
			break;
		default:
			$body = "";
			$body .= elgg_view_title('Admin');
			echo elgg_view_page('Tratamientos de '.$userName, $body);
	}
}

/**
 * Dispatches tratamiento pages.
 * URLs take the form of
 *  All tratamientos:       tratamiento/all
 *  User's tratamientos:    tratamiento/owner/<username>
 *  Friends' tratamiento:   tratamiento/friends/<username>
 *  User's archives: tratamiento/archives/<username>/<time_start>/<time_stop>
 *  Tratamiento post:       tratamiento/view/<guid>/<title>
 *  New post:        tratamiento/add/<guid>
 *  Edit post:       tratamiento/edit/<guid>/<revision>
 *  Preview post:    tratamiento/preview/<guid>
 *  Group tratamiento:      tratamiento/group/<guid>/all
 *
 * Title is ignored
 *
 * @todo no archives for all tratamientos or friends
 *
 * @param array $page
 * @return bool
 */
function tratamiento_page_handler($page) {
	
	elgg_load_library('tratamiento');
	elgg_load_library('tratamientoPlantilla');
	elgg_load_library('prp'); // Sin esto NO funciona!!
	elgg_load_library('perfiles');
	elgg_load_library('relaciones');
	elgg_load_library('permisos');
	
	// Discriminar por tipo de usuario...
	
	$user = elgg_get_logged_in_user_entity();
	$userName = $user->username; // O $user->name
	$saludo = elgg_view_title('Bienvenido a la plataforma, '.$userName.'!!');
	$userID = elgg_get_logged_in_user_guid();
	
	// @todo remove the forwarder in 1.9
		// forward to correct URL for tratamiento pages pre-1.7.5
//		tratamiento_url_forwarder($page);

//	var_dump(getPerfil($userID));
	
	if (getPerfil($userID)==="Paciente") {
	// PHP no admite empty() en funciones, solo en variables, al no ser una función sino un "language construct"
	// http://stackoverflow.com/questions/1532693/weird-php-error-cant-use-function-return-value-in-write-context
//	if ( !empty($list) || !empty($list2) ) {
//	if ( count(procura_get_user_with_relation(elgg_get_logged_in_user_guid(),'P-T'))!=0 || 
//			count(procura_get_user_with_relation(elgg_get_logged_in_user_guid(),'P-M'))!=0 ) {
		return tratamiento_page_handler_paciente($page);
	}
	else if (getPerfil($userID)==="Medico") {
//		return tratamiento_page_handler_admin($page);
		return tratamiento_page_handler_prescriptor($page);	
	}
	else if (getPerfil($userID)==="Terapeuta") { // Pudiera ser distinto al de Médico en un futuro.
		return tratamiento_page_handler_prescriptor($page);	
	}
	else if (getPerfil($userID)==="Cuidador") {
		return tratamiento_page_handler_cuidador($page);	
	}
	else if (getPerfil($userID)==="Familiar") {
		return tratamiento_page_handler_familiar($page);
	}
	else { // Vista por defecto, para admin.
		return tratamiento_page_handler_admin($page);
	}	
	return true;
}

/**
 * Format and return the URL for tratamientos.
 *
 * @param ElggObject $entity Tratamiento object
 * @return string URL of tratamiento.
 */
function tratamiento_url_handler($entity) {
	if (!$entity->getOwnerEntity()) {
		// default to a standard view if no owner.
		return FALSE;
	}

	$friendly_title = elgg_get_friendly_title($entity->title);

	return "tratamiento/view/{$entity->guid}/$friendly_title";
}

/**
 * Add a menu item to an ownerblock
 */
function tratamiento_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "tratamiento/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('tratamiento', elgg_echo('tratamiento'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->tratamiento_enable != "no") {
			$url = "tratamiento/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('tratamiento', elgg_echo('tratamiento:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add particular tratamiento links/info to entity menu
 */
function tratamiento_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'tratamiento') {
		return $return;
	}

	if ($entity->canEdit() && $entity->status != 'published') {
		$status_text = elgg_echo("tratamiento:status:{$entity->status}");
		$options = array(
			'name' => 'published_status',
			'text' => "<span>$status_text</span>",
			'href' => false,
			'priority' => 150,
		);
		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}

/**
 * Register tratamientos with ECML.
 */
function tratamiento_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['object/tratamiento'] = elgg_echo('tratamiento:tratamientos');

	return $return_value;
}

/**
 * Upgrade from 1.7 to 1.8.
 */
function tratamiento_run_upgrades($event, $type, $details) {
	$tratamiento_upgrade_version = get_plugin_setting('upgrade_version', 'tratamientos');

	if (!$tratamiento_upgrade_version) {
		 // When upgrading, check if the ElggTratamiento class has been registered as this
		 // was added in Elgg 1.8
		if (!update_subtype('object', 'tratamiento', 'ElggTratamiento')) {
			add_subtype('object', 'tratamiento', 'ElggTratamiento');
		}

		// only run this on the first migration to 1.8
		// add excerpt to all tratamientos that don't have it.
		$ia = elgg_set_ignore_access(true);
		$options = array(
			'type' => 'object',
			'subtype' => 'tratamiento'
		);

		$tratamientos = new ElggBatch('elgg_get_entities', $options);
		foreach ($tratamientos as $tratamiento) {
			if (!$tratamiento->excerpt) {
				$tratamiento->excerpt = elgg_get_excerpt($tratamiento->description);
			}
		}

		elgg_set_ignore_access($ia);

		elgg_set_plugin_setting('upgrade_version', 1, 'tratamientos');
	}
}
