<?php

/**
 * Recupera el tipo de perfil del usuario indicadoperfil 
 * @param ElggUser $user usuario a comprobar
 * @return string identificador del perfil (name)
 */
function prp_get_user_profile_type($user){
    // identificamos el perfil
    $user_metadata = profile_manager_get_user_profile_data($user);
    $custom_profile_id = profile_manager_get_user_profile_data_value($user_metadata, "custom_profile_type");
    $custom_profile = get_entity($custom_profile_id);
    return $custom_profile->metadata_name;    
    
}

/**
 * Recupera las etiquetas correspondientes a los perfiles indicados
 * @param type $selected_profiles perfiles seleccionados
 * @return string texto correspondiente a los perfiles
 */
function prp_get_selected_profiles_labels($selected_profiles) {
    static $profile_labels = null;
    // declaramos esta variable como estática y la inicializamos a null para no 
    // repetir la misma llamada varias veces en la misma consulta
    if ($profile_labels === null) {
        // recuperamos la lista de custom_profiles para localizar los nombres de los perfiles
        $options = array(
            'type' => 'object',
            'subtype' => 'custom_profile_type',
        );
        $profile_list = elgg_get_entities($options);

        $profile_labels = array();
        foreach ($profile_list as $profile_type) {
            $name = $profile_type->metadata_name;
            $label = $profile_type->metadata_label;
            $profile_labels[$name] = $label;
        }
    }


    // comprobamos si es un array
    if (is_array($selected_profiles)) {
        $selected_profiles_labels = array();
        foreach ($selected_profiles as $selected_profile) {
            array_push($selected_profiles_labels, $profile_labels[$selected_profile]);
        }
        $selected_profiles_labels = join(', ', $selected_profiles_labels);
    } else {
        // asumimos es un unico perfil
        $selected_profiles_labels = $profile_labels[$selected_profiles];
    }

    return $selected_profiles_labels;
}

/**
 * Recupera las etiquetas correspondientes a las relaciones indicadas
 * @param type $selected_relations relaciones seleccionadas
 * @return string texto correspondiente a las relaciones
 */
function prp_get_selected_relations_labels($selected_relations) {
    static $relation_names_labels = null;
    // declaramos esta variable como estática y la inicializamos a null para no 
    // repetir la misma llamada varias veces en la misma consulta
    if ($relation_names_labels === null) {
        // recuperamos la lista de relaciones para localizar los nombres
        $relation_names_list = prp_get_relation_names();

        $relation_names_labels = array();
        foreach ($relation_names_list as $relation_name) {
            $name = $relation_name->name;
            $label = $relation_name->title;
            $relation_names_labels[$name] = $label;
        }
    }


    // comprobamos si es un array
    if (is_array($selected_relations)) {
        $selected_relation_names_labels = array();
        foreach ($selected_relations as $selected_relation) {
            array_push($selected_relation_names_labels, $relation_names_labels[$selected_relation]);
        }
        $selected_relation_names_labels = join(', ', $selected_relation_names_labels);
    } else {
        // asumimos es un unico perfil
        $selected_relation_names_labels = $relation_names_labels[$selected_relations];
    }

    return $selected_relation_names_labels;
}

?>
