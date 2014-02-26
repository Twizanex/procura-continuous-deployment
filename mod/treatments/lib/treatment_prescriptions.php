<?php

/**
 * Libreria de funciones asociadas a prescripcion de tratamientos
 * @package Treatments
 */

/* OPERACIONES DE ASIGNACION DE TRATAMIENTOS (alta, baja, modificacion) */

/**
 * Asigna un tratamiento a un usuario
 * @param int $treatment_guid guid del tratamiento
 * @param int $user_guid guid del usuario al que se asigna el tratamiento
 * @param array $treatment_prescription_information Opciones de prescripcion del
 * tratamiento (ver funcion treatments_save_treatment_prescription)
 * @return mixed TreatmentPrescriptionEntity de la prescripcion creada, o null si no la ha creado
 */
function treatments_prescribe_treatment($treatment_guid, $user_guid, $treatment_prescription_information) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para asignar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::PRESCRIBE_TREATMENT, array('user'=>get_user($user_guid)))) {
        return null;
    }

    // Creamos el objeto prescripcion
    /** @var ElggTreatmentPrescription $treatment_prescription */
    $treatment_prescription = new ElggTreatmentPrescription();

    // guardamos el tratmiento y el usuario al que se asigna el tratamiento
    $treatment_prescription->treatment_guid = $treatment_guid;
    $treatment_prescription->user_guid = $user_guid;
    // guardamos los campos
    if ($treatment_prescription->save()) {
        // guardamos el resto de informacion
        return treatments_save_treatment_prescription($treatment_prescription->guid, $treatment_prescription_information);
    } else {
        return null;
    }
}

/**
 * Modifica la informaciÃ³n de un tratamiento asignado a un usuario
 * @param int $treatment_prescription_guid guid del tratamiento asignado
 * @param array $treatment_prescription_information Opciones de prescripcion del tratamiento:
 *  - $treatment_prescription_information['user_instructions'] ==> instrucciones de realizacion del tratamiento
 *  - $treatment_prescription_information['treatment_schedule'] ==> Array con la programacion del tratamiento:
 *      * date_start
 *      * date_end
 *      * period
 *      * period_type
 * Opcionales:
 *  - $treatment_prescription_information['treatment_guid'] ==> tratamiento
 *  - $treatment_prescription_information['user_guid'] ==> usuario
 *  - $treatment_prescription_information['date_asigned'] ==> fecha de asignacion (diferente de la actual)
 *  - $treatment_prescription_information['prescriptor_guid'] ==> prescriptor del tratamiento, diferente del propietario
 * @return mixed TreatmentPrescriptionEntity de la prescripcion modificara, o null si no la ha modificado
 */
function treatments_save_treatment_prescription($treatment_prescription_guid, $treatment_prescription_information) {

    // Recuperamos el objeto prescripcion
    /** @var $treatment_prescription ElggTreatmentPrescription */    
    $treatment_prescription = get_entity($treatment_prescription_guid);
    if ($treatment_prescription === null) {
        // tratamiento no encontrado
        return null;
    }
    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para asignar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::PRESCRIBE_TREATMENT, array('user'=> get_user($treatment_prescription->user_guid)))) {
        return null;
    }

    // Establecemos el tratamiento
    if (isset($treatment_prescription_information['treatment_guid'])) {
        $treatment_prescription->treatment_guid = $treatment_prescription_information['treatment_guid'];
    }
    // Establecemos el usuario
    if (isset($treatment_prescription_information['user_guid'])) {
        $treatment_prescription->user_guid = $treatment_prescription_information['user_guid'];
    }

    // Establecemos las instrucciones del tratamiento
    if (isset($treatment_prescription_information['date_assigned'])) {
        $treatment_prescription->user_instructions = $treatment_prescription_information['user_instructions'];
    }
    // Establecemos la programaciÃ³n del tratamiento
    if (isset($treatment_prescription_information['treatment_schedule'])) {
        // reperamos la entidad schedule del tratamiento
        $treatment_schedule = get_entity($treatment_prescription->treatment_schedule_guid);
        if (!$treatment_schedule){
            $treatment_schedule = new ElggTreatmentSchedule();
            $treatment_schedule->save();
            $treatment_prescription->treatment_schedule_guid = $treatment_schedule->guid;
        }
        
        // completamos los datos
        $treatment_schedule_array = $treatment_prescription_information['treatment_schedule'];
        $treatment_schedule->date_start = $treatment_schedule_array['date_start'];
        $treatment_schedule->date_end = $treatment_schedule_array['date_end'];
        $treatment_schedule->period = $treatment_schedule_array['period'];
        $treatment_schedule->period_type = $treatment_schedule_array['period_type'];
        $treatment_schedule->save();
    }
    
    // Fecha de asignacion
    if (isset($treatment_prescription_information['date_assigned'])) {
        if ($treatment_prescription_information['date_assigned'] instanceof DateTime) {
            $treatment_prescription->date_assigned = $treatment_prescription_information['date_assigned'];
        } else { // asumimos que es un string...
            $treatment_prescription->date_assigned = new DateTime($treatment_prescription_information['date_assigned']);
        }
    } elseif (!isset($treatment_prescription->date_assigned)) {
        $treatment_prescription->date_assigned = new DateTime();
    }
    // prescriptor
    if (isset($treatment_prescription_information['prescriptor_guid'])) {
        $treatment_prescription->owner_guid = $prescription_options['prescriptor_guid'];
    } elseif (!isset($treatment_prescription->owner_guid)) {
        $treatment_prescription->owner_guid = elgg_get_logged_in_user_guid();
    }

    // establecemos el nivel de acceso a usuarios logados
    $treatment_prescription->access_id = 1;

    // guardamos los datos
    if ($treatment_prescription->save()) {
        // devolvemos la entidad
        return $treatment_prescription;
    } else {
        return null;
    }
}

