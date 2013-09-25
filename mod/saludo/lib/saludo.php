<?php
/**
 * saludo helper functions
 *
 * @package Elggsaludo
 */

/**
 * Prepare the upload/edit form variables
 *
 * @param ElggSaludo $saludo
 * @return array
 */
function saludo_prepare_form_vars($saludo = null) {

	// input names => defaults
	$values = array(
		'title' => '',
		'paciente' => null,
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $saludo,
	);

	if ($saludo) {
		foreach (array_keys($values) as $field) {
			if (isset($saludo->$field)) {
				$values[$field] = $saludo->$field;
			}
		}
	}

	if (elgg_is_sticky_form('saludo')) {
		$sticky_values = elgg_get_sticky_values('saludo');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('saludo');

	return $values;
}
