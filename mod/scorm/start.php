<?php

include "lib/scormLibrary/ScormEngineService.php";

function scorm_init() {

}

elgg_register_event_handler('init', 'system', 'scorm_init');

/**
 * Init procura_common plugin.
 */
?>