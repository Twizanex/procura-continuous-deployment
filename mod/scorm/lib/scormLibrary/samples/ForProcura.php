<?php
require_once('../ScormEngineService.php');

write_log('Creating ScormEngineService');
$ScormService = new ScormEngineService(
	'http://cloud.scorm.com/EngineWebServices/',
	'WP01PYNGCT',
	'ogI2ePJbyy3BJULamg1BjaeElhgsLTm3HEhnLb2g',
	'');
write_log('ScormEngineService Created');

write_log('Creating CourseService');
$courseService = $ScormService->getCourseService();
write_log('CourseService Created');

write_log('Getting CourseList');
$allResults = $courseService->GetCourseList();
write_log('CourseList count = '.count($allResults));

foreach($allResults as $course)
{
	$prevUrl = $courseService->GetPreviewUrl($course->getCourseId(),"http://localhost/mod/tratamiento/start.php");
	echo '<a href="'.$prevUrl.'">Preview</a>';
	echo '</td></tr>';
}