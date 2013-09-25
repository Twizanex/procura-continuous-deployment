<?php

/*
 * Parte derecha de la cabecera: nombre de usuario, foto, botón salir
 */
?>

<div>
<?php    
$usuario = elgg_get_logged_in_user_entity();
if ($usuario){
    
    $url_usuario = $CONFIG->url."profile/".$usuario->username;
    $img_usuario = $usuario->getIconURL($size='medium');

    $vista_usuario = elgg_view('output/url',array(
     'href' => $url_usuario,
     'text' => "<img src=\"$img_usuario\" alt=\"$usuario->name\" title=\"Perfil de $usuario->name \" />",
     'is_trusted' => true,
 ));
    $vista_usuario = $usuario->name.$vista_usuario;

    echo $vista_usuario;
    
    echo elgg_view('output/url', array(
	'href' => 'action/logout',
        'class' => 'procura-button procura-button-salir',
        'text' => elgg_echo('logout'),
	'is_trusted' => true,
     ));
}
?>    
</div>
