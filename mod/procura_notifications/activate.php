<?php

    /* No hace falta el GUID del modulo, que se obtendría así:
    $plugins = elgg_get_plugins();
    foreach ($plugins as $plugin) {if ($plugin->title == $module_name){$module_id = $plugin->guid;}}*/
    
    /*
     *  Control de acceso a la lista de anotaciones de un usuario:
     * ------------------------------------------------------------
     */ 
    $module_name = "procura_notifications";
    $action_name = "get_user_annotations_list";
    $action_description = elgg_echo("procura_notifications:prp_annotations_control");
    prp_register_module_action($module_name, $action_name, $action_description);

    /* 
    *  ¿Borrar una notificacion? <- ¿tiene sentido este permiso? ¡¡¿Existe acaso esta acción?!!
    * --------------------------------
    $module_name = "procura_notifications";
    $action_name = "¿?";
    $vars = array ('user' => $page[0]);
    * prp_register_module_action($module_name, $action_name, $action_title);
    */
    
?>
