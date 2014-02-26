<?php

/**
 * Libreria de funciones comunies asociadas al módulo de tratamientos
 * @package Treatments
 */

/**
 * Registra el menú correspondiente al prescriptor, y devuelve la representación
 * del menú para mostrarlo en la página 
 * @return String Representacion del menu
 */
function treatments_get_prescriptor_menu() {

    // Registramos las pestañas correspondientes al prescriptor
    // en este caso no hay opciones...
    // devolvemos el menú
    return elgg_view_menu('treatments');
}

/**
 * Registra el menú correspondiente al paciente, y devuelve la representación
 * del menú para mostrarlo en la página 
 * @return String Representacion del menu
 */
function treatments_get_patient_menu() {
    // Registramos las pestañas correspondientes al paciente
    elgg_register_menu_item('treatments', new ElggMenuItem('treatment-prescriptions-list', elgg_echo('Mis tratamientos'), '/treatments/treatment_prescription/list'));
    elgg_register_menu_item('treatments', new ElggMenuItem('treatment-execution-report', elgg_echo('Progresos'), '/treatments/treatment_execution/report'));

    // devolvemos el menú
    return elgg_view_menu('treatments');
}

/**
 * Recupera el menú de pestañas correspondiente a las opciones del paciente 
 * @param $patient_guid Identificador del paciente, para construir los enlaces
 * @return String Representacion del menu
 */
function treatments_get_patient_shell_tabs(String $patient_guid) {
    
}

/**
 * Registra el menú correspondiente al evaluador, y devuelve la representación
 * del menú para mostrarlo en la página 
 * @return String Representacion del menu
 */
function treatments_get_evaluator_menu() {
    // Registramos las pestañas correspondientes al evaluador
    elgg_register_menu_item('treatments', new ElggMenuItem('treatment-execution-list', elgg_echo('Tratamientos realizados'), '/treatments/treatment_execution/list'));
    elgg_register_menu_item('treatments', new ElggMenuItem('treatment-execution-report', elgg_echo('Progresos'), '/treatments/treatment_execution/report'));

    // devolvemos el menú
    return elgg_view_menu('treatments');
}
