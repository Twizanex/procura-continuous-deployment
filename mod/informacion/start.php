<?php
/**
 * informacions
 *
 * @package informacion
 *
 * @todo
 * - Either drop support for "publish date" or duplicate more entity getter
 * functions to work with a non-standard time_created.
 * - Pingbacks
 * - Notifications
 * - River entry for posts saved as drafts and later published
 */

elgg_register_event_handler('init', 'system', 'informacion_init');

/**
 * Init informacion plugin.
 */
function informacion_init() {

	elgg_register_library('elgg:informacion', elgg_get_plugins_path() . 'informacion/lib/informacion.php');

	// add a site navigation item
	$item = new ElggMenuItem('informacion', elgg_echo('informacion:informacions'), 'informacion/all');
	elgg_register_menu_item('site', $item);

	elgg_register_event_handler('upgrade', 'upgrade', 'informacion_run_upgrades');

	// add to the main css
	elgg_extend_view('css/elgg', 'informacion/css');

	// register the informacion's JavaScript
	$informacion_js = elgg_get_simplecache_url('js', 'informacion/save_draft');
	elgg_register_simplecache_view('js/informacion/save_draft');
	elgg_register_js('elgg.informacion', $informacion_js);

	// routing of urls
	elgg_register_page_handler('informacion', 'informacion_page_handler');

	// override the default url to view a informacion object
	elgg_register_entity_url_handler('object', 'informacion', 'informacion_url_handler');

	// notifications
	register_notification_object('object', 'informacion', elgg_echo('informacion:newpost'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'informacion_notify_message');

	// add informacion link to
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'informacion_owner_block_menu');

	// pingbacks
	//elgg_register_event_handler('create', 'object', 'informacion_incoming_ping');
	//elgg_register_plugin_hook_handler('pingback:object:subtypes', 'object', 'informacion_pingback_subtypes');

	// Register for search.
	elgg_register_entity_type('object', 'informacion');

	// Add group option
	add_group_tool_option('informacion', elgg_echo('informacion:enableinformacion'), true);
	elgg_extend_view('groups/tool_latest', 'informacion/group_module');

	// add a informacion widget
	elgg_register_widget_type('informacion', elgg_echo('informacion'), elgg_echo('informacion:widget:description'), 'profile');

	// register actions
	$action_path = elgg_get_plugins_path() . 'informacion/actions/informacion';
	elgg_register_action('informacion/save', "$action_path/save.php");
	elgg_register_action('informacion/auto_save_revision', "$action_path/auto_save_revision.php");
	elgg_register_action('informacion/delete', "$action_path/delete.php");

	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'informacion_entity_menu_setup');

	// ecml
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'informacion_ecml_views_hook');
}

/**
 * Dispatches informacion pages.
 * URLs take the form of
 *  All informacions:       informacion/all
 *  User's informacions:    informacion/owner/<username>
 *  Friends' informacion:   informacion/friends/<username>
 *  User's archives: informacion/archives/<username>/<time_start>/<time_stop>
 *  informacion post:       informacion/view/<guid>/<title>
 *  New post:        informacion/add/<guid>
 *  Edit post:       informacion/edit/<guid>/<revision>
 *  Preview post:    informacion/preview/<guid>
 *  Group informacion:      informacion/group/<guid>/all
 *
 * Title is ignored
 *
 * @todo no archives for all informacions or friends
 *
 * @param array $page
 * @return bool
 */
function informacion_page_handler($page) {

	elgg_load_library('elgg:informacion');

	// @todo remove the forwarder in 1.9
	// forward to correct URL for informacion pages pre-1.7.5
	informacion_url_forwarder($page);

//	// push all informacions breadcrumb
//	elgg_push_breadcrumb(elgg_echo('informacion:informacions'), "informacion/all");

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			$user = get_user_by_username($page[1]);
			$params = informacion_get_page_content_list($user->guid);
			break;
		case 'friends':
			$user = get_user_by_username($page[1]);
			$params = informacion_get_page_content_friends($user->guid);
			break;
		case 'archive':
			$user = get_user_by_username($page[1]);
			$params = informacion_get_page_content_archive($user->guid, $page[2], $page[3]);
			break;
		case 'view':
		case 'read': // Elgg 1.7 compatibility
			$params = informacion_get_page_content_read($page[1]);
			break;
		case 'add':
			gatekeeper();
			if (getPerfil(elgg_get_logged_in_user_guid())==="Profesional") {
				$params = informacion_get_page_content_edit($page_type, $page[1]);
				break;
			}
			else {
				register_error('No puedes agregar informacion');
				forward('informacion','No puedes agregar informacion');
			}
		case 'edit':
			gatekeeper();
			$params = informacion_get_page_content_edit($page_type, $page[1], $page[2]);
			break;
		case 'group':
			if ($page[2] == 'all') {
				$params = informacion_get_page_content_list($page[1]);
			} else {
				$params = informacion_get_page_content_archive($page[1], $page[3], $page[4]);
			}
			break;
		case 'all':
			$params = informacion_get_page_content_list();
			break;
		default:
			return false;
	}

	if (isset($params['sidebar'])) {
		$params['sidebar'] .= elgg_view('informacion/sidebar', array('page' => $page_type));
	} else {
		$params['sidebar'] = elgg_view('informacion/sidebar', array('page' => $page_type));
	}

	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($params['title'], $body);
	return true;
}

/**
 * Format and return the URL for informacions.
 *
 * @param ElggObject $entity informacion object
 * @return string URL of informacion.
 */
function informacion_url_handler($entity) {
	if (!$entity->getOwnerEntity()) {
		// default to a standard view if no owner.
		return FALSE;
	}

	$friendly_title = elgg_get_friendly_title($entity->title);

	return "informacion/view/{$entity->guid}/$friendly_title";
}

/**
 * Add a menu item to an ownerblock
 */
function informacion_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "informacion/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('informacion', elgg_echo('informacion'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->informacion_enable != "no") {
			$url = "informacion/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('informacion', elgg_echo('informacion:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add particular informacion links/info to entity menu
 */
function informacion_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'informacion') {
		return $return;
	}

	if ($entity->canEdit() && $entity->status != 'published') {
		$status_text = elgg_echo("informacion:status:{$entity->status}");
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
 * Register informacions with ECML.
 */
function informacion_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['object/informacion'] = elgg_echo('informacion:informacions');

	return $return_value;
}

/**
 * Upgrade from 1.7 to 1.8.
 */
function informacion_run_upgrades($event, $type, $details) {
	$informacion_upgrade_version = elgg_get_plugin_setting('upgrade_version', 'informacions');

	if (!$informacion_upgrade_version) {
		 // When upgrading, check if the Elgginformacion class has been registered as this
		 // was added in Elgg 1.8
		if (!update_subtype('object', 'informacion', 'Elgginformacion')) {
			add_subtype('object', 'informacion', 'Elgginformacion');
		}

		elgg_set_plugin_setting('upgrade_version', 1, 'informacions');
	}
}
