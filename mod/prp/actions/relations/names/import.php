<?php

/**
 * relations/names/import
 * Importa los tipos de relacion definidos en un fichero
 */
// recuperamos el fichero subido
$json_data = get_uploaded_file('relation_names_backup_json');
if ($json_data) {
    // importamos los datos
    if (prp_init_relation_names_from_json($json_data)) {
        system_message(elgg_echo('prp:actions:relations:names:import:ok'));
    } else {
        register_error(elgg_echo('prp:actions:relations:names:import:error'));
    }
} else {
    register_error(elgg_echo('prp:actions:relations:names:import:error'));
}

