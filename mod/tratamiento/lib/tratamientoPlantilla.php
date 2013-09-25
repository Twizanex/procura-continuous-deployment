<?php
/**
 * Tratamiento helper functions
 *
 * @package Tratamiento
 */


/**
 * Get page components to view a tratamiento post.
 *
 * @param int $guid GUID of a tratamiento entity.
 * @return array
 */
function tratamiento_plantilla_get_page_content_read($guid = NULL) {

	$return = array();

	$tratamiento = get_entity($guid);

	// no header or tabs for viewing an individual tratamiento
	$return['filter'] = '';

	if (!elgg_instanceof($tratamiento, 'object', 'tratamientoPlantilla')) {
		$return['content'] = elgg_echo('tratamiento:error:post_not_found');
		return $return;
	}

	$return['title'] = htmlspecialchars($tratamiento->title);

	$container = $tratamiento->getContainerEntity();
	$crumbs_title = $container->name;
	if (elgg_instanceof($container, 'group')) {
		elgg_push_breadcrumb($crumbs_title, "tratamiento/group/$container->guid/all");
	} else {
		elgg_push_breadcrumb($crumbs_title, "tratamiento/owner/$container->username");
	}

	elgg_push_breadcrumb($tratamiento->title);
	$return['content'] = elgg_view_entity($tratamiento, array('full_view' => true));
	//check to see if comment are on
	if ($tratamiento->comments_on != 'Off') {
		$return['content'] .= elgg_view_comments($tratamiento);
	}

	return $return;
}

/**
 * Get page components to list a user's or all tratamientos.
 *
 * @param int $owner_guid The GUID of the page owner or NULL for all tratamientos
 * @return array
 */
function tratamiento_plantilla_get_page_content_list($container_guid = NULL) {

	$return = array();

	$return['filter_context'] = $container_guid ? 'mine' : 'all';

	$options = array(
		'type' => 'object',
		'subtype' => 'tratamiento',
		'full_view' => FALSE,
	);

	$loggedin_userid = elgg_get_logged_in_user_guid();
	if ($container_guid) {
		// access check for closed groups
		group_gatekeeper();

		$options['container_guid'] = $container_guid;
		$container = get_entity($container_guid);
		if (!$container) {

		}
		$return['title'] = elgg_echo('tratamiento:title:user_tratamientos', array($container->name));

		$crumbs_title = $container->name;
		elgg_push_breadcrumb($crumbs_title);

		if ($container_guid == $loggedin_userid) {
			$return['filter_context'] = 'mine';
		} else if (elgg_instanceof($container, 'group')) {
			$return['filter'] = false;
		} else {
			// do not show button or select a tab when viewing someone else's posts
			$return['filter_context'] = 'none';
		}
	} else {
		$return['filter_context'] = 'all';
		$return['title'] = elgg_echo('tratamiento:title:all_tratamientos');
		elgg_pop_breadcrumb();
		elgg_push_breadcrumb(elgg_echo('tratamiento:tratamientos'));
	}

	elgg_register_title_button();

	// show all posts for admin or users looking at their own tratamientos
	// show only published posts for other users.
	if (!(elgg_is_admin_logged_in() || (elgg_is_logged_in() && $container_guid == $loggedin_userid))) {
		$options['metadata_name_value_pairs'] = array(
			array('name' => 'status', 'value' => 'published'),
		);
	}

	$list = elgg_list_entities_from_metadata($options);
	if (!$list) {
		$return['content'] = elgg_echo('tratamiento:none');
	} else {
		$return['content'] = $list;
	}

	return $return;
}

/**
 * Get page components to list of the user's friends' posts.
 *
 * @param int $user_guid
 * @return array
 */
