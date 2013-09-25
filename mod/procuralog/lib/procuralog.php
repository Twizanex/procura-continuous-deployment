<?php

function logProcura($eventType) {
	
$procuralog = new ElggProcuraLog();
//$procuralog->subtype = 'procuralog';
//$procuralog->$userGUID = elgg_get_logged_in_user_guid();
//$procuralog->$timestamp = time();
//$procuralog->$eventType = $eventType;

// set defaults and required values.
$values = array(
	'userGUID' => elgg_get_logged_in_user_guid(),
	'timestamp' => time(),
	'eventType' => $eventType,
);

// assign values to the entity, stopping on error.
foreach ($values as $name => $value) {
	if (FALSE === ($procuralog->$name = $value)) {
		$error = elgg_echo('$procuralog:error:cannot_save' . "$name=$value");
		break;
	}
}


//var_dump($procuralog);
if ($procuralog->save()) {
//	$test = get_entity($procuralog->guid);
//	var_dump($test);
}
else var_dump("No puedo guardar procuralog!!");

}