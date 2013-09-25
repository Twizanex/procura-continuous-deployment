<?php

/**
 * Override the Elggsaludo
 */
class ElggSaludo extends ElggFile {
	protected function  initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = 'saludo';
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}

	public function delete() {

		$thumbnails = array($this->thumbnail, $this->smallthumb, $this->largethumb);
		foreach ($thumbnails as $thumbnail) {
			if ($thumbnail) {
				$delsaludo = new ElggFile();
				$delsaludo->owner_guid = $this->owner_guid;
				$delsaludo->setsaludoname($thumbnail);
				$delsaludo->delete();
			}
		}

		return parent::delete();
	}
}
