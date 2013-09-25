<?php
/**
 * Clase para definir los tipos de relaciones admitidos
 * 
 * @property array  $subject_profiles   Array de etiquetas que definen los tipos 
 * de perfil admitidos para el "subject" de la relacion
 * @property array  $object_profiles    Array de etiquetas que definen los tipos 
 * de perfil admitidos para el "object" de la relacion
 * @property array  $allowed_profiles   Array de etiquetas que definen los tipos 
 * de perfil que pueden establecer el tipo de relacion
 */
class ElggPRPRelationName extends ElggObject {

        const SUBTYPE = 'prp_relation_name';
        
	/**
	 * Set subtype.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}


}