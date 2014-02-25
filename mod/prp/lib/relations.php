<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// RELATION NAMES (tipos de relacion)

/**
 * Da de alta un nuevo tipo de relacion, indicando los parámetros de la misma
 * @param String $name Nombre de la relacion (codigo)
 * @param String $title Titulo de la relacion (descripcion)
 * @param array $config Configuracion de la relacion. Incluye:
 *      $config['subject_profiles'] ==> perfiles admitidos para el subject
 *      $config['object_profiles'] ==> perfiles admitidos para el object
 *      $config['allowed_profiles'] ==> perfiles que pueden establecer la relacion
 * @return bool True si crea el tipo de relacion, false en otro caso
 */
function prp_add_relation_name($name, $title, $config) {
    // creamos la relacion
    $relation_name = new ElggPRPRelationName();
    $relation_name->name = $name;
    $relation_name->title = $title;
    $relation_name->subject_profiles = $config['subject_profiles'];
    $relation_name->object_profiles = $config['object_profiles'];
    $relation_name->allowed_profiles = $config['allowed_profiles'];
    $relation_name->access_id = ACCESS_PUBLIC;
    $guid = $relation_name->save();
    if (!$guid) {
        return false;
    }
    return true;
}

/**
 * Actualiza el tipo de relacion, indicando los parámetros de la misma
 * @param String $name Nombre de la relacion (codigo)
 * @param String $title Titulo de la relacion (descripcion)
 * @param array $config Configuracion de la relacion. Incluye:
 *      $config['subject_profiles'] ==> perfiles admitidos para el subject
 *      $config['object_profiles'] ==> perfiles admitidos para el object
 *      $config['allowed_profiles'] ==> perfiles que pueden establecer la relacion
 * @return ElggPRPRelationName|NULL El tipo de relacion si ha ido OK, o NULL si hay algún error
 */
function prp_save_relation_name($name, $title, $config) {

    // recuperamos la relacion
    $relation_name = prp_get_relation_name($name);
    if ($relation_name === null) {
        return null;
    }
    // actualizamos las propiedades
    $relation_name->title = $title;
    $relation_name->subject_profiles = $config['subject_profiles'];
    $relation_name->object_profiles = $config['object_profiles'];
    $relation_name->allowed_profiles = $config['allowed_profiles'];
    $guid = $relation_name->save();
    if (!$guid) {
        return null;
    }
    // devolvemos la relacion
    return $relation_name;
}

/**
 * Recupera el tipo de relacion indicado, devuelve la entidad correspondiente
 * @param String $name 
 * @return ElggPRPRelationName|NULL El tipo de relacion, o NULL si no la encuentra
 */
function prp_get_relation_name($name) {
    // recuperamos las relaciones
    $relation_name_list = prp_get_relation_names();
    // identificamos la relacion buscada
    foreach ($relation_name_list as $relation_name) {
        if ($relation_name->title == $name) { //ponia ->name
            return $relation_name;
        }
    }
    // tipo de relacion no encontrada
    return NULL;
}

/**
 * Recupera los tipos de relaciones definidos en la plataforma, devolviendo las 
 * entidades correspondientes
 * @return array lista de ElggPRPRelationName
 */
function prp_get_relation_names() {
    // recuperamos las relaciones
    $options = array(
        'type' => 'object',
        'subtype' => ElggPRPRelationName::SUBTYPE,
    );
    return elgg_get_entities($options);
}

/**
 * Devuelve los tipos de relaciones definidos en la plataforma, codificadas como 
 * un fichero json para su exportacion
 * @return String fichero json con los datos
 */
function prp_get_relation_names_json() {
    // recuperamos las acciones
    $relation_names_list = prp_get_relation_names();
    $fields = array();

    /* @var $relation_name ElggPRPRelationName */
    foreach ($relation_names_list as $relation_name) {

        $fields[] = array(
            'name' => $relation_name->name,
            'title' => $relation_name->title,
            'subject_profiles' => $relation_name->subject_profiles,
            'object_profiles' => $relation_name->object_profiles,
            'allowed_profiles' => $relation_name->allowed_profiles,
        );
    }

    // añadimos informacion sobre los datos
    $info = array("fieldtype" => ElggPRPRelationName::SUBTYPE);
//	$md5 = md5(print_r($fields, true));
//	$info["md5"] = $md5;
    // generamos el json
    $json = json_encode(array(
        "info" => $info,
        "fields" => $fields
            ));

    return $json;
}

/**
 * Compone los tipos de relaciones de la plataforma a partir de un fichero 
 * codificado en formato json 
 * @param String $json datos de las relaciones
 * @return boolean True si carga los datos, false en otro caso
 */
