<?php

/**
 * The core language file is in /languages/en.php and each plugin has its
 * language files in a languages directory. To change a string, copy the
 * mapping into this file.
 *
 * For example, to change the blog Tools menu item
 * from "Blog" to "Rantings", copy this pair:
 * 			'blog' => "Blog",
 * into the $mapping array so that it looks like:
 * 			'blog' => "Rantings",
 *
 * Follow this pattern for any other string you want to change. Make sure this
 * plugin is lower in the plugin list than any plugin that it is modifying.
 *
 * If you want to add languages other than English, name the file according to
 * the language's ISO 639-1 code: http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
 */
$mapping = array(
    // ACTIONS MESSAGES
    'treatments:actions:treatment:archive:error' => 'Error al archivar el tratamiento',
    'treatments:actions:treatment:archive:ok' => 'Tratamiento archivado correctamente',
    'treatments:actions:treatment:delete:error' => 'Error al eliminar el tratamiento',
    'treatments:actions:treatment:delete:ok' => 'Tratamiento eliminado correctamente',
    'treatments:actions:treatment:edit:error' => 'Error al definir el tratamiento',
    'treatments:actions:treatment:edit:ok' => 'Tratamiento definido correctamente',
    'treatments:actions:treatment:restore:error' => 'Error al restaurar el tratamiento',
    'treatments:actions:treatment:restore:ok' => 'Tratamiento restaurado correctamente',
    'treatments:actions:treatment:prescribe:error' => 'Error al asignar el tratamiento',
    'treatments:actions:treatment:prescribe:ok' => 'Tratamiento asignado correctamente',

    'treatments:actions:treatment_prescription:archive:error' => 'Error al archivar el tratamiento asignado',
    'treatments:actions:treatment_prescription:archive:ok' => 'Tratamiento asignado archivado correctamente',
    'treatments:actions:treatment_prescription:delete:error' => 'Error al eliminar el tratamiento asignado',
    'treatments:actions:treatment_prescription:delete:ok' => 'Tratamiento asignado eliminado correctamente',
    'treatments:actions:treatment_prescription:edit:error' => 'Error al modificar el tratamiento asignado',
    'treatments:actions:treatment_prescription:edit:ok' => 'Tratamiento asignado modificado correctamente',
    'treatments:actions:treatment_prescription:restore:error' => 'Error al restaurar el tratamiento asignado',
    'treatments:actions:treatment_prescription:restore:ok' => 'Tratamiento asignado restaurado correctamente',

    'treatments:actions:treatment_execution:archive:error' => 'Error al archivar la ejecución del tratamiento asignado',
    'treatments:actions:treatment_execution:archive:ok' => 'Ejecución del tratamiento asignado archivado correctamente',
    'treatments:actions:treatment_execution:delete:error' => 'Error al eliminar la ejecución del tratamiento asignado',
    'treatments:actions:treatment_execution:delete:ok' => 'Ejecución del tratamiento eliminado correctamente',
    'treatments:actions:treatment_execution:edit:error' => 'Error al modificar la ejecución del tratamiento asignado',
    'treatments:actions:treatment_execution:edit:ok' => 'Ejecución del tratamiento modificado correctamente',
    'treatments:actions:treatment_execution:restore:error' => 'Error al restaurar la ejecución del tratamiento asignado',
    'treatments:actions:treatment_execution:restore:ok' => 'Ejecución del tratamiento restaurado correctamente',
    'treatments:actions:treatment_execution:evaluate:error' => 'Error al evaluar la ejecución del tratamiento asignado',
    'treatments:actions:treatment_execution:evaluate:ok' => 'Evaluación del tratamiento ejecutado correctamente',
    'treatments:actions:treatment_execution:register:error' => 'Error al registar la ejecución del tratamiento asignado',
    'treatments:actions:treatment_execution:register:ok' => 'Ejecución del tratamiento asignado registrada correctamente',

    //--------------------------------------------------------------------------
    // PAGE MESSAGES
    'treatments:pages:treatment:edit:no_permission' => 'El usuario no tiene permiso para definir tratamientos',
    'treatments:pages:treatment:edit:title' => 'Nuevo tratamiento',

    'treatments:pages:treatment:list:no_permission' => 'El usuario no tiene permiso para visualizar tratamientos',
    'treatments:pages:treatment:list:button:prescribe' => 'Asignar tratamiento',
    'treatments:pages:treatment:list:button:prescribe:title' => 'Asignar tratamiento',
    'treatments:pages:treatment:list:button:new' => 'Nuevo tratamiento',
    'treatments:pages:treatment:list:button:new:title' => 'Nuevo tratamiento',
    'treatments:pages:treatment:list:title' => 'Tratamientos',

    'treatments:pages:treatment:new:no_permission' => 'El usuario no tiene permiso para definir tratamientos',
    'treatments:pages:treatment:new:title' => 'Definir tratamiento',
    
    'treatments:pages:treatment:prescribe:no_permission' => 'El usuario no tiene permiso para asignar tratamientos',
    'treatments:pages:treatment:prescribe:title' => 'Asignar tratamiento',
    
    'treatments:pages:treatment:view:no_permission' => 'El usuario no tiene permiso para visualizar tratamientos',
    'treatments:pages:treatment:view:button:edit' => 'Modificar tratamiento',
    'treatments:pages:treatment:view:button:edit:title' => 'Modificar tratamiento',
    'treatments:pages:treatment:view:button:archive' => 'Archivar tratamiento',
    'treatments:pages:treatment:view:button:archive:title' => 'Archivar tratamiento',
    'treatments:pages:treatment:view:button:restore' => 'Restaurar tratamiento',
    'treatments:pages:treatment:view:button:restore:title' => 'Restaurar tratamiento',
    'treatments:pages:treatment:view:button:delete' => 'Eliminar tratamiento',
    'treatments:pages:treatment:view:button:delete:title' => 'Eliminar tratamiento',
    'treatments:pages:treatment:view:button:prescribe' => 'Asignar tratamiento',
    'treatments:pages:treatment:view:button:prescribe:title' => 'Asignar tratamiento',
    'treatments:pages:treatment:view:title' => 'Tratamiento',

    //···············
    'treatments:pages:treatment_prescription:edit:no_permission' => 'El usuario no tiene permiso para asignar tratamientos',
    'treatments:pages:treatment_prescription:edit:title' => 'Modificar tratamiento asignado',

    'treatments:pages:treatment_prescription:list:no_permission' => 'El usuario no tiene permiso para acceder a los tratamientos asignados',
    'treatments:pages:treatment_prescription:list:button:prescribe' => 'Asignar tratamiento',
    'treatments:pages:treatment_prescription:list:button:prescribe:title' => 'Asignar tratamiento',
    'treatments:pages:treatment_prescription:list:title' => 'Tratamientos asignados',
    
    
    'treatments:pages:prescriptor_shell:no_permission' => 'El usuario no tiene permiso para visualizar tratamientos',
    'treatments:pages:prescriptor_shell:button:treatments' => 'Mis tratamientos',
    'treatments:pages:prescriptor_shell:button:treatments:title' => 'Mis tratamientos',
    'treatments:pages:prescriptor_shell:button:patients' => 'Mis pacientes',
    'treatments:pages:prescriptor_shell:button:patients:title' => 'Mis pacientes',
    'treatments:pages:prescriptor_shell:title' => 'Tratamientos. Inicio medico',

    'treatments:pages:users_related:title' => 'Selección de paciente',

    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    // VIEWS/FORMS
    
    'treatments:forms:treatment:edit:title' => 'Tratamiento',
    'treatments:forms:treatment:edit:info' => 'Completa la información del tratamiento',
    'treatments:forms:treatment:edit:treatment_name_label' => 'Introduce un nombre para el tratamiento',
    'treatments:forms:treatment:edit:treatment_description_label' => 'Introduce una descripcion para el tratamiento',
    'treatments:forms:treatment:edit:treatment_benefits_label' => 'Describe los beneficios del tratamiento',
    'treatments:forms:treatment:edit:treatment_instructions_label' => 'Indica cómo debe realizarse el tratamiento',
    'treatments:forms:treatment:edit:treatment_category_label' => 'Selecciona el grupo de tratamientos al que pertenece el tratamiento',
    'treatments:forms:treatment:edit:treatment_level_label' => 'Selecciona el nivel de dificultad del tratamiento',
    
    'treatments:forms:treatment:prescribe:title' => 'Asignar tratamiento',
    'treatments:forms:treatment:prescribe:info' => 'Completa la información para asignar el tratamiento',
    'treatments:forms:treatment:prescribe:treatment_label' => 'Selecciona tratamiento',
    'treatments:forms:treatment:prescribe:user_label' => 'Seleccione usuario',
    'treatments:forms:treatment:prescribe:user_instructions_label' => 'Indica instrucciones específicas para realizar el tratamiento',
    'treatments:forms:treatment:prescribe:date_start_label' => 'Desde',
    'treatments:forms:treatment:prescribe:date_end_label' => 'Hasta',
    'treatments:forms:treatment:prescribe:period_type_label' => 'Periodicidad',
    'treatments:forms:treatment:prescribe:period_type:daily' => 'Diaria',
    'treatments:forms:treatment:prescribe:period_type:weekly' => 'Semanal',
    'treatments:forms:treatment:prescribe:period_type:monthly' => 'Mensual',
    'treatments:forms:treatment:prescribe:period_label' => 'Número periodos',

    'treatments:forms:treatment_prescription:edit:title' => 'Modificar tratamiento asignado',
    'treatments:forms:treatment_prescription:edit:info' => 'Completa la información para asignar el tratamiento',
    'treatments:forms:treatment_prescription:edit:treatment_label' => 'Tratamiento',
    'treatments:forms:treatment_prescription:edit:user_label' => 'Usuario',
    'treatments:forms:treatment_prescription:edit:user_instruction_label' => 'Indica instrucciones específicas para realizar el tratamiento',
    'treatments:forms:treatment_prescription:edit:date_start_label' => 'Desde',
    'treatments:forms:treatment_prescription:edit:date_end_label' => 'Hasta',
    'treatments:forms:treatment_prescription:edit:period_type_label' => 'Periodicidad',
    'treatments:forms:treatment_prescription:edit:period_type:daily' => 'Diaria',
    'treatments:forms:treatment_prescription:edit:period_type:weekly' => 'Semanal',
    'treatments:forms:treatment_prescription:edit:period_type:monthly' => 'Mensual',
    'treatments:forms:treatment_prescription:edit:period_label' => 'Número periodos',

    'treatments:forms:treatment_execution:evaluate:title' => 'Evaluacr registro de ejecución de tratamiento asignado',
    'treatments:forms:treatment_execution:evaluate:info' => 'Completa la información de evaluacion del registro de ejecución del tratamiento',
    'treatments:forms:treatment_execution:evaluate:treatment_not_executed' => 'El tratamiento no ha sido realizado',
    'treatments:forms:treatment_execution:evaluate:label:date_not_executed' => 'Fecha prevista de realizacion',
    'treatments:forms:treatment_execution:evaluate:label:date_executed' => 'Fecha de realizacion',
    'treatments:forms:treatment_execution:evaluate:label:execution_result' => 'Resultado del tratamiento',
    'treatments:forms:treatment_execution:evaluate:label:user_feedback' => 'Comentarios del usuario',
    'treatments:forms:treatment_execution:evaluate:label:date_evaluated' => 'Fecha de evaluacion',
    'treatments:forms:treatment_execution:evaluate:label:prescriptor_evaluation' => 'Informe de evaluacion',

    'treatments:forms:treatment_execution:edit:title' => 'Modificar registro de ejecución de tratamiento asignado',
    'treatments:forms:treatment_execution:edit:info' => 'Completa la información del registro de ejecución del tratamiento',
    'treatments:forms:treatment_execution:edit:treatment_label' => 'Tratamiento',
    'treatments:forms:treatment_execution:edit:user_label' => 'Usuario',
    'treatments:forms:treatment_execution:edit:user_instruction_label' => 'Indica instrucciones específicas para realizar el tratamiento',
    'treatments:forms:treatment_execution:edit:date_start_label' => 'Desde',
    'treatments:forms:treatment_execution:edit:date_end_label' => 'Hasta',
    'treatments:forms:treatment_execution:edit:period_type_label' => 'Periodicidad',
    'treatments:forms:treatment_execution:edit:period_label' => 'Número periodos',

    
    //--------------------------------------------------------------------------
    // VIEWS/JS
    
    'treatments:js:treatments:delete:confirm' => 'Confirma que desea eliminar el tratamiento',
    'treatments:js:treatments:archive:confirm' => 'Confirma que desea archivar el tratamiento',
    'treatments:js:treatments:restore:confirm' => 'Confirma que desea restaurar el tratamiento',
    'treatments:js:treatment_prescriptions:delete:confirm' => 'Confirma que desea eliminar el tratamiento asignado',
    'treatments:js:treatment_prescriptions:archive:confirm' => 'Confirma que desea archivar el tratamiento asignado',
    'treatments:js:treatment_prescriptions:restore:confirm' => 'Confirma que desea restaurar el tratamiento asignado',
    'treatments:js:treatment_executions:delete:confirm' => 'Confirma que desea eliminar la ejecución del tratamiento asignado',
    'treatments:js:treatment_executions:archive:confirm' => 'Confirma que desea archivar la ejecución del tratamiento asignado',
    'treatments:js:treatment_executions:restore:confirm' => 'Confirma que desea restaurar la ejecución del tratamiento asignado',
    
    //--------------------------------------------------------------------------
    // VIEWS/OBJECT
    // treatment
    'treatments:object:treatment:label:name' => 'Tratamiento',
    'treatments:object:treatment:label:description' => 'Descripción del tratamiento',
    'treatments:object:treatment:label:benefits' => 'Beneficios del tratamiento',
    'treatments:object:treatment:label:instructions' => 'Instrucciones para realizar el tratamiento',
    'treatments:object:treatment:label:category' => 'Grupo de tratamientos',
    'treatments:object:treatment:label:level' => 'Dificultad',
    
    // treatment_prescription
    'treatments:object:treatment_prescription:label:user_instructions' => 'Instruciones',

    // treatment_schedule
    'treatments:object:treatment_schedule:title' => 'Programación',
    'treatments:object:treatment_schedule:label:date_start' => 'Desde',
    'treatments:object:treatment_schedule:label:date_end' => 'Hasta',
    'treatments:object:treatment_schedule:label:period' => 'Periodicidad',

    // treatment_execution
    'treatments:object:treatment_execution:label:execution_result' => 'Resultado de la ejecucion',
    'treatments:object:treatment_execution:treatment_not_executed' => 'El tratamiento no ha sido ejecutado',
    'treatments:object:treatment_execution:label:date_not_executed' => 'Fecha prevista de realizacion',
    'treatments:object:treatment_execution:label:date_executed' => 'Fecha de ejecucion',
    'treatments:object:treatment_execution:label:user_feedback' => 'Evaluación del usuario',
    'treatments:object:treatment_execution:treatment_not_evaluated' => 'El tratamiento no ha sido evaluado',
    'treatments:object:treatment_execution:label:date_evaluated' => 'Fecha de evaluación',
    'treatments:object:treatment_execution:label:prescriptor_evaluation' => 'Evaluacion del prescriptor',
    
    //--------------------------------------------------------------------------
    // VIEWS/PLUGINS
    'treatments:plugins:treatments:settings:levels:label' => 'Niveles de dificultad',
    'treatments:plugins:treatments:settings:levels:info' => 'Indica los niveles de dificultad que podrán establecerse para los tratamientos, usando una línea para cada nivel',
    'treatments:plugins:treatments:settings:categories:label' => 'Grupos de tratamientos',
    'treatments:plugins:treatments:settings:categories:info' => 'Indica los grupos de tratamientos que podrán establecerse para los tratamientos, usando una línea para cada grupo',
    'treatments:plugins:treatments:settings:button:module_actions:text' => 'Configurar acciones',
    'treatments:plugins:treatments:settings:button:module_actions:title' => 'Click para configurar las acciones del modulo',
    
    //--------------------------------------------------------------------------
    // VIEWS/TREATMENTS
    // treatments/treatment/table
    'treatments:views:treatment:table:name' => 'Tratamiento',
    'treatments:views:treatment:table:category' => 'Grupo de tratamientos',
    'treatments:views:treatment:table:level' => 'Dificultad',
    'treatments:views:treatment:table:actions' => 'Acciones',    
    'treatments:views:treatment:table:button:view:title' => 'Ver tratamiento',
    'treatments:views:treatment:table:button:edit:title' => 'Modificar tratamiento',
    'treatments:views:treatment:table:button:archive:title' => 'Archivar tratamiento',
    'treatments:views:treatment:table:button:restore:title' => 'Restaurar tratamiento',
    'treatments:views:treatment:table:button:delete:title' => 'Eliminar tratamiento',
    'treatments:views:treatment:table:button:prescribe:title' => 'Asignar tratamiento',
    
    
    // treatments/treatment_prescription/table
    'treatments:views:treatment_prescription:table:name' => 'Tratamiento',
    'treatments:views:treatment_prescription:table:category' => 'Grupo de tratamientos',
    'treatments:views:treatment_prescription:table:level' => 'Dificultad',
    'treatments:views:treatment_prescription:table:date_end' => 'Finaliza',
    'treatments:views:treatment_prescription:table:actions' => 'Acciones',
    'treatments:views:treatment_prescription:table:button:view:title' => 'Ver tratamiento asignado',
    'treatments:views:treatment_prescription:table:button:edit:title' => 'Modificar tratamiento asignado',
    'treatments:views:treatment_prescription:table:button:archive:title' => 'Archivar tratamiento asignado',
    'treatments:views:treatment_prescription:table:button:restore:title' => 'Restaurar tratamiento asignado',
    'treatments:views:treatment_prescription:table:button:delete:title' => 'Eliminar tratamiento asignado',
    'treatments:views:treatment_prescription:table:button:execute:title' => 'Ejecutar tratamiento asignado',
    // Notificaciones
    'treatments:notification:treatment_prescription:ok' => 'Se te ha asignado un nuevo tratamiento. Consúltalo',
    );

//TODO: renombrar a es.php, y crear cadenas para inglés
add_translation('es', $mapping);
add_translation('en', $mapping);
