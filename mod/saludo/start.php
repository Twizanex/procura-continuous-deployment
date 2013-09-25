<?php
/**
 * Elgg saludo plugin
 *
 * @package ElggFile
 */

elgg_register_event_handler('init', 'system', 'saludo_init');

/**
 * File plugin initialization functions.
 */
function saludo_init() {

	// register a library of helper functions
	elgg_register_library('elgg:saludo', elgg_get_plugins_path() . 'saludo/lib/saludo.php');

	// Site navigation
	$item = new ElggMenuItem('saludo', elgg_echo('saludo'), 'saludo/all');
	elgg_register_menu_item('site', $item);

	// Extend CSS
	elgg_extend_view('css/elgg', 'saludo/css');

	// add enclosure to rss item
	elgg_extend_view('extensions/item', 'saludo/enclosure');

	// extend group main page
	elgg_extend_view('groups/tool_latest', 'saludo/group_module');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('saludo', 'saludo_page_handler');

	// Add a new saludo widget
	elgg_register_widget_type('saludorepo', elgg_echo("saludo"), elgg_echo("saludo:widget:description"));

	// Register URL handlers for saludos
	elgg_register_entity_url_handler('object', 'saludo', 'saludo_url_override');
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'saludo_icon_url_override');

	// Register granular notification for this object type
	register_notification_object('object', 'saludo', elgg_echo('saludo:newupload'));

	// Listen to notification events and supply a more useful message
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'saludo_notify_message');

	// add the group saludos tool option
	add_group_tool_option('saludo', elgg_echo('groups:enablesaludos'), true);

	// Register entity type for search
	elgg_register_entity_type('object', 'saludo');

	// add a saludo link to owner blocks
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'saludo_owner_block_menu');

	// Register actions
	$action_path = elgg_get_plugins_path() . 'saludo/actions/saludo';
	elgg_register_action("saludo/upload", "$action_path/upload.php");
	elgg_register_action("saludo/delete", "$action_path/delete.php");
	// temporary - see #2010
	elgg_register_action("saludo/download", "$action_path/download.php");

	// embed support
	$item = ElggMenuItem::factory(array(
		'name' => 'saludo',
		'text' => elgg_echo('saludo'),
		'priority' => 10,
		'data' => array(
			'options' => array(
				'type' => 'object',
				'subtype' => 'saludo',
			),
		),
	));
	elgg_register_menu_item('embed', $item);

	$item = ElggMenuItem::factory(array(
		'name' => 'saludo_upload',
		'text' => elgg_echo('saludo:upload'),
		'priority' => 100,
		'data' => array(
			'view' => 'embed/saludo_upload/content',
		),
	));

	elgg_register_menu_item('embed', $item);
}

/**
 * Dispatches saludo pages.
 * URLs take the form of
 *  All saludos:       saludo/all
 *  User's saludos:    saludo/owner/<username>
 *  Friends' saludos:  saludo/friends/<username>
 *  View saludo:       saludo/view/<guid>/<title>
 *  New saludo:        saludo/add/<guid>
 *  Edit saludo:       saludo/edit/<guid>
 *  Group saludos:     saludo/group/<guid>/all
 *  Download:        saludo/download/<guid>
 *
 * Title is ignored
 *
 * @param array $page
 * @return bool
 */
function saludo_page_handler($page) {

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$saludo_dir = elgg_get_plugins_path() . 'saludo/pages/saludo';

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			saludo_register_toggle();
			include "$saludo_dir/owner.php";
			break;
		case 'friends':
			saludo_register_toggle();
			include "$saludo_dir/friends.php";
			break;
		case 'view':
			set_input('guid', $page[1]);
			include "$saludo_dir/view.php";
			break;
		case 'add':
			include "$saludo_dir/upload.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$saludo_dir/edit.php";
			break;
		case 'search':
			saludo_register_toggle();
			include "$saludo_dir/search.php";
			break;
		case 'group':
			saludo_register_toggle();
			include "$saludo_dir/owner.php";
			break;
		case 'all':
			saludo_register_toggle();
			include "$saludo_dir/world.php";
			break;
		case 'download':
			set_input('guid', $page[1]);
			include "$saludo_dir/download.php";
			break;
		default:
			return false;
	}
	return true;
}

/**
 * Adds a toggle to extra menu for switching between list and gallery views
 */
function saludo_register_toggle() {
	$url = elgg_http_remove_url_query_element(current_page_url(), 'list_type');

	if (get_input('list_type', 'list') == 'list') {
		$list_type = "gallery";
		$icon = elgg_view_icon('grid');
	} else {
		$list_type = "list";
		$icon = elgg_view_icon('list');
	}

	if (substr_count($url, '?')) {
		$url .= "&list_type=" . $list_type;
	} else {
		$url .= "?list_type=" . $list_type;
	}


	elgg_register_menu_item('extras', array(
		'name' => 'saludo_list',
		'text' => $icon,
		'href' => $url,
		'title' => elgg_echo("saludo:list:$list_type"),
		'priority' => 1000,
	));
}

/**
 * Creates the notification message body
 *
 * @param string $hook
 * @param string $entity_type
 * @param string $returnvalue
 * @param array  $params
 */
