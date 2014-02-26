<?php

//Cargar las librerías de este módulo inmediatamente si fuese necesario
elgg_load_library('procura:notifications');

//en caso de no indicarse nada, vemos las anotaciones del usuario logueado
$content_owner = elgg_get_logged_in_user_entity()->username;

if ((isset($page[0])) &&
    (get_user_by_username($page[0]) != false) &&
    ($page[0] != $content_owner) //Un usuario siempre puede ver su página
    ){
    // Saber si puede ver la página si tiene permisos según el PRP
    $module_name = "procura_notifications";
    $action_name = "get_user_annotations_list"; //queremos la lista de anotaciones de un usuario
    $vars = array ('user' => get_user_by_username($page[0])); //queremos la lista de anotaciones del usuario de la URL   
/*
 * 
FUNCIONA MALLLL cuando sólo tienes 1 restricción por relación en la configuración de acciones del PRP
 * 
(prp_check_module_action_permissions($module_name, $action_name, $vars) ? system_message ("La respuesta al chequeo de permisos es: true") : system_message("PROBLEMA cuando sólo tienes 1 restricción por relación"));
*/    
    if ((prp_check_module_action_permissions($module_name, $action_name, $vars)) || 
        (elgg_is_admin_logged_in())){//el administrador siempre puede ver todo
        $content_owner = $page[0];
    } else{
        system_message(elgg_echo("noaccess"));
        forward('notifications/');
    }
}else{
    if ($page[0] != $content_owner){ //En caso de no poder entrar a la pagina solicitada, siempre se vuelve a las notificaciones del usuario identificado
        forward('notifications/' . $content_owner);
    }
}

// Gestionar las migas de pan de las notificaciones, en funcion de los parámetros que se han enviado en la URL
procura_notifications_handle_breadcrum ($page);
//var_dump (elgg_get_breadcrumbs());


$file_dir = elgg_get_plugins_path() . 'procura_notifications/pages';
include $file_dir . "/list_notifications.php";

return true;

?>
