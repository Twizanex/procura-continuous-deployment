<?php

/**
 * Registra una acción de un módulo
 * @param String $module_name nombre del modulo (codigo) (ElggPlugin->id)
 * @param String $action_name nombre de la accion (codigo)
 * @param String $action_title titulo de la accion (descripcion)
 * @return bool True si la ha registrado, false en otro caso
 */
function prp_register_module_action($module_name, $action_name, $action_title) {

    // comprobamos el usuario es administrador
    if (!elgg_is_admin_logged_in()) {
        // no es administrador, abandonamos
        register_error(elgg_echo('prp:error:admin_required'));
        return false;
    }

    // comprobamos que el modulo (plugin) existe
    if (!elgg_get_plugin_from_id($module_name)) {
        // plugin no encontrado, devolvemos error
        register_error(elgg_echo('prp:error:module_not_found'));
        return false;
    }

    // creamos la accion con los campos proporcionados
    //$module_action = new ElggObject();
    $module_action = new ElggPRPModuleAction();
    $module_action->action_name = $action_name;
    $module_action->title = $action_title;
    $module_action->module_name = $module_name;
    // nivel de acceso
    $module_action->access_id = ACCESS_PUBLIC;
    // establecemos los valores predeterminados
    $module_action->requires_profile = false;
    $module_action->requires_relation = false;
    $module_action->requires_owner = false;
    $module_action->required_profiles = array();
    $module_action->required_relations = array();
    $guid = $module_action->save();
    if (!$guid) {
        return false;
    }
    return true;
}

/**
 * Desregistra una acción de un módulo
 * @param String $module_name nombre del modulo (codigo) (ElggPlugin->id)
 * @param String $action_name nombre de la accion (codigo)
 * @return bool True si la ha eliminado, false en otro caso
 */
function prp_unregister_module_action($module_name, $action_name) {

    // comprobamos el usuario es administrador
    if (!elgg_is_admin_logged_in()) {
        // no es administrador, abandonamos
        register_error(elgg_echo('prp:error:admin_required'));
        return false;
    }

    // comprobamos que el modulo (plugin) existe
    if (!elgg_get_plugin_from_id($module_name)) {
        // plugin no encontrado, devolvemos error
        register_error(elgg_echo('prp:error:module_not_found'));
        return false;
    }

    // localizamos la entidad
    $module_action = prp_get_module_action_entity($module_name, $action_name);
    if ($module_action === null) {
        // accion no encontrada
        return false;
    } else {
        return $module_action->delete();
    }
}

/**
 * establece los permisos de una accion de un módulo
 * @param String $module_name nombre del modulo (codigo) (ElggPlugin->id)
 * @param String $action_name nombre de la accion (codigo)
 * @param Array $permissions configuracion de permisos:
 *  - bool $permissions['requires_profile']
 *  - bool $permissions['requires_relation']
 *  - bool $permissions['requires_owner']
 *  - array $permissions['required_profiles']
 *  - array $permissions['required_relations']
 * @return bool True si se actualizan los permisos, false en otro caso
 */
function prp_save_module_action($module_name, $action_name, $permissions) {

    // localizamos la accion
    $module_action = prp_get_module_action_entity($module_name, $action_name);
    if ($module_action === null) {
        // accion no encontrada
        return false;
    } else {
        // establecemos los permisos
        $module_action->requires_profile = $permissions['requires_profile'];
        $module_action->requires_relation = $permissions['requires_relation'];
        $module_action->requires_owner = $permissions['requires_owner'];
        $module_action->required_profiles = $permissions['required_profiles'];
        $module_action->required_relations = $permissions['required_relations'];

        $module_action = $module_action->save();
        return true;
    }
}

/**
 * Comprueba los permisos de una accion de un módulo
 * @param String $module_name identificador del modulo
 * @param String $action_name identificador de la accion
 * @param Array $vars elementos de configuracion de la accion:
 * - $vars['object'] ==> objeto sobre el que se aplica la accion (para el caso de que se requiera propiedad)
 * - $vars['user'] ==> usuario sobre el que se aplica la accion (para el caso de que se requiera relacion)
 * @return bool True si se verifican los permisos, false en otro caso
 */
