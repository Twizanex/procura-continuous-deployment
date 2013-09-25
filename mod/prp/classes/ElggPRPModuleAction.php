<?php

/**
 * Clase para definir las acciones de los modulos
 * 
 * @property string $action_name        identificador de la accion
 * @property string $module_name        identificador del modulo de la accion
 * @property bool   $requires_profile   Indicador de si la accion requiere un perfil 
 *                                      o perfiles de usuario determinados para ejecutar 
 *                                      la accion
 * @property array  $required_profiles  Array de etiquetas que definen los tipos 
 *                                      de perfil requeridos para ejecutar la accion
 * @property bool   $requires_relation  Indicador de si la accion requiere una relacion
 *                                      determinada con el usuario al que afecta 
 *                                      la accion
 * @property array  $required_relations Array de etiquetas que definen los tipos 
 *                                      de relacion requeridos para ejecutar la accion
 * @property bool   $requires_owner     Indicador de si la accion requiere que el 
 *                                      usuario sea el propietario del objeto al
 *                                      que afecta la accion
 */
class ElggPRPModuleAction extends ElggObject {

    const SUBTYPE = 'prp_module_action';

    /**
     * Set subtype.
     */
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype'] = self::SUBTYPE;
    }

}