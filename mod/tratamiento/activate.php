<?php
/**
 * Register the ElggTratamiento class for the object/tratamiento subtype
 */

if (get_subtype_id('object', 'tratamiento')) {
	update_subtype('object', 'tratamiento', 'ElggTratamiento');
} else {
	add_subtype('object', 'tratamiento', 'ElggTratamiento');
}
