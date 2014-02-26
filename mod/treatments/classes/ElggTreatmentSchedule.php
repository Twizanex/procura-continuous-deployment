<?php

/**
 * Clase para definir la periodicidad de un tratamiento. 
 * 
 * Nota: la intención es reemplazar esto por un evento de calendario
 * 
 * @package Treatments
 * @property string     $date_start     Fecha de inicio del tratamiento
 * @property string     $date_end       Fecha de finalizacion del tratamiento
 * @property integer    $period         Periodicidad del tratamiento
 * @property string     $period_type    Tipo de periodicidad (dias o semanas)
 * 
 */
class ElggTreatmentSchedule extends ElggObject {

    const SUBTYPE = 'treatment_schedule';
    

    /**
     * Set subtype.
     */
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype'] = self::SUBTYPE;
        $this->access_id = 1; // logged users

    }

}