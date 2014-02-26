<?php

/**
 * Libreria de funciones asociadas al registro de ejecuciÃ³n de tratamientos
 * @package Treatments
 */

/* OPERACIONES DE REGISTRO DE EJECUCION DE TRATAMIENTOS (alta, baja, modificacion) */

/**
 * Registra la ejecucion de un tratamiento por parte de un usuario
 * @param int $treatment_prescription_guid guid del tratamiento asignado
 * @param array $treatment_execution_information Informacion adicional de 
 * ejecucion del tratamiento:
 *  - $treatment_execution_information['execution_result'] ==> resultado de la ejecucion
 * - Opcionales:
 *  - $treatment_execution_information['user_feedback'] ==> evaluacion del usuario
 *  - $treatment_execution_information['date_executed'] ==> fecha de ejecucion del tratamiento  (por defecto la fecha actual)
 *  - $treatment_execution_information['user_guid'] ==> usuario que realiza el tratamiento (por defecto el usuario actual)
 *  - $treatment_execution_information['not_executed'] ==> indica que el tratatamiento no ha sido realizado (por defecto false)
 * @return mixed TreatmentExecutionEntity del registro de ejecucion creado, o 
 * null si no la ha creado
 */
function treatments_register_treatment_execution($treatment_prescription_guid, $treatment_execution_information) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para asignar tratamientos
    } else {
        // recuperamos datos para comprobar permisos
        if (isset($treatment_execution_information['user_guid'])) {
            $executor_user = get_user($treatment_execution_information['user_guid']);
        } else {
            $executor_user = elgg_get_logged_in_user_entity();
        }
        $treatment_prescription = get_user($treatment_prescription_guid);
        $has_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::EXECUTE_TREATMENT, array(
            'user' => $executor_user,
            'object' => $treatment_prescription,
                ));
        if (!$has_permission) {
            return null;
        }
    }

    // Creamos el objeto ejecucion
    /** @var ElggTreatmentExecution $treatment_execution */
    $treatment_execution = new ElggTreatmentExecution();

    // guardamos el guid del tratamiento asignado
    $treatment_execution->prescription_guid = $treatment_prescription_guid;

    // Campos obligatorios
    // resultado de ejecucion
    if (isset($treatment_execution_information['execution_result'])) {
        $treatment_execution->execution_result = $treatment_execution_information['execution_result'];
    } else {
        return null;
    }
    // evaluacion del usuario
    if (isset($treatment_execution_information['user_feedback'])) {
        $treatment_execution->user_feedback = $treatment_execution_information['user_feedback'];
    } else {
        return null;
    }

    // campos opcionales
    // Fecha de ejecucion
    if (isset($treatment_execution_information['date_executed'])) {
        if ($treatment_execution_information['date_executed'] instanceof DateTime) {
            $treatment_execution->date_executed = $treatment_execution_information['date_executed'];
        } else { // asumimos que es un string...
            $treatment_execution->date_executed = new DateTime($treatment_execution_information['date_executed']);
        }
    } elseif (!isset($treatment_execution->date_executed)) {
        $treatment_execution->date_executed = new DateTime();
    }

    // usario que ejecuta el tratamiento
    if (isset($treatment_execution_information['user_guid'])) {
        $treatment_execution->owner_guid = $treatment_execution_information['user_guid'];
    } elseif (!isset($treatment_execution->owner_guid)) {
        $treatment_execution->owner_guid = elgg_get_logged_in_user_guid();
    }

    // flag de no ejecucion
    if (isset($treatment_execution_information['not_executed'])) {
        $treatment_execution->not_executed = $treatment_execution_information['not_executed'];
    } else {
        $treatment_execution->not_executed = false;
    }

    if ($treatment_execution->save()) {
        return $treatment_execution;
    } else {
        return null;
    }
}

/**
 * Modifica la informaciÃ³n de un tratamiento asignado a un usuario.
 * Esta funcion estÃ¡ ideada para establecer la evaluacion, pero se puede usar 
 * para modificar los datos de realizacion, indicando los campos 
 * correspondientes, pero se requiere permiso de gestion para ejecutarla, y no 
 * deberÃ­a usarse para registrar y evaluar un tratamiento de forma simultanea
 * @param int $treatment_execution_guid guid del tratamiento asignado
 * @param array $treatment_execution_information InformaciÃ³n de realizacion del 
 * tratamiento:
 *  - $treatment_execution_information['prescriptor_evaluation'] ==> informe de evaluacion
 * - Opcionales:
 *  - $treatment_execution_information['date_evaluated'] ==> fecha de evaluacion (por defecto se toma la actual)
 * Se pueden indicar opcionalmente campos de la ejecucion del tratamiento
 *  - $treatment_execution_information['date_executed'] ==> fecha de ejecucion del tratamiento
 *  - $treatment_execution_information['user_guid'] ==> usuario que realiza el tratamiento
 *  - $treatment_execution_information['execution_result'] ==> resultado de la ejecucion
 *  - $treatment_execution_information['user_feedback'] ==> evaluacion del usuario
 *  - $treatment_execution_information['not_executed'] ==> indica que el tratatamiento no ha sido realizado
 * @return mixed TreatmentExecutionEntity del registro de ejecucion modificada, o null si no la ha modificado
 */
