<?php



$ordenacion = get_input('orden');//por 'nivel_asc', 'nivel_desc', 'fecha_asc' ó 'fecha_desc'

$ordenacion_fecha = "fecha_desc";//ordenación por defecto de la fecha, que es el parámetro por defecto.
$ordenacion_nivel = "nivel_desc";//ordenación por defecto del nivel

if (isset($ordenacion)){
    //parsear si es por 'fecha' o 'nivel', y cambiar ese a '_asc' o '_desc' según se requiera
    
    $valores_ordenacion = split('_', $ordenacion);
    $tipo_ordenacion = $valores_ordenacion[0];//nivel o fecha
    $valor_ordenacion = $valores_ordenacion[1];//ascendente (asc) o descendente(desc)
    
    $valor_ordenacion = ($valor_ordenacion == 'asc') ? 'desc' : 'asc';
    
    if ($tipo_ordenacion == 'nivel')
        $ordenacion_nivel = 'nivel_'.$valor_ordenacion;
    else
        $ordenacion_fecha = 'fecha_'.$valor_ordenacion;
    
    
} else{
    $ordenacion = $ordenacion_fecha;
    $ordenacion_fecha = "fecha_asc";
}



$lista_notificaciones = procura_notifications_get_notification_list($content_owner, $ordenacion);


//$body .= "Los usuarios a los que se notificará, son: ";
//$ids_usuarios_notificados = procura_notifications_get_destinations(elgg_get_logged_in_user_guid());
//$ids_usuarios_notificados = procura_notifications_get_destinations(get_user_by_username($content_owner)->guid);
//foreach ($ids_usuarios_notificados as $id_usuario_notificado){
//    $body .= "<br/>" . get_user($id_usuario_notificado)->username;
//}

//$body .= "<br/>El dueño de la pagina es: " . $content_owner;

elgg_set_page_owner_guid(get_user_by_username($content_owner)->guid);

//Con esta forma de mostrar la pagina, se pintan las migas de pan
$vista_lista_notificaciones = elgg_view("procura_notifications/notification_list", array ('notificaciones' => $lista_notificaciones, 'orden_fecha' => $ordenacion_fecha, 'orden_nivel' => $ordenacion_nivel));
$body .= elgg_view_layout('content', array('content' => $vista_lista_notificaciones, 'title' => elgg_echo('procura_notifications:list'), 'filter' => '', ));




echo elgg_view_page('', $body);

?>
