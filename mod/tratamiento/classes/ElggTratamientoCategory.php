<?php
/**
 * Extended class to override the time_created
 */
class ElggTratamientoCategory extends ElggObject {

	/**
	 * Set subtype to tratamiento.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "tratamientoCategory";
	}

}