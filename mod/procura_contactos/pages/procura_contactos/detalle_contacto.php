<?php
// detalle_contacto viene de foto_usuario.
/*
 * Muestra la "ficha" del contacto seleccionado: Su imagen y las opciones disponibles
 */
?>
<?php

// Si no nos viene dado usuario, cogemos el actuamente logueado
if (!isset($page[1])){
    $usuario = elgg_get_logged_in_user_entity()->username;    
}else{
    $usuario = get_user_by_username($page[1]);
}

$user = elgg_get_logged_in_user_entity();

$opciones = contactos_menu($usuario); 
pr_contactos_handle_breadcrum($page);

$vars = array('menu_contactos'=>$opciones,'usuario'=>$usuario);
$content_modulo = elgg_view('object/menu_contactos',$vars);
$content = "<div class='elgg-col elgg-col-1of1'>";
//$content=$content.elgg_view_module('featured',elgg_echo('contactos:detalle').': '.$usuario->username,$content_modulo,$vars);
$content=$content.elgg_view_module('','',$content_modulo,$vars);
$content=$content."</div>";

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => elgg_echo('contactos:detalle'),
	'filter' => '',
));

echo elgg_view_page($title, $body);

?>