function tratamiento_plantilla_get_page_content_friends($user_guid) {

	$user = get_user($user_guid);
	if (!$user) {
		forward('tratamiento/all');
	}

	$return = array();

	$return['filter_context'] = 'friends';
	$return['title'] = elgg_echo('tratamiento:title:friends');

	$crumbs_title = $user->name;
	elgg_push_breadcrumb($crumbs_title, "tratamiento/owner/{$user->username}");
	elgg_push_breadcrumb(elgg_echo('friends'));

	elgg_register_title_button();

	if (!$friends = get_user_friends($user_guid, ELGG_ENTITIES_ANY_VALUE, 0)) {
		$return['content'] .= elgg_echo('friends:none:you');
		return $return;
	} else {
		$options = array(
			'type' => 'object',
			'subtype' => 'tratamiento',
			'full_view' => FALSE,
		);

		foreach ($friends as $friend) {
			$options['container_guids'][] = $friend->getGUID();
		}

		// admin / owners can see any posts
		// everyone else can only see published posts
		if (!(elgg_is_admin_logged_in() || (elgg_is_logged_in() && $owner_guid == elgg_get_logged_in_user_guid()))) {
			if ($upper > $now) {
				$upper = $now;
			}

			$options['metadata_name_value_pairs'][] = array(
				array('name' => 'status', 'value' => 'published')
			);
		}

		$list = elgg_list_entities_from_metadata($options);
		if (!$list) {
			$return['content'] = elgg_echo('tratamiento:none');
		} else {
			$return['content'] = $list;
		}
	}

	return $return;
}

/**
 * Get page components to show tratamientos with publish dates between $lower and $upper
 *
 * @param int $owner_guid The GUID of the owner of this page
 * @param int $lower      Unix timestamp
 * @param int $upper      Unix timestamp
 * @return array
 */
function tratamiento_plantilla_get_page_content_archive($owner_guid, $lower = 0, $upper = 0) {

	$now = time();

	$user = get_user($owner_guid);
	elgg_set_page_owner_guid($owner_guid);

	$crumbs_title = $user->name;
	elgg_push_breadcrumb($crumbs_title, "tratamiento/owner/{$user->username}");
	elgg_push_breadcrumb(elgg_echo('tratamiento:archives'));

	if ($lower) {
		$lower = (int)$lower;
	}

	if ($upper) {
		$upper = (int)$upper;
	}

	$options = array(
		'type' => 'object',
		'subtype' => 'tratamiento',
		'full_view' => FALSE,
	);

	if ($owner_guid) {
		$options['owner_guid'] = $owner_guid;
	}

	// admin / owners can see any posts
	// everyone else can only see published posts
	if (!(elgg_is_admin_logged_in() || (elgg_is_logged_in() && $owner_guid == elgg_get_logged_in_user_guid()))) {
		if ($upper > $now) {
			$upper = $now;
		}

		$options['metadata_name_value_pairs'] = array(
			array('name' => 'status', 'value' => 'published')
		);
	}

	if ($lower) {
		$options['created_time_lower'] = $lower;
	}

	if ($upper) {
		$options['created_time_upper'] = $upper;
	}

	$list = elgg_list_entities_from_metadata($options);
	if (!$list) {
		$content .= elgg_echo('tratamiento:none');
	} else {
		$content .= $list;
	}

	$title = elgg_echo('date:month:' . date('m', $lower), array(date('Y', $lower)));

	return array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
}

/**
 * Get page components to edit/create a tratamiento post.
 *
 * @param string  $page     'edit' or 'new'
 * @param int     $guid     GUID of tratamiento post or container
 * @param int     $revision Annotation id for revision to edit (optional)
 * @return array
 */
function tratamiento_plantilla_get_page_content_edit($page, $guid = 0, $revision = NULL) {

	elgg_load_js('elgg.tratamiento');

	$return = array(
		'filter' => '',
	);

	$vars = array();
	$vars['id'] = 'tratamiento-post-edit';
	$vars['name'] = 'tratamiento_post';
	$vars['class'] = 'elgg-form-alt';

	if ($page == 'edit') {
		$tratamiento = get_entity((int)$guid);

		$title = elgg_echo('tratamiento:edit');

		if (elgg_instanceof($tratamiento, 'object', 'tratamientoPlantilla') && $tratamiento->canEdit()) {
			$vars['entity'] = $tratamiento;

			$title .= ": \"$tratamiento->title\"";

			if ($revision) {
				$revision = elgg_get_annotation_from_id((int)$revision);
				$vars['revision'] = $revision;
				$title .= ' ' . elgg_echo('tratamiento:edit_revision_notice');

				if (!$revision || !($revision->entity_guid == $guid)) {
					$content = elgg_echo('tratamiento:error:revision_not_found');
					$return['content'] = $content;
					$return['title'] = $title;
					return $return;
				}
			}

			$body_vars = tratamiento_plantilla_prepare_form_vars($tratamiento, $revision);

			elgg_push_breadcrumb($tratamiento->title, $tratamiento->getURL());
			elgg_push_breadcrumb(elgg_echo('edit'));
			
			elgg_load_js('elgg.tratamiento');

			$content = elgg_view_form('tratamientoPlantilla/save', $vars, $body_vars);
			$sidebar = elgg_view('tratamiento/sidebar/revisions', $vars);
		} else {
			$content = elgg_echo('tratamiento:error:cannot_edit_post');
		}
	} else {
		if (!$guid) {
			$container = elgg_get_logged_in_user_entity();
		} else {
			$container = get_entity($guid);
		}

		elgg_push_breadcrumb(elgg_echo('tratamiento:plantilla:add'));
		$body_vars = tratamiento_plantilla_prepare_form_vars($tratamiento);
		$title = elgg_echo('tratamiento:plantilla:add');
		$content = elgg_view_form('tratamientoPlantilla/save', $vars, $body_vars);
	}

	$return['title'] = $title;
	$return['content'] = $content;
	$return['sidebar'] = $sidebar;
	return $return;	
}