function saludo_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'saludo')) {
		$descr = $entity->description;
		$title = $entity->title;
		$url = elgg_get_site_url() . "view/" . $entity->guid;
		$owner = $entity->getOwnerEntity();
		return $owner->name . ' ' . elgg_echo("saludo:via") . ': ' . $entity->title . "\n\n" . $descr . "\n\n" . $entity->getURL();
	}
	return null;
}

/**
 * Add a menu item to the user ownerblock
 */
function saludo_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "saludo/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('saludo', elgg_echo('saludo'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->saludo_enable != "no") {
			$url = "saludo/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('saludo', elgg_echo('saludo:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Returns an overall saludo type from the mimetype
 *
 * @param string $mimetype The MIME type
 * @return string The overall type
 */
function saludo_get_simple_type($mimetype) {

	switch ($mimetype) {
		case "application/msword":
			return "document";
			break;
		case "application/pdf":
			return "document";
			break;
	}

	if (substr_count($mimetype, 'text/')) {
		return "document";
	}

	if (substr_count($mimetype, 'audio/')) {
		return "audio";
	}

	if (substr_count($mimetype, 'image/')) {
		return "image";
	}

	if (substr_count($mimetype, 'video/')) {
		return "video";
	}

	if (substr_count($mimetype, 'opendocument')) {
		return "document";
	}

	return "general";
}

// deprecated and will be removed
function get_general_saludo_type($mimetype) {
	elgg_deprecated_notice('Use saludo_get_simple_type() instead of get_general_saludo_type()', 1.8);
	return saludo_get_simple_type($mimetype);
}

/**
 * Returns a list of saludotypes
 *
 * @param int       $container_guid The GUID of the container of the saludos
 * @param bool      $friends        Whether we're looking at the container or the container's friends
 * @return string The typecloud
 */
function saludo_get_type_cloud($container_guid = "", $friends = false) {

	$container_guids = $container_guid;

	if ($friends) {
		// tags interface does not support pulling tags on friends' content so
		// we need to grab all friends
		$friend_entities = get_user_friends($container_guid, "", 999999, 0);
		if ($friend_entities) {
			$friend_guids = array();
			foreach ($friend_entities as $friend) {
				$friend_guids[] = $friend->getGUID();
			}
		}
		$container_guids = $friend_guids;
	}

	elgg_register_tag_metadata_name('simpletype');
	$options = array(
		'type' => 'object',
		'subtype' => 'saludo',
		'container_guids' => $container_guids,
		'threshold' => 0,
		'limit' => 10,
		'tag_names' => array('simpletype')
	);
	$types = elgg_get_tags($options);

	$params = array(
		'friends' => $friends,
		'types' => $types,
	);

	return elgg_view('saludo/typecloud', $params);
}

function get_saludotype_cloud($owner_guid = "", $friends = false) {
	elgg_deprecated_notice('Use saludo_get_type_cloud instead of get_saludotype_cloud', 1.8);
	return saludo_get_type_cloud($owner_guid, $friends);
}

/**
 * Populates the ->getUrl() method for saludo objects
 *
 * @param ElggEntity $entity File entity
 * @return string File URL
 */
function saludo_url_override($entity) {
	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return "saludo/view/" . $entity->getGUID() . "/" . $title;
}

/**
 * Override the default entity icon for saludos
 *
 * Plugins can override or extend the icons using the plugin hook: 'saludo:icon:url', 'override'
 *
 * @return string Relative URL
 */
function saludo_icon_url_override($hook, $type, $returnvalue, $params) {
	$saludo = $params['entity'];
	$size = $params['size'];
	if (elgg_instanceof($saludo, 'object', 'saludo')) {

		// thumbnails get first priority
		if ($saludo->thumbnail) {
			$ts = (int)$saludo->icontime;
			return "mod/saludo/thumbnail.php?saludo_guid=$saludo->guid&size=$size&icontime=$ts";
		}

		$mapping = array(
			'application/excel' => 'excel',
			'application/msword' => 'word',
			'application/pdf' => 'pdf',
			'application/powerpoint' => 'ppt',
			'application/vnd.ms-excel' => 'excel',
			'application/vnd.ms-powerpoint' => 'ppt',
			'application/vnd.oasis.opendocument.text' => 'openoffice',
			'application/x-gzip' => 'archive',
			'application/x-rar-compressed' => 'archive',
			'application/x-stuffit' => 'archive',
			'application/zip' => 'archive',

			'text/directory' => 'vcard',
			'text/v-card' => 'vcard',

			'application' => 'application',
			'audio' => 'music',
			'text' => 'text',
			'video' => 'video',
		);

		$mime = $saludo->mimetype;
		if ($mime) {
			$base_type = substr($mime, 0, strpos($mime, '/'));
		} else {
			$mime = 'none';
			$base_type = 'none';
		}

		if (isset($mapping[$mime])) {
			$type = $mapping[$mime];
		} elseif (isset($mapping[$base_type])) {
			$type = $mapping[$base_type];
		} else {
			$type = 'general';
		}

		if ($size == 'large') {
			$ext = '_lrg';
		} else {
			$ext = '';
		}
		
		$url = "mod/saludo/graphics/icons/{$type}{$ext}.gif";
		$url = elgg_trigger_plugin_hook('saludo:icon:url', 'override', $params, $url);
		return $url;
	}
}