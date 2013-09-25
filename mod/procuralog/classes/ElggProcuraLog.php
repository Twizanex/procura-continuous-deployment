<?php
/**
 * Extended class to override the time_created
 */
class ElggProcuraLog extends ElggObject {

	/**
	 * Set subtype to tratamiento.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = 'procuralog';
	}
	
	public function __construct($guid = null) {
		parent::__construct($guid);
	}

}