function prp_check_module_action_permissions($module_name, $action_name, $vars) {

    // localizamos la accion
    $module_action = prp_get_module_action_entity($action_name, $module_name);
    if ($module_action === null) {
        // accion no encontrada, no se verifican los permisos
        return false;
    }

    // comprobamos perfil del usuario que ejecuta la accion
    if (!prp_check_module_action_profile_permission($module_action)) {
        // si no se cumple el permiso, devolvemos ya que no hay permiso
        return false;
    }

    // comprobamos si el usuario tiene una relacion requerida con el usuario sobre el que se aplica la accion
    if (!prp_check_module_action_relation_permissions($module_action, $vars['user'])) {
        // si no se cumple el permiso, devolvemos ya que no hay permiso
        return false;
    }

    // comprobamos si el usuario es el propietario del objeto sobre el que se aplica la accion
    if (!prp_check_module_action_ownership_permissions($module_action, $vars['object'])) {
        // si no se cumple el permiso, devolvemos ya que no hay permiso
        return false;
    }


    // Se verifican todos los permisos ==> permiso ok
    return true;
}

/**
 * Comprueba si el usuario tiene el perfil requerido para ejecutar la acción de 
 * módulo
 * @param ElggPRPModuleAction $module_action accion de modulo
 * @return bool True si se verifican los permisos, false en otro caso
 */
function prp_check_module_action_profile_permission($module_action) {

    if ($module_action === null) {
        // accion no indicada, no se verifican los permisos
        return false;
    }

    // recuperamos el usuario que está ejecutando la acción
    $user_executing_action = elgg_get_logged_in_user_entity();
    // de momento no abandonamos si no hay usuario, a lo mejor alguna accion no requiere usuario, solo que este registrada
    // comprobamos perfil del que ejecuta la accion
    if ($module_action->requires_profile) {
        if ($user_executing_action === NULL) {
            // usuario no logado ==> no permiso
            return false;
        }
        $user_profile = prp_get_user_profile_type($user_executing_action);
        if (!in_array($user_profile, $module_action->required_profiles)) {
            // perfil no admitido ==> no permiso
            return false;
        }
    }

    // hasta aqui todo bien ==> permiso ok
    return true;
}

/**
 * Comprueba si el usuario tiene una relacion requedida para ejecutar la accion 
 * de modulo
 * @param ElggPRPModuleAction $module_action Accion de modulo
 * @param ElggUser $related_user Usuario sobre el que se quiere comprobar la relacion
 * @return bool True si se verifican los permisos, false en otro caso
 */
function prp_check_module_action_relation_permissions($module_action, $related_user) {

    if ($module_action === null) {
        // accion no indicada, no se verifican los permisos
        return false;
    }

    // recuperamos el usuario que está ejecutando la acción
    $user_executing_action = elgg_get_logged_in_user_entity();
    // de momento no abandonamos si no hay usuario, a lo mejor alguna accion no requiere usuario, solo que este registrada
    // comprobamos relacion con el usuario:
    if ($module_action->requires_relation) {
        if ($user_executing_action === NULL) {
            // usuario no logado ==> no permiso
            return false;
        }
        // comprobamos usuario
        // recuperamos el usuario
        if ($related_user === NULL) {
            // no se ha pasado el usuario, devolvemos no permitido
            return false;
        }
        // comprobamos relaciones
        $match_profile = false;
        foreach ($module_action->required_relations as $relation_name) {
            // comprobamos si existe la relacion
            $relation = check_entity_relationship($user_executing_action->guid, $relation_name, $related_user->guid);
            if (is_a($relation, 'ElggRelationship')) {
                // relacion encontrada, marcamos y abandonamos el bucle
                $match_profile = true;
                break;
            }
        }
        // comprobamos si se cumplen permisos
        if (!$match_profile) {
            // perfil no encontrado ==> no permiso
            return false;
        }
    }

    // hasta aqui todo bien ==> permiso ok
    return true;
}

/**
 * Comprueba si el usuario tiene la propiedad del objeto para ejecutar la accion
 * de modulo
 * @param ElggPRPModuleAction $module_action Accion de modulo
 * @param ElggObject $related_object Objeto sobre el que se quiere comprobar la propiedad
 * @return bool True si se verifican los permisos, false en otro caso
 */