function treatments_save_treatment_execution($treatment_execution_guid, $treatment_execution_information) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para asignar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::MANAGE_TREATMENT_EXECUTION, null)) {
        return null;
    }

    // Recuperamos el objeto ejecucion
    /** @var ElggTreatmentExecution $treatment_execution */
    $treatment_execution = get_entity($treatment_execution_guid);
    if ($treatment_execution === null) {
        // registro no encontrado
        return null;
    }

    // Comprobamos datos de evaluacion del tratamiento
    if (isset($treatment_execution_information['prescriptor_evaluation'])) {
        $treatment_execution->prescriptor_evaluation = $treatment_execution_information['prescriptor_evaluation'];
        // Fecha de evaluacion
        if (isset($treatment_execution_information['date_evaluated'])) {
            if ($treatment_execution_information['date_evaluated'] instanceof DateTime) {
                $treatment_execution->date_evaluated = $treatment_execution_information['date_evaluated'];
            } else { // asumimos que es un string...
                $treatment_execution->date_evaluated = new DateTime($treatment_execution_information['date_evaluated']);
            }
        } elseif (!isset($treatment_execution->date_evaluated)) {
            $treatment_execution->date_evaluated = new DateTime();
        }
    }

    // Comprobamos datos opcionales de realizacion del tratamiento
    // Fecha de ejecucion
    if (isset($treatment_execution_information['date_executed'])) {
        if ($treatment_execution_information['date_executed'] instanceof DateTime) {
            $treatment_execution->date_executed = $treatment_execution_information['date_executed'];
        } else { // asumimos que es un string...
            $treatment_execution->date_executed = new DateTime($treatment_execution_information['date_executed']);
        }
    }

    // usario que ejecuta el tratamiento
    if (isset($treatment_execution_information['user_guid'])) {
        $treatment_execution->owner_guid = $treatment_execution_information['user_guid'];
    }
    // resultado de ejecucion
    if (isset($treatment_execution_information['execution_result'])) {
        $treatment_execution->execution_result = $treatment_execution_information['execution_result'];
    }
    // evaluacion del usuario
    if (isset($treatment_execution_information['user_feedback'])) {
        $treatment_execution->user_feedback = $treatment_execution_information['user_feedback'];
    }
    // flag de no ejecucion
    if (isset($treatment_execution_information['not_executed'])) {
        $treatment_execution->not_executed = $treatment_execution_information['not_executed'];
    }

    // establecemos el nivel de acceso a usuarios logagos
    $treatment_execution->access_id = 1;

    // guardamos los datos
    if ($treatment_execution->save()) {
        // devolvemos la entidad
        return $treatment_execution;
    } else {
        return null;
    }
}

/**
 * Archiva una ejecuciÃ³n de tratamiento asignado
 * @param type $treatment_execution_guid guid del registro de ejecucion del tratamiento asignado
 * @return bool True si lo archiva, false en otro caso (registro no encontrado...)
 */
function treatments_archive_treatment_execution($treatment_execution_guid) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para asignar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::MANAGE_TREATMENT_EXECUTION, null)) {
        return null;
    }

    // recuperamos el registro de ejecucion del tratamiento asignado
    /** @var ElggTreatmentExecution */
    $treatment_execution = get_entity($treatment_execution_guid);
    if (!$treatment_execution) {
        return false;
    } else {
        $treatment_execution->is_archived = true;
        if ($treatment_execution->save()) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Restarura una ejecuciÃ³n de tratamiento asignado
 * @param type $treatment_execution_guid guid del registro de ejecucion del tratamiento asignado
 * @return bool True si lo restaura, false en otro caso (registro no encontrado...)
 */
function treatments_restore_treatment_execution($treatment_execution_guid) {

    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para asignar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::MANAGE_TREATMENT_EXECUTION, null)) {
        return null;
    }

    // recuperamos el registro de ejecucion del tratamiento asignado
    /** @var ElggTreatmentExecution */
    $treatment_execution = get_entity($treatment_execution_guid);
    if (!$treatment_execution) {
        return false;
    } else {
        $treatment_execution->is_archived = false;
        if ($treatment_execution->save()) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Elimina un registro de ejecucion de tratamiento asignado
 * @param type $treatment_execution_guid guid del registro de ejecucion del tratamiento asignado
 * @return bool True si lo elimina, false en otro caso (registro  no encontrado...)
 */
function treatments_delete_treatment_execution($treatment_execution_guid) {
    // comprobamos usuario es administrador
    if (!elgg_is_admin_logged_in()) {
        return false;
    }
    // recuperamos el registro de ejecucion del tratamiento asignado
    /** @var ElggTreatmentExecution */
    $treatment_execution = get_entity($treatment_execution_guid);
    if ($treatment_execution) {
        return $treatment_execution->delete();
    } else {
        return false;
    }
}

/* OPERACIONES DE CONSULTA DE REGISTROS DE EJECUCION DE TRATAMIENTOS ASIGNADOS */

/**
 * Recupera el registro de ejecucion del tratamiento asignado a partir del guid (get_entity())
 * @param type $treatment_execution_guid guid del tratamiento asignado
 * @return ElggTreatmentExecution
 */
function treatments_get_treatment_execution($treatment_execution_guid) {
    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para visualizar registros de ejecucion de tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT_EXECUTION, null)) {
        return null;
    }

    return get_entity($treatment_execution_guid);
}

