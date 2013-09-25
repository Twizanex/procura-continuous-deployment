<?php
/**
 * Register the ElggTratamiento class for the object/tratamiento subtype
 */

if (get_subtype_id('object', 'procuralog')) {
	update_subtype('object', 'procuralog', 'ElggProcuraLog');
} else {
	add_subtype('object', 'procuralog', 'ElggProcuraLog');
}
