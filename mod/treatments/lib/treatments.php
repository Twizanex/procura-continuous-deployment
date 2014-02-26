<?php

/**
 * Libreria de funciones asociadas a tratamientos
 * @package Treatments
 */

/* OPERACIONES DE GESTION DE TRATAMIENTOS (alta, baja, modificacion) */

/**
 * Da de alta un tratamiento, con la informacion proporcionada
 * @param Array $treatment_information informacion del tratamiento (ver la 
 * funcion treatment_save_treatment)
 * @return mixed TreatmentEntity del tratamiento|null si no lo crea
 */
function treatments_create_treatment($treatment_information) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para gestionar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::MANAGE_TREATMENT, null)) {
        return null;
    }

    // creamos el tratamiento
    $treatment = new ElggTreatment();
//    $treatment->is_archived = false;
    // utilizamos la funcion treatments_save_treatment para unificar el procesado de los datos a guardar
    if ($treatment->save()) {
        return treatments_save_treatment($treatment->guid, $treatment_information);
    } else {
        return null;
    }
}

/**
 * Establece la informacion de un tratamiento
 * @param int $treatment_guid Guid del tratamiento
 * @param Array $treatment_information informacion del tratamiento:
 *  - String $treatment_information['name']
 *  - String $treatment_information['description']
 *  - String $treatment_information['benefits']
 *  - String $treatment_information['instructions']
 *  - String $treatment_information['category']
 *  - String $treatment_information['level']
 * @return mixed TreatmentEntity del tratamiento|null si no lo modifica
 */
function treatments_save_treatment($treatment_guid, $treatment_information) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para gestionar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::MANAGE_TREATMENT, null)) {
        return null;
    }

    // localizamos el tratamiento
    /* @var $treatment ElggTreatment */
    $treatment = get_entity($treatment_guid);
    if ($treatment === null) {
        // tratamiento no encontrado
        return null;
    }
    // establecemos la informacion genérica del tratamiento
    $treatment_fields = array('name', 'description', 'benefits', 'instructions', 'category', 'level');
    foreach ($treatment_fields as $treatment_field) {
        if (isset($treatment_information[$treatment_field])){
            $treatment->$treatment_field = $treatment_information[$treatment_field];
        }
    }

    // establecemos el nivel de acceso a usuarios logados
    $treatment->access_id = 1;

    if ($treatment->save()) {
        return $treatment;
    } else {
        return null;
    }
}

/**
 * Archiva un tratamiento
 * @param type $treatment_guid guid del tratamiento
 * @return bool True si lo archiva, false en otro caso (tratamiento no encontrado...)
 */
function treatments_archive_treatment($treatment_guid) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para gestionar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::MANAGE_TREATMENT, null)) {
        return null;
    }

    // recuperamos el tratamiento
    /** @var ElggTreatment */
    $treatment = get_entity($treatment_guid);
    if (!$treatment) {
        return false;
    } else {
        $treatment->is_archived = true;
        if ($treatment->save()) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Recupera un tratamiento archivado (solo lo puede realizar al administrador)
 * @param type $treatment_guid guid del tratamiento
 * @return bool True si lo recupera, false en otro caso (tratamiento no encontrado...)
 */
function treatments_restore_treatment($treatment_guid) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // permiso OK
    } else {
        return null;
    }

    // recuperamos el tratamiento
    /** @var ElggTreatment */
    $treatment = get_entity($treatment_guid);
    if (!$treatment) {
        return false;
    } else {
        $treatment->is_archived = false;
        if ($treatment->save()) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Elimina un tratamiento
 * @param type $treatment_guid guid del tratamiento
 * @return bool True si lo elimina, false en otro caso (tratamiento no encontrado...)
 */
function treatments_delete_treatment($treatment_guid) {
    // comprobamos usuario es administrador
    if (!elgg_is_admin_logged_in()) {
        return false;
    }
    // recuperamos el tratamiento
    /** @var ElggTreatment */
    $treatment = get_entity($treatment_guid);
    if ($treatment) {
        return $treatment->delete();
    } else {
        return false;
    }
}

/* OPERACIONES DE CONSULTA DE TRATAMIENTOS */

/**
 * Recupera el tratamiento a partir del guid (get_entity())
 * @param type $treatment_guid guid del tratamiento
 * @return ElggTreatment
 */
function treatments_get_treatment($treatment_guid) {
    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para gestionar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT, null)) {
        return null;
    }

    return get_entity($treatment_guid);
}

/**
 * Recupera todos los tratamientos activos (no archivados)
 * @param Array options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_treatments($options = null) {
    // vamos a utilizar la funcion treatments_get_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parámetros para la consulta con elgg    
    $search_options = array(
        'metadata_name_value_pairs' => array('is_archived' => 0),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_treatments_all($search_options);
}

/**
 * Recupera todos los tratamientos archivados
 * @param Array options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_treatments_archived($options = null) {
    // vamos a utilizar la funcion treatments_get_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parámetros para la consulta con elgg    
    $search_options = array(
        'metadata_name_value_pairs' => array('is_archived' => 1),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_treatments_all($search_options = null);
}

/**
 * Devuelte todos los tratamientos definidos, archivados o no. Admite un array
 * para configurar la consulta, conforme a la sintaxis de consultas de elgg.
 * @param Array $options. Array para refinar la busqueda de tratamientos
 */
function treatments_get_treatments_all($options = null) {
    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para visualizar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT, null)) {
        echo prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT, null);
        return null;
    }

    // preparamos los parámetros para la consulta con elgg    
    $search_options = array(
        'type' => 'object',
        'subtype' => ElggTreatment::SUBTYPE,
        'limit' => 0,
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    $treatment_list = elgg_get_entities_from_metadata($search_options);

    return $treatment_list;
}