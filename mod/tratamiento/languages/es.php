<?php
/**
 * Tratamiento Spanish language file.
 *
 */

$spahish = array(
	'tratamiento' => 'Tratamientos',
	'tratamiento:tratamientos' => 'Tratamientos',
	'tratamiento:revisions' => 'Revisiones',
	'tratamiento:archives' => 'Archivos',
	'tratamiento:tratamiento' => 'tratamiento',
	'item:object:tratamiento' => 'Tratamientos',

	'tratamiento:title:user_tratamientos' => 'Tratamientos de %s',
	'tratamiento:title:all_tratamientos' => 'Todos los tratamientos del sitio',
	'tratamiento:title:friends' => 'Tratamientos de amigos',

	'tratamiento:group' => 'Tratamiento del grupo',
	'tratamiento:enabletratamiento' => 'Habilitar tratamiento del grupo',
	'tratamiento:write' => 'Agregar una entrada al tratamiento',

	// Editing
	'tratamiento:add' => 'Agregar tratamiento',
	'tratamiento:edit' => 'Editar tratamiento',
	'tratamiento:pacientes' => 'Paciente al que enviarlo',
	'tratamiento:body' => 'Detalles',
	'tratamiento:save_status' => 'Guardado: ',
	'tratamiento:never' => 'Nunca',

	// Statuses
	'tratamiento:status' => 'Estado',
	'tratamiento:status:draft' => 'Borrador',
	'tratamiento:status:published' => 'Publicado',
	'tratamiento:status:unsaved_draft' => 'Borrador no guardado',

	'tratamiento:revision' => 'Revisi&oacute;n',
	'tratamiento:auto_saved_revision' => 'Revisi&oacute;n guardada automaticamente',

	// messages
	'tratamiento:message:saved' => 'Entrada del tratamiento guardada.',
	'tratamiento:error:cannot_save' => 'No se pudo guardar la entrada del tratamiento.',
	'tratamiento:error:cannot_write_to_container' => 'No posee los permisos necesarios para a&ntilde;adir el tratamiento al grupo.',
	'tratamiento:error:post_not_found' => 'Esta entrada ha sido quitada, es inv&aacute;lida, o no tiene los permisos necesarios para poder verla.',
	'tratamiento:messages:warning:draft' => 'Hay un borrador sin guardar para esta entrada!',
	'tratamiento:edit_revision_notice' => '(Versi&oacute;n anterior)',
	'tratamiento:message:deleted_post' => 'Entrada del tratamiento eliminada.',
	'tratamiento:error:cannot_delete_post' => 'No se pudo eliminar la entrada del tratamiento.',
	'tratamiento:none' => 'No hay entradas en el tratamiento',
	'tratamiento:error:missing:title' => 'Debe ingresar un t&iacute;tulo para el tratamiento!',
	'tratamiento:error:missing:description' => 'Debe ingresar el cuerpo de su tratamiento!',
	'tratamiento:error:cannot_edit_post' => 'La publicaci&oacute;n no existe o no posee los permisos necesarios sobre ella.',
	'tratamiento:error:revision_not_found' => 'No se pudo encontrar la revisi&oacute;n.',

	// river
	'river:create:object:tratamiento' => '%s public&oacute; una entrada en el tratamiento %s',
	'river:comment:object:tratamiento' => '%s coment&oacute; en el tratamiento %s',

	// notifications
	'tratamiento:newpost' => 'Una nueva entrada de tratamiento',

	// widget
	'tratamiento:widget:description' => 'Mostrar las &uacute;ltimas entradas de tratamiento',
	'tratamiento:moretratamientos' => 'M&aacute;s entradas de tratamiento',
	'tratamiento:numbertodisplay' => 'Cantidad de entradas de tratamiento a mostrar',
	'tratamiento:notratamientos' => 'No hay entradas de tratamiento'
);

add_translation('es', $spahish);
