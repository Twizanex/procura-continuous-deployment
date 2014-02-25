<?php

/**
 * Clase para definir los permisos de los campos de perfil
 * 
 * @property string $item_name          nombre del item de menú
 * @property string $profile_asigned    nombre del perfil al que se relaciona el item
 * @property int    $status             YA EXISTE, una vez se ha creado la relación, en lugar
 *                                      de borrarla, podría usarse este campo para 
 *                                      establecer el estado de "anulada" u otro conveniente
 * @property string $item_url           URL del enlace asociado al item del menú
 */

class ProcuraMenuItem extends ElggObject {

    const SUBTYPE = 'custom_profile_item';

     //Set subtype.
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype'] = self::SUBTYPE;
    }
 

}
