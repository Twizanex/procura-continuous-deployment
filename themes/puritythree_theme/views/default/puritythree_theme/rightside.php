<?php
$frontright=elgg_get_plugin_setting('frontright','puritythree_theme');
if (!$frontright) $frontright = '<h2>You can edit this information in the admin section of this theme.</h2>';
echo $frontright; 
?>