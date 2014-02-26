<?php
/**
 * Funciones de desactivacion del plugin de tratamientos
 */

/// TEST
// borramos los tratamientos creados
treatments_delete_all_treatments();

// Descarga de las acciones predefinidas por el módulo
elgg_load_library('prp_module_actions');
prp_unregister_module_action('treatments', 
        TreatmentsModuleActions::MANAGE_TREATMENT);
prp_unregister_module_action('treatments', 
        TreatmentsModuleActions::VIEW_TREATMENT);
prp_unregister_module_action('treatments', 
        TreatmentsModuleActions::PRESCRIBE_TREATMENT);
prp_unregister_module_action('treatments', 
        TreatmentsModuleActions::VIEW_TREATMENT_PRESCRIPTION);
prp_unregister_module_action('treatments', 
        TreatmentsModuleActions::EXECUTE_TREATMENT);
prp_unregister_module_action('treatments', 
        TreatmentsModuleActions::MANAGE_TREATMENT_EXECUTION);
prp_unregister_module_action('treatments', 
        TreatmentsModuleActions::VIEW_TREATMENT_EXECUTION);
