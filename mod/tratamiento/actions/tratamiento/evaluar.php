<?php
/**
 * Save tratamiento entity
 *
 * @package Tratamiento
 */

//
// start a new sticky form session in case of failure
elgg_make_sticky_form('tratamiento');

// save or preview
$save = (bool)get_input('save');

// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();

// edit or create a new entity
$guid = get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'tratamiento') && $entity->canEdit()) {
		$tratamiento = $entity;
	} else {
		register_error(elgg_echo('tratamiento:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}

	// save some data for revisions once we save the new edit
	$revision_text = $tratamiento->description;
	$new_post = $tratamiento->new_post;
} else {
	$tratamiento = new ElggTratamiento();
	$tratamiento->subtype = 'tratamiento';
	$new_post = TRUE;
}

// set the previous status for the hooks to update the time_created and river entries
$old_status = $tratamiento->status;

// set defaults and required values.
$values = array(
	'title' => '',
	'description' => '',
	'status' => 'draft',
	'access_id' => ACCESS_DEFAULT,
	'comments_on' => 'On',
	'paciente' => NULL,
	'scorm' => NULL,
	'audio' => NULL,
	'video' => NULL,
	'categorias' => NULL,
	'oculto' => 'no',
	'estadoPrescrito' => 'si',
	'estadoVisualizado' => 'no',
	'estadoRealizado' => 'no',
	'estadoEvaluado' => 'no',
	'evaluacionFechaPreinscripcion' => time(),
	'evaluacionFechaRealizacion' => null,
	'evaluacionFechaEvaluacion' => null,
	'evaluacionEvaluacionLibre' => '',
	'evaluacionNota' => null, // Para más adelante...
	'profesional' => elgg_get_logged_in_user_guid(),
//	'container_guid' => (int)get_input('container_guid'),
);

// fail if a required entity isn't set
$required = array('title', 'description');

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
		case 'tags':
			if ($value) {
				$values[$name] = string_to_tag_array($value);
			} else {
				unset ($values[$name]);
			}
			break;

		case 'excerpt':
			if ($value) {
				$value = elgg_get_excerpt($value);
			} else {
				$value = elgg_get_excerpt($values['description']);
			}
			$values[$name] = $value;
			break;
		
		case 'paciente':
			var_dump($value);
			$values[$name] = (int)strstr($value,":",true); // No vale para tres cifras, así sí, asumiendo carácter : en los dropdown.
									//substr($value,0,2); // Pasar de 24: medico a 24. Guarrada eficaz.
			break;

//		case 'container_guid':
//			// this can't be empty or saving the base entity fails
//			if (!empty($value)) {
//				elgg_dump($user, true);
//				elgg_dump($value);
//				if (can_write_to_container($user->getGUID(), $value)) {
//					$values[$name] = $value;
//				} else {
//					$error = elgg_echo("tratamiento:error:cannot_write_to_container");
//				}
//			} else {
//				unset($values[$name]);
//			}
//			break;

		// don't try to set the guid
		case 'guid':
			unset($values['guid']);
			break;

		default:
			$values[$name] = $value;
			break;
	}
}
// if preview, force status to be draft
if ($save == false) {
	$values['status'] = 'draft';
}

// assign values to the entity, stopping on error.
if (!$error) {
	foreach ($values as $name => $value) {
//		if (FALSE === ($tratamiento->$name = $value)) {
//			$error = elgg_echo('tratamiento:error:cannot_save' . "$name=$value");
//			break;
//		}
		$tratamiento->$name = $value;
	}
}

// PROCURA añadimos mapping de Scorm.

//if ($values['scorm']!=="") {
//	// Primero, rellenamos el campo $paciente->pacienteScormID
//	$pac = get_user($values['paciente']);
//	if ( (strlen(getPacienteScormID($pac))<10) || (getPacienteScormID($pac)==NULL) ) setPacienteScormID($pac, uniqid(rand(), true));
//	// Creamos registro
//	$ScormService = new ScormEngineService(
//		'http://cloud.scorm.com/EngineWebServices/',
//		'WP01PYNGCT',
//		'ogI2ePJbyy3BJULamg1BjaeElhgsLTm3HEhnLb2g',
//		'');
//	$regService = $ScormService->getRegistrationService();
//	$regId = $values['scormRegistrationID'];
//	$courseId = $values['scorm'];
//	$learnerId = getPacienteScormID($pac);
//	$learnerFirstName = $pac->name ;
//	$learnerLastName = "asdf";	
//	$regService->CreateRegistration($regId, $courseId, $learnerId, $learnerFirstName, $learnerLastName);
//}

// only try to save base entity if no errors
if (!$error) {
	if ($tratamiento->save()) {
		// remove sticky form entries
		elgg_clear_sticky_form('tratamiento');

		// remove autosave draft if exists
		$tratamiento->deleteAnnotations('tratamiento_auto_save');

		// no longer a brand new post.
		$tratamiento->deleteMetadata('new_post');

		// if this was an edit, create a revision annotation
		if (!$new_post && $revision_text) {
			$tratamiento->annotate('tratamiento_revision', $revision_text);
		}

		system_message(elgg_echo('tratamiento:message:saved'));

		$status = $tratamiento->status;
		$db_prefix = elgg_get_config('dbprefix');

		// add to river if changing status or published, regardless of new post
		// because we remove it for drafts.
		if (($new_post || $old_status == 'draft') && $status == 'published') {
			add_to_river('river/object/tratamiento/create', 'create', elgg_get_logged_in_user_guid(), $tratamiento->getGUID());

			if ($guid) {
				$tratamiento->time_created = time();
				$tratamiento->save();
			}
		} elseif ($old_status == 'published' && $status == 'draft') {
			elgg_delete_river(array(
				'object_guid' => $tratamiento->guid,
				'action_type' => 'create',
			));
		}

		forward("tratamiento");
		
//		if ($tratamiento->status == 'published' || $save == false) {
//			forward($tratamiento->getURL());
//		} else {
//			forward("tratamiento/edit/$tratamiento->guid");
//		}
	} else {
		register_error(elgg_echo('tratamiento:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}