<?php

/**
 * Módulo de Contactos de Procura: Opción de menú que nos liste los usuarios contectados
 */

elgg_register_library('elgg:procura_contactos_functions',elgg_get_plugins_path() . 'procura_contactos/lib/procura_contactos_functions.php');
elgg_load_library('elgg:procura_contactos_functions');
elgg_register_event_handler('init', 'system', 'contactos_init'); 
elgg_extend_view('css/elgg', 'procura_contactos/css');


function contactos_init() {
    // Inicialización del plugin
    procura_contactos_en_site_item();
    elgg_register_page_handler('procura_contactos', 'procura_contactos_page_handler');
    
    // Registrar acciones: En este caso, sólo añadir amigos
    $base_actions_dir = elgg_get_plugins_path() . 'procura_contactos/actions/procura_contactos';    
    elgg_register_action('procura_contactos/add', "$base_actions_dir/add.php"); //Añadir amigo
}

function procura_contactos_page_handler($page) {
    $base = elgg_get_plugins_path() . 'procura_contactos/pages/procura_contactos';
  
    if (!isset($page[0])){
        $page[0] = 'contactos';
    }
    
    if (!isset($page[1])) {
        $page[1] = elgg_get_logged_in_user_entity()->username;
    }
    
    switch ($page[0]) {
	case 'contactos':           
            include("$base/contactos.php");
            break;
        case 'otros':            
            include("$base/contactos.php");
            break;
        case 'detalle_contacto':
            include("$base/detalle_contacto.php");
            break;
    }
    return true;
}
