<?php
/**
 * Módulo de índice personalizado de Procur@
 */

elgg_register_event_handler('init', 'system', 'custom_index_init');

function custom_index_init() {
    
    //Registrar las librerías de este módulo
    elgg_register_library('elgg:custom_index', elgg_get_plugins_path() . 'custom_index/lib/custom_index.php');

    //Cargar las librerías de este módulo inmediatamente
    elgg_load_library('elgg:custom_index');
    
    // Extender los CSS del sistema con los estilos propios del módulo
    elgg_extend_view('css/elgg', 'custom_index/css');

    // Reemplazar la página índice por defecto
    elgg_register_plugin_hook_handler('index', 'system', 'custom_index');
    
    //manejar los eventos en la configuración por el administrador. Na, sólo el administrador puede entrar
    //elgg_register_event_handler('pagesetup', 'system', 'custom_index_pagesetup');
        
    // Registrar el JavaScript para el Custom Index de Procur@
    $custom_index_js = elgg_get_simplecache_url('js', 'custom_index');
    elgg_register_js('procura.custom_index', $custom_index_js);
    
    // registro de acciones de administración de opciones_de_menú para tipos de perfil
    $base_actions_dir = elgg_get_plugins_path() . 'custom_index/actions';
    elgg_register_action('custom_index/add_menu_item', "$base_actions_dir/add_menu_item.php");
    elgg_register_action('custom_index/remove_menu_item', "$base_actions_dir/remove_menu_item.php");
    
    // menu administracion
    elgg_register_admin_menu_item('configure', 'menu_items_control', 'appearance');
            //configure indica que estará en el apartado de Configuración, en lugar del de Admón.
            //appearance hará que la nueva opción aparezca en el desplegable "Apariencia"
            //menu_items_control hace que redirija a views/default/admin/menu_items_control.php
            //una tercera opción haría buscar una carpeta dentro de views/default/admin/
}

function custom_index($hook, $type, $return, $params) {
	if ($return == true) {
		// Si existe otra función previa que reemplaza la página índice
		return $return;
	}

	if (!include_once(dirname(__FILE__) . "/index.php")) {
		return false;
	}

	// Devuelve 'true' si se ha cargado la página principal de este módulo
	return true;
}
