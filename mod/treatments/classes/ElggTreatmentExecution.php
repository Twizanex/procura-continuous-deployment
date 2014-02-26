<?php

/**
 * Clase para almacenar los datos de una realizacion del tratamiento
 * 
 * Nota: El usuario que realiza el tratamiento queda registrado en $owner
 * 
 * @package Treatments
 * @property string $prescription_guid          Guid de la prescripcion
 * @property string $date_executed              Fecha de realizacion
 * @property string $execution_result           Resultados de ejecucion (depende del tipo de tratamiento, herramientas, etc). En versiones posteriores se cambiará esto por una entidad especifica
 * @property string $user_feedback              Evaluacion realizada por el usuario. En versiones posteriores se cambiará esto por una entidad especifica
 * @property bool   $not_executed               Flag para indicar que el tratamiento no ha sido realizado por el usuario
 * @property string $date_evaluated             Fecha de evaluacion
 * @property string $prescriptor_evaluation     Evaluacion realizada por el prescriptor. En versiones posteriores se cambiará esto por una entidad especifica
 * @property bool   $is_archived                Flag para marcar que el registro está archivado (no eliminado) (invisible)
 */
class ElggTreatmentExecution extends ElggObject {

    const SUBTYPE = 'treatment_execution';

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