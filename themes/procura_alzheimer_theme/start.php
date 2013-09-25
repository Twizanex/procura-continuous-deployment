<?php
function procura_alzheimer_theme_init() {
	elgg_extend_view ('css/elgg', 'procura_alzheimer_theme/css');	
}
elgg_register_event_handler('init', 'system', 'procura_alzheimer_theme_init');
?>
