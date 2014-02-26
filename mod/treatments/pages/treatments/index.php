<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$view_treatment_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT, null);
$execute_treatment_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::EXECUTE_TREATMENT, null);
$view_treatment_prescription_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT_PRESCRIPTION, null);

if ($view_treatment_permission) {
    forward('treatments/prescriptor_shell');
} elseif($execute_treament_permission){
    forward('treatments/treatment_prescription/list');
} elseif($view_treatment_prescription_permission){
    forward('treatments/users_related');
}