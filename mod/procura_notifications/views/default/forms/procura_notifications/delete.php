<?php
$body_borrar = elgg_view ('input/submit', array ('value' => 'Eliminar'));
//$body_borrar .= elgg_view('input/hidden', array ('name' => 'user_id', 'value' => get_loggedin_userid()));
$body_borrar .= elgg_view('input/hidden', array ('name' => 'notification_id', 'value' => $vars['id_notificacion']));
echo $body_borrar;
?>
