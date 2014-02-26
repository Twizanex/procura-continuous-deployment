<?php
/**
 * Clase para definir las Notificaciones que se envían a uno o varios usuarios
 * 
 * @property string $item_name          nombre del item de menú
 * @property string $profile_asigned    nombre del perfil al que se relaciona el item
 */

class ProcuraNotification extends ElggObject {

    const SUBTYPE = 'notification';

     //Set subtype.
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype'] = self::SUBTYPE;
    }
 

}