function prp_init_relation_names_from_json($json) {

    // Decodificamos la informacion
    $json_array = json_decode($json);

    // comprobamos tipo de datos correctos
    $info = $json_array->info;
    if ($info === NULL) {
        // fichero no valido
        //TODO: register error
        register_error(elgg_echo('prp:error:bad_json'));
        return false;
    }

    // recuperamos el tipo de datos
    $fieldtype = $info->fieldtype;
    if ($fieldtype === NULL) {
        // fichero no valido
        register_error(elgg_echo('prp:error:bad_json'));
        return false;
    }

    // comprobamos tipo de datos
    if ((strcasecmp($fieldtype, ElggPRPRelationName::SUBTYPE) != 0)) {
        // tipo no valido, abandoamos
        // fichero no valido
        register_error(elgg_echo('prp:error:bad_json'));
        return false;
    }

    // a partir de aquí deberia ir bien...
    $fields = $json_array->fields;
    foreach ($fields as $field) {
        // comprobamos si existe ya la relacion, en cuyo caso la sobreescribimos        
        $relation_name = prp_get_relation_name($field->name);
        if ($relation_name === NULL) {
            $relation_name = new ElggPRPRelationName();
        }
        $relation_name->name = $field->name;
        $relation_name->title = $field->title;
        $relation_name->subject_profiles = $field->subject_profiles;
        $relation_name->object_profiles = $field->object_profiles;
        $relation_name->allowed_profiles = $field->allowed_profiles;
        $relation_name->save();
    }

    return true;
}

/**
 * Elimina un tipo de relacion
 * @param String $name tipo de relacion a eliminar
 * @return bool True si la elimina, o false si no la encuentra
 */
function prp_delete_relation_name($name) {
    // recuperamos la relacion
    $relation_name = prp_get_relation_name($name);
    if ($relation_name === null) {
        return FALSE;
    }
    //TODO: propagar el eliminar relaciones del tipo indicado, o dar un warning si existe alguna y no permitir la eliminacion
    // get_users
    // delete_all_relations_of_name
    // eliminamos el tipo de relacion
    $relation_name->delete();
    return true;
}

// RELATIONS (relaciones entre usuarios, basadas en ElggRelationShip)

/**
 * Recupera las relaciones de un usuario
 * @param ElggUser $user 
 * @return array relaciones definidas, en la forma de un nuevo array con 
 * claves 'relation_name' y 'related_user'
 */
function prp_get_user_relations($user) {
    // recuperamos las relaciones definidas
    $relation_names_list = prp_get_relation_names();

    $user_relations = array();
    // recuperamos las relaciones para cada tipo de relacion
    foreach ($relation_names_list as $relation_name) {
        $related_users = $user->getEntitiesFromRelationship($relation_name->name);
        if (!$related_users) {
            continue;
        } else {
            // acumulamos las relaciones
            foreach ($related_users as $related_user) {
                array_push($user_relations, array(
                    'relation_name' => $relation_name,
                    'related_user' => $related_user,
                ));
            }
        }
    }

    // devolvemos las relaciones
    return $user_relations;
}

/**
* Recupera los usuarios que tienen alguna relaciรณn con el usuario dado
* @param type $user Usuario del que queremos recuperar los usuarios relacionados
* @return Array con los usuarios que tienen relaciones
*/
function prp_get_related_users($user){
// recuperamos la relaciones
$user_relations = prp_get_user_relations($user);
// acumulamos los usuarios, comprobando duplicados
$related_users = array();
foreach ($user_relations as $user_relation){
    $related_user = $user_relation['related_user'];
    if (!in_array($related_user, $related_users)){
        array_push($related_users, $related_user);
    }
}
// devolvemos los usuarios relacionados
return $related_users;
} 


/**
 * Crea una relacion del tipo indicado entre dos usuairos
 * @param ElggUser $subject usuario al que se establece la relacion
 * @param ElggUser $object usuario con el que se establece la relacion
 * @param String $name tipo de relacion a establecer
 * @return bool True si crea la relacion, o falso si hay algun error
 */
function prp_add_relation($subject, $object, $name) {

    // recuperamos el tipo de relacion
    $relation_name = prp_get_relation_name($name);
    if ($relation_name === null) {
        // tipo de relacion no valido, abandonamos
        register_error(elgg_echo('prp:error:relation_name_not_valid'));
        return false;
    }

    // comprobamos perfiles para el subject
    if (array_count_values($relation_name->subject_profiles) > 0) {
        // recuperamos el perfil del subject
        $subject_user_profile = prp_get_user_profile_type($subject);
        // comprobamos que está en la lista
        if (!in_array($subject_user_profile, $relation_name->subject_profiles)) {
            // perfil no permitido, abandonamos
            register_error(elgg_echo('prp:error:user_profile_not_valid'));
            return false;
        }
    }

    // comprobamos perfiles para el object
    if (array_count_values($relation_name->object_profiles) > 0) {
        // recuperamos el perfil del object
        $object_user_profile = prp_get_user_profile_type($object);
        // comprobamos que está en la lista
        if (!in_array($object_user_profile, $relation_name->object_profiles)) {
            // perfil no permitido, abandonamos
            register_error(elgg_echo('prp:error:user_profile_not_valid'));
            return false;
        }
    }

    // comprobamos perfiles para establecer la relacion
    if (array_count_values($relation_name->allowed_profiles) > 0) {
        if (!elgg_is_admin_logged_in()) {
            // recuperamos el perfil del usuario logado
            $logged_user = elgg_get_logged_in_user_entity();
            $logged_user_profile = prp_get_user_profile_type($logged_user->guid);
            // comprobamos que está en la lista
            if (!in_array($logged_user_profile, $relation_name->allowed_profiles)) {
                // perfil no permitido, abandonamos
                register_error(elgg_echo('prp:error:user_profile_not_valid'));
                return false;
            }
        }
    }

    // en este punto se verifican todas las condiciones para establecer la relacion
    // establecemos la relacion, y devolvemos el resultado
    return $subject->addRelationship($object->guid, $name);
}