/**
 * Pull together tratamiento variables for the save form
 *
 * @param ElggTratamiento       $post
 * @param ElggAnnotation $revision
 * @return array
 */
function tratamiento_plantilla_prepare_form_vars($post = NULL, $revision = NULL) {

	// input names => defaults
	$values = array(
		'title' => NULL,
		'description' => NULL,
		'status' => 'published',
		'access_id' => ACCESS_DEFAULT,
		'scorm' => NULL,
		'audio' => NULL,
		'scormRegistrationID' => NULL, // Si hay Scorm, necesitamos guardar la ID del registro paciente-curso, cosas de la API de Rustici.
		'oculto' => 'no',
		'categorias' => array(),
		'guid' => NULL,
		'profesional' => elgg_get_logged_in_user_guid(),
		'draft_warning' => '',
	);

	if ($post) {
		foreach (array_keys($values) as $field) {
			if (isset($post->$field)) {
				$values[$field] = $post->$field;
			}
		}
	}

	if (elgg_is_sticky_form('tratamientoPlantilla')) {
		$sticky_values = elgg_get_sticky_values('tratamientoPlantilla');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}
	
	elgg_clear_sticky_form('tratamientoPlantilla');

	if (!$post) {
		return $values;
	}

	// load the revision annotation if requested
	if ($revision instanceof ElggAnnotation && $revision->entity_guid == $post->getGUID()) {
		$values['revision'] = $revision;
		$values['description'] = $revision->value;
	}

	// display a notice if there's an autosaved annotation
	// and we're not editing it.
	if ($auto_save_annotations = $post->getAnnotations('tratamiento_auto_save', 1)) {
		$auto_save = $auto_save_annotations[0];
	} else {
		$auto_save == FALSE;
	}

	if ($auto_save && $auto_save->id != $revision->id) {
		$values['draft_warning'] = elgg_echo('tratamiento:messages:warning:draft');
	}

	return $values;
}

/**
 * Forward to the new style of URLs
 *
 * @param string $page
 */
function tratamiento_plantilla_url_forwarder($page) {
	global $CONFIG;

	// group usernames
	if (substr_count($page[0], 'group:')) {
		preg_match('/group\:([0-9]+)/i', $page[0], $matches);
		$guid = $matches[1];
		$entity = get_entity($guid);
		if ($entity) {
			$url = "{$CONFIG->wwwroot}tratamiento/group/$guid/all";
			register_error(elgg_echo("changebookmark"));
			forward($url);
		}
	}

	// user usernames
	$user = get_user_by_username($page[0]);
	if (!$user) {
		return;
	}

	if (!isset($page[1])) {
		$page[1] = 'owner';
	}

	switch ($page[1]) {
		case "read":
			$url = "{$CONFIG->wwwroot}tratamiento/view/{$page[2]}/{$page[3]}";
			break;
		case "archive":
			$url = "{$CONFIG->wwwroot}tratamiento/archive/{$page[0]}/{$page[2]}/{$page[3]}";
			break;
		case "friends":
			$url = "{$CONFIG->wwwroot}tratamiento/friends/{$page[0]}";
			break;
		case "new":
			$url = "{$CONFIG->wwwroot}tratamiento/add/$user->guid";
			break;
		case "owner":
			$url = "{$CONFIG->wwwroot}tratamiento/owner/{$page[0]}";
			break;
	}

	register_error(elgg_echo("changebookmark"));
	forward($url);
}
