<?php

/**
 * Funciones de inicializacion del plugin de tratamientos
 */
/// TEST
//elgg_register_library('treatments', elgg_get_plugins_path() . 'treatments/lib/treatments.php');
//elgg_load_library('treatments');
elgg_register_library('treatments_test', elgg_get_plugins_path() . 'treatments/lib/test.php');
elgg_load_library('treatments_test');
// creamos tratamientos de prueba
treatments_create_fake_treatments();

// Carga de las acciones predefinidas por el módulo
elgg_load_library('prp_module_actions');
prp_register_module_action('treatments', 
        TreatmentsModuleActions::MANAGE_TREATMENT, 
        elgg_echo(TreatmentsModuleActions::MANAGE_TREATMENT_NAME));
prp_register_module_action('treatments', 
        TreatmentsModuleActions::VIEW_TREATMENT, 
        elgg_echo(TreatmentsModuleActions::VIEW_TREATMENT_NAME));
prp_register_module_action('treatments', 
        TreatmentsModuleActions::PRESCRIBE_TREATMENT, 
        elgg_echo(TreatmentsModuleActions::PRESCRIBE_TREATMENT_NAME));
prp_register_module_action('treatments', 
        TreatmentsModuleActions::VIEW_TREATMENT_PRESCRIPTION, 
        elgg_echo(TreatmentsModuleActions::VIEW_TREATMENT_PRESCRIPTION_NAME));
prp_register_module_action('treatments', 
        TreatmentsModuleActions::EXECUTE_TREATMENT, 
        elgg_echo(TreatmentsModuleActions::EXECUTE_TREATMENT_NAME));
prp_register_module_action('treatments', 
        TreatmentsModuleActions::MANAGE_TREATMENT_EXECUTION, 
        elgg_echo(TreatmentsModuleActions::MANAGE_TREATMENT_EXECUTION_NAME));
prp_register_module_action('treatments', 
        TreatmentsModuleActions::VIEW_TREATMENT_EXECUTION, 
        elgg_echo(TreatmentsModuleActions::VIEW_TREATMENT_EXECUTION_NAME));

    