/**
 * Elimina la relacion del tipo indicado entre dos usuarios
 * @param ElggUser $subject Usuario que tiene establecida la relacion
 * @param ElggUser $object Usuario con el que se tiene establecida la relacion
 * @param String $name Tipo de relacion
 * @return bool True si elimina la relacion, o falso si hay algun error
 */
function prp_delete_relation($subject, $object, $name) {
    // recuperamos el tipo de relacion
    $relation_name = prp_get_relation_name($name);
    if ($relation_name === null) {
        // tipo de relacion no valido, abandonamos
        register_error(elgg_echo('prp:error:relation_name_not_valid'));
        return false;
    }

    // comprobamos perfiles para establecer la relacion
    if (array_count_values($relation_name->allowed_profiles) > 0) {
        if (!elgg_is_admin_logged_in()) {
            // recuperamos el perfil del usuario logado
            $logged_user = elgg_get_logged_in_user_entity();
            $logged_user_profile = prp_get_user_profile_type($logged_user->guid);
            // comprobamos que está en la lista
            if (!in_array($logged_user_profile, $relation_name->allowed_profiles)) {
                // perfil no permitido, abandonamos
                register_error(elgg_echo('prp:error:user_profile_not_valid'));
                return false;
            }
        }
    }

    // si se cumplen los permisos, eliminamos la relacion y devolvemos el resultado
    return $subject->removeRelationship($object->guid, $name);
}

/**
 * Elimina todas las relaciones que tiene establecidas el usuario con otros usuarios
 * NOTA: Esta funcion solo permitida para el administrador
 * @param ElggUser $subject Usuario que tiene establecidas las relaciones
 * @return bool True si elimina las relaciones, o falso si hay algun error (permisos)
 */
function prp_delete_all_relations($subject) {
    // comprobamos el usuario administrador
    if (!elgg_is_admin_logged_in()) {
        // no es administrador, abandonamos
        register_error(elgg_echo('prp:error:admin_required'));
        return false;
    }

    // recuperamos los tipos de relacion definidos
    $relation_name_list = prp_get_relation_names();
    // recorremos las relaciones definidas
    foreach ($relation_name_list as $relation_name) {
        // recuperamos las relaciones
        $related_user_list = $subject->getEntitiesFromRelationship($relation_name->name);

        // eliminamos las relaciones que existieran del tipo dado
        foreach ($related_user_list as $related_user) {
            if (!($subject->removeRelationship($related_user->guid, $relation_name->name))) {
                // TODO: hacemos algo en caso de erro? de momento no hacemos nada
            }
        }
    }

    // devolvemos resultado OK
    return true;
}

/**
 * Elimina todas las relaciones del tipo indicado que tiene establecidas el 
 * usuario con otros usuarios
 * @param ElggUser $subject Usuario que tiene establecidas las relaciones
 * @param String $name Tipo de relacion
 * @return bool True si elimina las relaciones, o falso si hay algun error
 */
function prp_delete_all_relations_of_name($subject, $name) {

    // recuperamos el tipo de relacion
    $relation_name = prp_get_relation_name($name);
    if ($relation_name === null) {
        // tipo de relacion no valido, abandonamos
        register_error(elgg_echo('prp:error:relation_name_not_valid'));
        return false;
    }

    // comprobamos perfiles para establecer la relacion
    if (array_count_values($relation_name->allowed_profiles) > 0) {
        if (!elgg_is_admin_logged_in()) {
            // recuperamos el perfil del usuario logado
            $logged_user = elgg_get_logged_in_user_entity();
            $logged_user_profile = prp_get_user_profile_type($logged_user->guid);
            // comprobamos que está en la lista
            if (!in_array($logged_user_profile, $relation_name->allowed_profiles)) {
                // perfil no permitido, abandonamos
                register_error(elgg_echo('prp:error:user_profile_not_valid'));
                return false;
            }
        }
    }

    // recuperamos las relaciones
    $related_user_list = $subject->getEntitiesFromRelationship($name);

    // eliminamos las relaciones
    foreach ($related_user_list as $related_user) {
        if (!($subject->removeRelationship($related_user->guid, $name))) {
            // TODO: notificamos error y abandonamos
            return false;
        }
    }

    // todo ha ido bien, devolvemos OK
    return true;
}

