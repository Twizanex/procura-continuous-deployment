<?php

/**
 * Describe plugin here
 */
elgg_register_event_handler('init', 'system', 'prp_init');

function prp_init() {

    // registramos el menu
    $item = new ElggMenuItem('prp', 'PRP', 'prp/index');
    elgg_register_menu_item('site', $item);
    
    // menu administracion
    elgg_register_admin_menu_item('configure', 'module_actions', 'prp');
    elgg_register_admin_menu_item('configure', 'relation_names', 'prp');
    //elgg_register_admin_menu_item('configure', 'user_summary_control', 'appearance');
    
    // registro de acciones
    // Register a script to handle (usually) a POST request (an action)
    $base_actions_dir = elgg_get_plugins_path() . 'prp/actions';
    
    elgg_register_action('prp/relations/add', "$base_actions_dir/relations/add.php");
    elgg_register_action('prp/relations/delete', "$base_actions_dir/relations/delete.php");
    elgg_register_action('prp/relations/delete_all', "$base_actions_dir/relations/delete_all.php");
    elgg_register_action('prp/relations/names/save', "$base_actions_dir/relations/names/save.php");
    elgg_register_action('prp/relations/names/delete', "$base_actions_dir/relations/names/delete.php");
    elgg_register_action('prp/relations/names/import', "$base_actions_dir/relations/names/import.php");
    elgg_register_action('prp/relations/names/export', "$base_actions_dir/relations/names/export.php");

    elgg_register_action('prp/module_actions/add', "$base_actions_dir/module_actions/add.php");
    elgg_register_action('prp/module_actions/delete', "$base_actions_dir/module_actions/delete.php");
    elgg_register_action('prp/module_actions/save', "$base_actions_dir/module_actions/save.php");
    elgg_register_action('prp/module_actions/import', "$base_actions_dir/module_actions/import.php");
    elgg_register_action('prp/module_actions/export', "$base_actions_dir/module_actions/export.php");
    

    elgg_register_action('prp/profile_permissions/save', "$base_actions_dir/profile_permissions/save.php");
    elgg_register_action('prp/profile_permissions/delete', "$base_actions_dir/profile_permissions/delete.php");
    elgg_register_action('prp/profile_permissions/delete_all', "$base_actions_dir/profile_permissions/delete_all.php");
    elgg_register_action('prp/profile_permissions/import', "$base_actions_dir/profile_permissions/import.php");
    elgg_register_action('prp/profile_permissions/export', "$base_actions_dir/profile_permissions/export.php");
    
    // registro java script
    $prp_js_relations = elgg_get_simplecache_url('js', 'relations');
    elgg_register_js('prp.relations', $prp_js_relations);
    elgg_load_js('prp.relations');
    $prp_js_module_actions = elgg_get_simplecache_url('js', 'module_actions');
    elgg_register_js('prp.module_actions', $prp_js_module_actions);
    elgg_load_js('prp.module_actions');
    $prp_js_site = elgg_get_simplecache_url('js', 'site');
    elgg_register_js('prp.site', $prp_js_site);
    elgg_load_js('prp.site');

    // Register Page handler
    elgg_register_page_handler("prp", "prp_page_handler");

    elgg_register_library('prp_commons', elgg_get_plugins_path() . 'prp/lib/commons.php');
    elgg_register_library('prp_relations', elgg_get_plugins_path() . 'prp/lib/relations.php');
    elgg_register_library('prp_module_actions', elgg_get_plugins_path() . 'prp/lib/module_actions.php');
    elgg_register_library('prp_profile_permissions', elgg_get_plugins_path() . 'prp/lib/profile_permissions.php');
    elgg_load_library('prp_commons');
    elgg_load_library('prp_relations');
    elgg_load_library('prp_module_actions');
    elgg_load_library('prp_profile_permissions');
    


    
}

/**
 * Manejador de pagina
 * @param type $page 
 */
function prp_page_handler($page) {

    $pages_dir = elgg_get_plugins_path() . 'prp/pages/prp';
    // this is a url like http://example.org/prp...
    if (count($page) == 0) {
        $page[0] = 'index';
    }
    switch ($page[0]) {
        //prp/admin
        case 'admin':
            require "$pages_dir/admin/$page[1].php";
            break;
        //prp/forms
        case 'forms':
            require "$pages_dir/forms/$page[1].php";
            break;
        //prp/test
        case 'test':
            require "$pages_dir/test/$page[1].php";
            break;
        // index page or unknown requests
        case 'index':
        default:
            require "$pages_dir/index.php";
            break;
    }
    return true;
}