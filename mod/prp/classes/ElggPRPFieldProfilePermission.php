<?php

/**
 * Clase para definir los permisos de los campos de perfil
 * 
 * @property string $category           identificador de la categoria a la que se refiere el permiso
 * @property bool   $hide_to_owner      ocultar al propietario
 * @property bool   $lock_to_owner      bloquear al propietario
 * @property bool   $public_field       campo publico
 * @property array  $allowed_profiles   perfiles que pueden acceder al campo (view/edit)
 * @property array  $required_relations relaciones que permiten acceder al campo (view/edit)
 */
class ElggPRPFieldProfilePermission extends ElggObject {

    const SUBTYPE = 'prp_field_profile_permission';

    /**
     * Set subtype.
     */
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype'] = self::SUBTYPE;
    }

}