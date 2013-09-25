<?php

/**
 * Crea un conjunto de permisos para un campo (o campos) de perfil personalizados
 * @param type $name Nombre del permiso (codigo)
 * @param type $title Titulo del permiso (descripcion identificativa)
 * @param type $config Configuracion de los permisos
 * @return bool True si crea el permiso, false en otro caso
 */
function prp_add_profile_permission($name, $title, $config) {
    // comprobamos el usuario es administrador
    if (!elgg_is_admin_logged_in()) {
        // no es administrador, abandonamos
        register_error(elgg_echo('prp:error:admin_required'));
        return false;
    }

    // creamos la entidad con los campos proporcionados
    $field_profile_permission = new ElggObject();
    $field_profile_permission->subtype = 'prp_field_profile_permission';
    $field_profile_permission->name = $name;
    $field_profile_permission->title = $title;
    // nivel de acceso
    $field_profile_permission->access_id = ACCESS_PUBLIC;

    // establecemos los permisos, añadiendo los valores por defecto
    $permissions_array = prp_merge_with_default_field_profile_permissions($config);

    // guardamos permisos del campo
    $field_profile_permission->field_profiles = $permissions_array['field_profiles'];
    $field_profile_permission->hide_to_owner = $permissions_array['hide_to_owner'];
    $field_profile_permission->lock_to_owner = $permissions_array['lock_to_owner'];
    $field_profile_permission->public_field = $permissions_array['public_field'];
    $field_profile_permission->allowed_profiles = $permissions_array['allowed_profiles'];
    $field_profile_permission->required_relations = $permissions_array['required_relations'];

    $guid = $field_profile_permission->save();
    if (!$guid) {
        return false;
    }
    return true;
}

/**
 * Actualiza un conjunto de permisos para un campo (o campos) de perfil personalizados
 * @param type $name Nombre del permiso (codigo)
 * @param type $title Titulo del permiso (descripcion identificativa)
 * @param type $config Configuracion de los permisos
 * @return bool True si modifica el permiso, false en otro caso
 */
function prp_save_profile_permission($name, $title, $config) {
    // comprobamos el usuario es administrador
    if (!elgg_is_admin_logged_in()) {
        // no es administrador, abandonamos
        register_error(elgg_echo('prp:error:admin_required'));
        return false;
    }

    // recuperamos el conjunto de permisos
    $field_profile_permission = prp_get_profile_permission($name);
    if ($field_profile_permission === null) {
        // entidad no encontrada
        return false;
    }

    $field_profile_permission->title = $title;

    // establecemos los permisos, añadiendo los valores por defecto
    $permissions_array = prp_merge_with_default_field_profile_permissions($config);

    // guardamos permisos del campo
    $field_profile_permission->field_profiles = $permissions_array['field_profiles'];
    $field_profile_permission->hide_to_owner = $permissions_array['hide_to_owner'];
    $field_profile_permission->lock_to_owner = $permissions_array['lock_to_owner'];
    $field_profile_permission->public_field = $permissions_array['public_field'];
    $field_profile_permission->allowed_profiles = $permissions_array['allowed_profiles'];
    $field_profile_permission->required_relations = $permissions_array['required_relations'];

    $guid = $field_profile_permission->save();
    if (!$guid) {
        return false;
    }
    return true;
}

/**
 *
 * @param type $name
 * @return boolean 
 */
function prp_delete_field_profile_permission($name) {
    // comprobamos el usuario es administrador
    if (!elgg_is_admin_logged_in()) {
        // no es administrador, abandonamos
        register_error(elgg_echo('prp:error:admin_required'));
        return false;
    }

    // recuperamos el conjunto de permisos
    $field_profile_permission = prp_get_profile_permission($name);
    if ($field_profile_permission === null) {
        // entidad no encontrada
        return false;
    } else {
        return $field_profile_permission->delete();
    }

}

/**
 * Elimina todas los permisos de campos de perfil definidos
 * NOTA: Esta funcion solo permitida para el administrador
 * @return bool True si elimina los permisos, o falso si hay algun error (permisos)
 */
