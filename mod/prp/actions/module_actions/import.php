<?php
/**
 * module_actions/import
 * Importa las acciones de modulo definidas en un fichero
 */

// recuperamos el fichero subido
$json_data = get_uploaded_file('module_actions_backup_json');
if ($json_data){
    // importamos los datos
    if (prp_init_module_actions_from_json($json_data)){
        system_message(elgg_echo('prp:actions:module_actions:import:ok'));
    } else {
        register_error(elgg_echo('prp:actions:module_actions:import:error'));
    }
} else {
    register_error(elgg_echo('prp:actions:module_actions:import:error'));
} 
