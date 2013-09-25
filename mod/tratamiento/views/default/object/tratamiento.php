<?php
/**
 * View for tratamiento objects
 *
 * @package Tratamiento
 */

$full = elgg_extract('full_view', $vars, FALSE);
$tratamiento = elgg_extract('entity', $vars, FALSE);

if (!$tratamiento) {
	return TRUE;
}

$owner = $tratamiento->getOwnerEntity();
$container = $tratamiento->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$description = $tratamiento->description;
$scorm = $tratamiento->scorm;
$audio = $tratamiento->audio;

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "tratamiento/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$tags = elgg_view('output/tags', array('tags' => $tratamiento->tags));
$date = elgg_view_friendly_time($tratamiento->time_created);

// The "on" status changes for comments, so best to check for !Off
if ($tratamiento->comments_on != 'Off') {
	$comments_count = $tratamiento->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $tratamiento->getURL() . '#tratamiento-comments',
			'text' => $text,
			'is_trusted' => true,
		));
	} else {
		$comments_link = '';
	}
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'tratamiento',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full) {

	$body = elgg_view('output/longtext', array(
		'value' => $tratamiento->description,
		'class' => 'tratamiento-post',
	));

	$params = array(
		'entity' => $tratamiento,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $body,
	));

} else {
	// brief view
	
	// Check Scorm
	if ($scorm === "") {	
	}
	else {
		// Hay un link de Scorm que generar...
		$ScormService = new ScormEngineService(
			'http://cloud.scorm.com/EngineWebServices/',
			'WP01PYNGCT',
			'ogI2ePJbyy3BJULamg1BjaeElhgsLTm3HEhnLb2g',
			'');
		
//		$courseService = $ScormService->getCourseService();
//		
//		$allResults = $courseService->GetCourseList();
//		
//		$link = '';
//		foreach($allResults as $course)
//		{
//			if ($course->getCourseId()===$scorm) {
//				$prevUrl = $courseService->GetPreviewUrl($course->getCourseId(),"http://localhost");
//				$link = '<a href="'.$prevUrl.'">Ver tratamiento</a>';
//				break;
//			}
//		}

		$regService = $ScormService->getRegistrationService();

		$launchUrl = $regService->GetLaunchUrl($tratamiento->scormRegistrationID,'http://localhost/tratamiento');
		$link = '<a href="'.$launchUrl.'">Ver tratamiento</a>';
		
		$description = $link . $description;
	}
	
	// Check Scorm
//	if ($audio === "") {	
//	}
//	else {
//		$link = '<a href="'.$audio.'">Escuchar audio</a>';
//		$description = $link . $description;
//	}
//	var_dump(tipoUsuario(elgg_get_logged_in_user_entity()));
	if ( (getPerfil(elgg_get_logged_in_user_guid())==="Medico") ||
			(getPerfil(elgg_get_logged_in_user_guid())==="Terapeuta") ) {
		$link = '<a href="/tratamiento/evaluarTratamiento/'.$tratamiento->guid.'">Evaluar tratamiento</a>';
		$description = $link . $description;
	}
	else if (getPerfil(elgg_get_logged_in_user_guid())==="Paciente") {
		$link = '<a href="/tratamiento/tratamientoRealizado/'.$tratamiento->guid.'">Tratamiento hecho</a>';
		$description = $description . $link; // Al final
	}
	else if (elgg_is_admin_logged_in()) {
//		// set defaults and required values.
//$values = array(
//	'title' => '',
//	'description' => '',
//	'status' => 'draft',
//	'access_id' => ACCESS_DEFAULT,
//	'comments_on' => 'On',
//	'paciente' => NULL,
//	'scorm' => NULL,
//	'audio' => NULL,
//	'video' => NULL,
//	'categorias' => NULL,
//	'oculto' => false,
//	'estadoPrescrito' => true,
//	'estadoVisualizado' => false,
//	'estadoRealizado' => false,
//	'estadoEvaluado' => false,
//	'evaluacionFechaPreinscripcion' => time(),
//	'evaluacionFechaRealizacion' => null,
//	'evaluacionFechaEvaluacion' => null,
//	'evaluacionEvaluacionLibre' => '',
//	'evaluacionNota' => null, // Para más adelante...
//	'profesional' => elgg_get_logged_in_user_guid(),
//	'container_guid' => (int)get_input('container_guid'),
//);
	var_dump($tratamiento->paciente);
		$description = $description . 'Paciente: ' . get_entity($tratamiento->paciente)->name . '</br>';
		$description = $description . 'Scorm: ' . $tratamiento->scorm . '</br>';
		$description = $description . 'Audio: ' . $tratamiento->audio . '</br>';
		$description = $description . 'Video: ' . $tratamiento->video . '</br>';
		$description = $description . 'Categorias: ' . print_r($tratamiento->categorias,true) . '</br>';
		$description = $description . 'Oculto: ' . $tratamiento->oculto . '</br>';
		$description = $description . 'estadoPrescrito: ' . $tratamiento->estadoPrescrito . '</br>';
		$description = $description . 'estadoVisualizado: ' . $tratamiento->estadoVisualizado . '</br>';
		$description = $description . 'estadoRealizado: ' . $tratamiento->estadoRealizado . '</br>';
		$description = $description . 'estadoEvaluado: ' . $tratamiento->estadoEvaluado . '</br>';
		$description = $description . 'evaluacionFechaPreinscripcion: ' . $tratamiento->evaluacionFechaPreinscripcion . '</br>';
		$description = $description . 'evaluacionFechaRealizacion: ' . $tratamiento->evaluacionFechaRealizacion . '</br>';
		$description = $description . 'evaluacionFechaEvaluacion: ' . $tratamiento->evaluacionFechaEvaluacion . '</br>';
		$description = $description . 'evaluacionEvaluacionLibre: ' . $tratamiento->evaluacionEvaluacionLibre . '</br>';
		$description = $description . 'profesional: ' . get_entity($tratamiento->profesional)->name . '</br>';
	}

	$params = array(
		'entity' => $tratamiento,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
//		'tags' => $tags,
		'content' => $description,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($owner_icon, $list_body);
}