/**
 * Archiva un tratamiento asignado
 * @param type $treatment_prescription_guid guid del tratamiento asignado
 * @return bool True si lo archiva, false en otro caso (tratamiento no encontrado...)
 */
function treatments_archive_treatment_prescription($treatment_prescription_guid) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para asignar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::PRESCRIBE_TREATMENT, null)) {
        return null;
    }

    // recuperamos el tratamiento asignado
    /** @var ElggTreatmentPrescription */
    $treatment_prescription = get_entity($treatment_prescription_guid);
    if (!$treatment_prescription) {
        return false;
    } else {
        $treatment_prescription->is_archived = true;
        if ($treatment_prescription->save()) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Restaura un tratamiento asignado
 * @param type $treatment_prescription_guid guid del tratamiento asignado
 * @return bool True si lo restaura, false en otro caso (tratamiento no encontrado...)
 */
function treatments_restore_treatment_prescription($treatment_prescription_guid) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para asignar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::PRESCRIBE_TREATMENT, null)) {
        return null;
    }

    // recuperamos el tratamiento asignado
    /** @var ElggTreatmentPrescription */
    $treatment_prescription = get_entity($treatment_prescription_guid);
    if (!$treatment_prescription) {
        return false;
    } else {
        $treatment_prescription->is_archived = false;
        if ($treatment_prescription->save()) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Elimina un tratamiento asignado
 * @param type $treatment_prescription_guid guid del tratamiento asignado
 * @return bool True si lo elimina, false en otro caso (tratamiento no encontrado...)
 */
function treatments_delete_treatment_prescription($treatment_prescription_guid) {
    // comprobamos usuario es administrador
    if (!elgg_is_admin_logged_in()) {
        return false;
    }
    // recuperamos el tratamiento asignado
    /** @var ElggTreatmentPrescription */
    $treatment_prescription = get_entity($treatment_prescription_guid);
    if ($treatment_prescription) {
        return $treatment_prescription->delete();
    } else {
        return false;
    }
}

/* OPERACIONES DE CONSULTA DE TRATAMIENTOS ASIGNADOS */

/**
 * Recupera el tratamiento asignado a partir del guid (get_entity())
 * @param type $treatment_prescription_guid guid del tratamiento asignado
 * @return ElggTreatmentPrescription
 */
function treatments_get_prescribed_treatment($treatment_prescription_guid) {
    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para gestionar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT_PRESCRIPTION, null)) {
        return null;
    }

    return get_entity($treatment_prescription_guid);
}