/**
 * Recupera los registros de ejecucion activos (no archivados) de un tratamiento 
 * asignado a un usuario
 * @param int $treatment_prescription_guid. identificador del tratamiento asignado
 * el que se quieren consultar registros de ejecucion
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_treatment_prescription_executions($treatment_prescription_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_treatment_executions_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'prescription_guid' => $treatment_prescription_guid,
            'is_archived' => 0,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_treatment_executions_all($search_options);
}

/**
 * Recupera los registros de ejecucion inactivos (archivados) de un tratamiento 
 * asignado a un usuario
 * @param int $treatment_prescription_guid. identificador del tratamiento asignado
 * el que se quieren consultar registros de ejecucion
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_treatment_prescription_executions_archived($treatment_prescription_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_treatment_executions_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'prescription_guid' => $treatment_prescription_guid,
            'is_archived' => 1,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_treatment_executions_all($search_options);
}

/**
 * Recupera los registros de ejecucion (archivados o no) de un tratamiento 
 * asignado a un usuario
 * @param int $treatment_prescription_guid. identificador del tratamiento asignado
 * el que se quieren consultar registros de ejecucion
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_treatment_prescription_executions_all($treatment_prescription_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_treatment_executions_all, que comprueba 
    // permisos, por lo que no es necesario comprobarlos aqui
    // preparamos los parÃ¡metros para la consulta con elgg    
    $search_options = array(
        'metadata_name_value_pairs' => array(
            'prescription_guid' => $treatment_prescription_guid,
        ),
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    return treatments_get_treatment_executions_all($search_options);
}

/**
 * Recupera los registros de ejecucion activos (no archivados) de tratamientos 
 * realizados por un usuario
 * @param int $user_guid. identificador del usuario del que se quieren consultar
 * los registros de ejecucion de tratamientos
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_user_treatment_executions($user_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_treatment_executions_all, que comprueba 
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
    return treatments_get_treatment_executions_all($search_options);
}

/**
 * Recupera los registros de ejecucion inactivos (archivados) de tratamientos 
 * realizados por un usuario
 * @param int $user_guid. identificador del usuario del que se quieren consultar
 * los registros de ejecucion de tratamientos
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_user_treatment_executions_archived($user_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_treatment_executions_all, que comprueba 
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
    return treatments_get_treatment_executions_all($search_options);
}

/**
 * Recupera los registros de ejecucion activos (archivados o no) de tratamientos 
 * realizados por un usuario
 * @param int $user_guid. identificador del usuario del que se quieren consultar
 * los registros de ejecucion de tratamientos
 * @param Array $options. Array con opciones adicionales, conforme a la sintaxis 
 * de consultas de elgg
 */
function treatments_get_user_treatment_executions_all($user_guid, $options = null) {
    // vamos a utilizar la funcion treatments_get_treatment_executions_all, que comprueba 
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
    return treatments_get_treatment_executions_all($search_options);
}

/**
 * Devuelte todos los registros de ejecucion de tratamientos asignados definidos. 
 * Admite un array para configurar la consulta, conforme a la sintaxis de 
 * consultas de elgg.
 * @param Array $options. Array para refinar la busqueda de tratamientos asignados
 */
function treatments_get_treatment_executions_all($options = null) {
    // Comprobacion de permisos para realizar la operacion.
    // El usuario admin tiene permiso siempre
    if (elgg_is_admin_logged_in()) {
        // no hacemos nada
        // comprobamos permiso para visualizar tratamientos
    } elseif (!prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT_EXECUTION, null)) {
        return null;
    }

    // preparamos los parÃ¡metros para la consulta con elgg    
    $search_options = array(
        'type' => 'object',
        'subtype' => ElggTreatmentExecution::SUBTYPE,
        'limit' => 0,
    );
    // si nos pasan datos adicionales, los unimos con los que hemos generado aqui
    if (is_array($options)) {
        // unimos las opciones que nos han pasado con las que hemos generado nosotros
        $search_options = array_merge($options, $search_options);
    }

    // ejecutamos la consulta
    $treatment_execution_list = elgg_get_entities_from_metadata($search_options);

    return $treatment_execution_list;
}
