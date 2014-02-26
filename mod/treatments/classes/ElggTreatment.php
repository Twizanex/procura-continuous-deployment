<?php
/**
 * Clase para definir un tratamiento. 
 * 
 * Nota: El usuario que define el tratamiento queda registrado en $owner
 * 
 * @package Treatments
 * @property string $name           Nombre del tratamiento
 * @property string $description    Descripcion del tratamiento
 * @property string $benefits       Beneficios esperados del tratamiento
 * @property string $instructions   Instrucciones para realizacion del tratamiento
 * @property array  $resources      Recursos para ilustrar el tratamiento
 * @property string $category       Categoria del tratamiento
 * @property string $level          Nivel de complejidad/difucultad de realizacion del tratamiento: basic|intermediate|advanced
 * @property bool   $is_archived    Flag para marcar que el tratamiento estÃ¡ archivado (no eliminado) (invisible)
 * 
 */
class ElggTreatment extends ElggObject {

    const SUBTYPE = 'treatment';
    

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