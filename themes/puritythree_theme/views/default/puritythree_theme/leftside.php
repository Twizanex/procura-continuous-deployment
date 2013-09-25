<?php 
$frontleft=elgg_get_plugin_setting('frontleft','puritythree_theme');
if (!$frontleft) $frontleft = '<h2>You can edit this information in the admin section of this theme.</h2>';
echo $frontleft;
?>