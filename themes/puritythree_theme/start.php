<?php
function puritythree_theme_init() {
	elgg_extend_view ('page/elements/head','puritythree_theme/meta');
	elgg_unregister_menu_item('topbar', 'elgg_logo');
}
elgg_register_event_handler('init', 'system', 'puritythree_theme_init');
?>