/**
 * Recupera los tratamientos asignados a un usuario activos (no archivados)
 * @param int $user_guid. identificador del usuario sobre el que se quieren 
 * consultar tratamientos
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_user_prescribed_treatments($user_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_prescribed_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    if ($user_guid === null) {
        $user_guid = elgg_get_logged_in_user_guid();
    }
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'user_guid' => $user_guid,
            'is_archived' => 0,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_prescribed_treatments_all($search_options);
}

/**
 * Recupera los tratamientos asignados a un usuario inactivos (archivados)
 * @param int $user_guid. identificador del usuario sobre el que se quieren 
 * consultar tratamientos
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_user_prescribed_treatments_archived($user_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_prescribed_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    if ($user_guid === null) {
        $user_guid = elgg_get_logged_in_user_guid();
    }
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'user_guid' => $user_guid,
            'is_archived' => 1,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_prescribed_treatments_all($search_options);
}

/**
 * Recupera los tratamientos asignados a un usuario (archivados o no)
 * @param int $user_guid. identificador del usuario sobre el que se quieren 
 * consultar tratamientos
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_user_prescribed_treatments_all($user_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_prescribed_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    if ($user_guid === null) {
        $user_guid = elgg_get_logged_in_user_guid();
    }
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'user_guid' => $user_guid,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_prescribed_treatments_all($search_options);
}

/**
 * Recupera los tratamientos activos (no archivados) prescritos por un usuario 
 * @param int $user_guid. identificador del usuario que ha prescrito los 
 * tratamientos
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_prescribed_treatments_user($user_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_prescribed_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    if ($user_guid === null) {
        $user_guid = elgg_get_logged_in_user_guid();
    }
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'owner' => $user_guid,
            'is_archived' => 0,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_prescribed_treatments_all($search_options);
}

/**
 * Recupera los tratamientos inactivos (archivados) prescritos por un usuario 
 * @param int $user_guid. identificador del usuario que ha prescrito los 
 * tratamientos
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_prescribed_treatments_user_archived($user_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_prescribed_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    if ($user_guid === null) {
        $user_guid = elgg_get_logged_in_user_guid();
    }
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'owner' => $user_guid,
            'is_archived' => 1,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_prescribed_treatments_all($search_options);
}

/**
 * Recupera los tratamientos prescritos por un usuario 
 * @param int $user_guid. identificador del usuario que ha prescrito los 
 * tratamientos
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_prescribed_treatments_user_all($user_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_prescribed_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    if ($user_guid === null) {
        $user_guid = elgg_get_logged_in_user_guid();
    }
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'owner' => $user_guid,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_prescribed_treatments_all($search_options);
}

/**
 * Recupera las prescripciones de tratamientos activos (no archivados) de un 
 * tratamiento determinado
 * @param int $treatment_guid. identificador del tratamiento prescrito
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_treatment_prescribed_treatments($treatment_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_prescribed_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'treatment_guid' => $treatment_guid,
            'is_archived' => 0,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_prescribed_treatments_all($search_options);
}

/**
 * Recupera las prescripciones de tratamientos inactivos (archivados) de un 
 * tratamiento determinado
 * @param int $treatment_guid. identificador del tratamiento prescrito
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_treatment_prescribed_treatments_archived($treatment_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_prescribed_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'treatment_guid' => $treatment_guid,
            'is_archived' => 1,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_prescribed_treatments_all($search_options);
}

/**
 * Recupera las prescripciones de tratamientos de un tratamiento determinado
 * @param int $treatment_guid. identificador del tratamiento prescrito
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_treatment_prescribed_treatments_all($treatment_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_prescribed_treatments_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'treatment_guid' => $treatment_guid,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_prescribed_treatments_all($search_options);
}

/**
 * Devuelte todos los tratamientos asignados definidos. Admite un array
 * para configurar la consulta, conforme a la sintaxis de consultas de elgg.
 * @param Array $options. Array para refinar la busqueda de tratamientos asignados
 */
function treatments_get_prescribed_treatments_all($options = null) {
    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para visualizar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT_PRESCRIPTION, null)) {
        return null;
    }

    // preparamos los parÃ¡metros para la consulta con elgg    
    $search_options = array(
        'type' => 'object',
        'subtype' => ElggTreatmentPrescription::SUBTYPE,
        'limit' => 0,
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    $treatment_prescription_list = elgg_get_entities_from_metadata($search_options);

    return $treatment_prescription_list;
}