function prp_delete_all_field_profile_permissions() {
    // comprobamos el usuario administrador
    if (!elgg_is_admin_logged_in()){
        // no es administrador, abandonamos
        register_error(elgg_echo('prp:error:admin_required'));
        return false;
    }
    
    // recuperamos los tipos de relacion definidos
    $options = array(
        'type' => 'object',
        'subtype' => 'prp_field_profile_permission',
    );
    $field_profile_permissions_list = elgg_get_entities($options);
    // recorremos las relaciones definidas
    foreach ($field_profile_permissions_list as $field_profile_permission) {
        // eliminamos el permiso
        $field_profile_permission->delete();
    }

    // devolvemos resultado OK
    return true;
    
}


/**
 *Comprueba los permisos de que dispone el usuario logado en relacion al campo indicado
 * @param type $field_profile
 * @return boolean 
 */
function prp_check_field_profile_permission($field_profile){
    
    // si el usuario es administrador tiene permiso total
    if (elgg_is_admin_logged_in()){
        return true;
    }
    
    // recuperamos el usuario actual
    $user_to_check = elgg_get_logged_in_user_entity();
    // identificamos el perfil
    $user_profile = prp_get_user_profile_type($user_to_check);
    
    //TODO: terminar de comprobar los permisos
    
    return true;
}

/**
 * Recupera los permisos definidos que afectan al campo de perfil indicado
 * @param type $field_profile 
 */
function prp_get_permissions($field_profile){
    // recuperamos las entidades de tipo field_profile_permission
    $options = array(
        'type' => 'object',
        'subtype' => 'prp_field_profile_permission',
    );
    $field_profile_permission_list = elgg_get_entities($options);
    $selected_field_profile_permissions = array();
    foreach ($field_profile_permission_list as $field_profile_permission) {
        // comprobamos si en el permiso indicado se hace referencia al campo de perfil (en teoría solo debería aparecer en uno)
        if (in_array($field_profile, $field_profile_permission->field_profiles)){
            array_push($selected_field_profile_permissions, $field_profile_permission);
        }
    }
    
    // devolvemos permisos
    return $selected_field_profile_permissions;
    
}

/**
 * Recupera las configuraciones de permisos definidas en la plataforma, devolviendo las 
 * entidades correspondientes
 * @return array lista de ElggPRPFieldProfilePermissions
 */
function prp_get_profile_permissions() {
    // recuperamos la relacion
    $options = array(
        'type' => 'object',
        'subtype' => 'prp_field_profile_permission',
    );
    return elgg_get_entities($options);
}


/**
 * Completa la configuracion de permisos con los permisos por defecto
 * @param type $permissions permisos originales
 * @return array permisos completados con los valores por defecto
 */
function prp_merge_with_default_field_profile_permissions($permissions) {

    // establecemos los valores predeterminados
    $default_permissions = array(
        'field_profiles' => array(), // campos a los que aplica el permiso
        'hide_to_owner' => 'false', // campo oculto al usuario?
        'lock_to_owner' => 'false', // campo bloqueado para modificacion para el usuario?
        'public_field' => 'false', // el campo es público?
        'allowed_profiles' => array(), // permisos relacionados con los perfiles (edit/view/none|null)
        'required_relations' => array(), // permisos relacionados con las relaciones (edit/view/none|null)
    );
    // añadimos los permisos por defecto
    return array_merge($default_permissions, $permissions);
}

/**
 * Recupera un conjunto de permisos para un campo (o campos) de perfil personalizados
 * @param type $name Nombre del permiso (codigo)
 * @return ElggPRPFieldProfilePermission|NULL El conjunto de permisos, o Null si no existe
 */
function prp_get_profile_permission($name) {

    // localizamos las entidades
    $options = array(
        'type' => 'object',
        'subtype' => 'prp_field_profile_permission',
    );
    $field_profile_permission_list = elgg_get_entities($options);
    foreach ($field_profile_permission_list as $field_profile_permission) {
        if ($field_profile_permission->name == $name) {
            return $field_profile_permission;
        }
    }
    // entidad no encontrada
    return null;
}