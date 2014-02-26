<?php

/**
 * Clase para establecer una prescripcion de tratamiento
 * 
 * Nota: El usuario que prescribe el tratamiento queda registrado en $owner
 * 
 * @package Treatments
 * @property int      $treatment_guid               Guid del tratamiento (plantilla)
 * @property Int      $user_guid                    Guid del usuario al que se prescribe el tratamiento
 * @property DateTime $date_assigned                Fecha de asignacion
 * @property String   $user_instructions            Instrucciones especificas para el usuario (para mostrar como pop-up)
 * @property bool     $is_viewed                    Registra si el usuario ha visualizado el tratamiento
 * @property String   $treatment_schedule_guid      Programacion del tratamiento (guid de la entidad)
 * @property bool     $is_archived                  Flag para marcar que la prescripciÃ³n estÃ¡ archivada (no eliminado) (invisible)
 */
class ElggTreatmentPrescription extends ElggObject {

    const SUBTYPE = 'treatment_prescription';

    /**
     * Set subtype.
     */
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype'] = self::SUBTYPE;
        $this->access_id = 1; // logged users
        $this->is_archived = false;
    }

}