function prp_check_module_action_ownership_permissions($module_action, $related_object) {

    if ($module_action === null) {
        // accion no indicada, no se verifican los permisos
        return false;
    }

    // recuperams el usuario que está ejecutando la acción
    $user_executing_action = elgg_get_logged_in_user_entity();
    // de momento no abandonamos si no hay usuario, a lo mejor alguna accion no requiere usuario, solo que este registrada
    // comprobamos usuario es propietario del objeto
    if ($module_action->requires_owner) {
        if ($user_executing_action === NULL) {
            // usuario no logado ==> no permiso
            return false;
        }

        // comprobamos el objeto
        if ($related_object === NULL) {
            // no se ha pasado el objeto, devolvemos no permitido
            return false;
        }

        // comprobamos propietario
        if ($related_object->owner_guid != $user_executing_action->guid) {
            return false;
        }
    }

    // hasta aqui todo bien ==> permiso ok
    return true;
}

/**
 * Localiza la entidad correspondiente a la accion de modulo indicada
 * @param String $module_name identificador del modulo
 * @param String $action_name identificador de la accion
 * @return ElggPRPModuleAction|Null Accion o null si no la encuentra/existe
 */
function prp_get_module_action_entity($module_name, $action_name) {

    // localizamos las entidades
    $module_action_list = prp_get_module_actions();
    foreach ($module_action_list as $module_action) {
        if (($module_action->module_name == $module_name) && ($module_action->action_name == $action_name)) {
            return $module_action;
        }
    }
    // accion no encontrada
    return null;
}

/**
 * Localiza las acciones registradas para el modulo indicado
 * @param String $module_name identificador del modulo
 * @return array lista de ElggPRPModuleAction
 */
function prp_get_module_actions_from_module($module_name) {

    // localizamos las entidades
    $module_action_list = prp_get_module_actions();
    $selected_module_action_list = array();
    foreach ($module_action_list as $module_action) {
        if ($module_action->module_name == $module_name) {
            array_push($selected_module_action_list, $module_action);
        }
    }
    // devolvemos las acciones
    return $selected_module_action_list;
}

/**
 * Recupera las acciones de modulos definidas en la plataforma, devolviendo las 
 * entidades correspondientes
 * @return array lista de ElggPRPModuleAction
 */
function prp_get_module_actions() {
    // recuperamos la relacion
    $options = array(
        'type' => 'object',
        'subtype' => ElggPRPModuleAction::SUBTYPE,
    );
    return elgg_get_entities($options);
}

/**
 * Devuelve las acciones de modulos configuradas en la plataforma, codificadas 
 * como un fichero json para su exportacion
 * @return String fichero json con los datos
 */
function prp_get_module_actions_json() {

    // recuperamos las acciones
    $module_action_list = prp_get_module_actions();
    $fields = array();

    /* @var $module_action ElggPRPModuleAction */
    foreach ($module_action_list as $module_action) {

        $fields[] = array(
            'module_name' => $module_action->module_name,
            'action_name' => $module_action->action_name,
            'title' => $module_action->title,
            'requires_profile' => $module_action->requires_profile,
            'required_profiles' => $module_action->required_profiles,
            'requires_relation' => $module_action->requires_relation,
            'required_relations' => $module_action->required_relations,
            'requires_owner' => $module_action->requires_owner,
        );
    }

    // añadimos informacion sobre los datos
    $info = array("fieldtype" => ElggPRPModuleAction::SUBTYPE);
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
 * Compone las acciones de modulo definidas en la plataforma a partir de un fichero 
 * codificado en formato json 
 * @param String $json datos de las acciones de modulo
 * @return boolean True si carga los datos, false en otro caso
 */
function prp_init_module_actions_from_json($json) {

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
    if ((strcasecmp($fieldtype, ElggPRPModuleAction::SUBTYPE) != 0)) {
        // tipo no valido, abandoamos
        // fichero no valido
        register_error(elgg_echo('prp:error:bad_json'));
        return false;
    }

    // a partir de aquí deberia ir bien...
    $fields = $json_array->fields;
    foreach ($fields as $field) {
        // comprobamos primero si existe la accion de modulo, que debería existir si el modulo esta registrado...
        $module_action = prp_get_module_action_entity($field->module_name, $field->action_name);
        // si no existe, la omitimos
        if ($module_action === NULL) {
            continue;
        }
        $module_action->requires_profile = $field->requires_profile;
        $module_action->required_profiles = $field->required_profiles;
        $module_action->requires_relation = $field->requires_relation;
        $module_action->required_relations = $field->required_relations;
        $module_action->requires_owner = $field->requires_requires_profile;
        $module_action->save();
    }

    return true;
}