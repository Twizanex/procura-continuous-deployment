<?php
/**
 * Register the Elgginformacion class for the object/informacion subtype
 */

if (get_subtype_id('object', 'informacion')) {
	update_subtype('object', 'informacion', 'Elgginformacion');
} else {
	add_subtype('object', 'informacion', 'Elgginformacion');
}
