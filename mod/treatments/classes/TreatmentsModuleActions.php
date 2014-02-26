<?php
/**
 * Define las acciones que realiza el módulo para las cuales se requieren 
 * permisos, y que son las que se deben registrar en el módulo PRP
 * @package Treatments
 */
class TreatmentsModuleActions {
    const MANAGE_TREATMENT = 'manage_treatment';
    const VIEW_TREATMENT = 'view_tretment';
    const PRESCRIBE_TREATMENT = 'prescribe_tretment';
    const VIEW_TREATMENT_PRESCRIPTION = 'view_treatment_prescription';
    const EXECUTE_TREATMENT = 'execute_treatment';
    const MANAGE_TREATMENT_EXECUTION = 'manage_executed_treatment';
    const VIEW_TREATMENT_EXECUTION = 'view_executed_treatment';
    const MANAGE_TREATMENT_NAME = 'Gestionar tratamientos';
    const VIEW_TREATMENT_NAME = 'Visualizar tratamientos';
    const PRESCRIBE_TREATMENT_NAME = 'Asignar tratamientos';
    const VIEW_TREATMENT_PRESCRIPTION_NAME = 'Visualizar tratamientos asignados';
    const EXECUTE_TREATMENT_NAME = 'Ejecutar tratamientos asignados';
    const MANAGE_TREATMENT_EXECUTION_NAME = 'Gestionar ejecuciones de tratamientos';
    const VIEW_TREATMENT_EXECUTION_NAME = 'Visualizar ejecuciones de tratamientos';       
}