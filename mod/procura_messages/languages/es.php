<?php
/**
 * Elgg send a message action page
 *
 * Traducido al español por Davod
 * 
 * @package ElggMessages
 */
$spanish = array(
	/**
	* Menu items and titles
	*/
        'procura_messages' => 'Correo electrónico', //Nombre del menu_item
	'messages' => "Mensajes",
	'messages:unreadcount' => "%s no leidos",
	'messages:back' => "regresar a los mensajes",
	'messages:user' => "Bandeja de entrada de %s",
	'messages:posttitle' => "Mensajes de %s: %s",
	'messages:inbox' => "Bandeja de entrada",
	'messages:send' => "Enviar",
	'messages:sent' => "Enviado",
	'messages:message' => "Mensaje",
	'messages:title' => "Asunto",
	'messages:to' => "Para",
	'messages:from' => "De",
	'messages:fly' => "Enviado",
	'messages:replying' => "Mensaje respondiendo a",
	'messages:sendmessage' => "Enviar un mensaje",
	'messages:compose' => "Escribir un mensaje",
	'messages:add' => "Escribir un mensaje",
	'messages:sentmessages' => "Mensajes enviados",
	'messages:recent' => "Mensajes recientes",
	'messages:original' => "Mensaje original",
	'messages:yours' => "Tu mensaje",
	'messages:answer' => "Respuesta",
	'messages:toggle' => 'Activar/desactivar todos',
	'messages:markread' => 'Marcar como leido',
	'messages:recipient' => 'Selecciona un receptor&hellip;',
	'messages:to_user' => 'para: %s',

	'messages:new' => 'Nuevo Mensaje',

	'notification:method:site' => 'Sitio',

	'messages:error' => 'Ocurri&oacute; un problema al guardar el mensaje. Por favor intenta de nuevo.',

	'item:object:messages' => 'Mensajes',     
        'procura_messages:nombre' => 'Nombre',
        'procura_messages:fecha' => 'Fecha',
        'procura_messages:borrador' => "Guardar Borrador",
        'procura_messages:drafts' => "Borradores",
        'procura_messages:edit_draft' => "Edición de Borrador",
    
	/**
	* Status messages
	*/

	'messages:posted' => "Tu mensaje ha sido enviado.",
	'messages:success:delete:single' => 'El mensaje fue borrado',
	'messages:success:delete' => 'Mensajes borrados',
	'messages:success:read' => 'Mensaje(s) marcado(s) como leido(s)',
	'messages:error:messages_not_selected' => 'No hay mensajes seleccionados',
	'messages:error:delete:single' => 'No se puede borrar el mensaje',

	/**
	* Email messages
	*/

	'messages:email:subject' => 'Tienes un nuevo mensaje',
	'messages:email:body' => "Tienes un nuevo mensaje de %s. Leelo:

	%s

	Para ver tu mensaje, click a continuaci&oacute;n:

%s

	Para enviar un mensaje a %s, click aqu&iacute;:

	%s

	Este correo no recibe respuestas.",

	/**
	* Error messages
	*/

	'messages:blank' => "Debes escribir algo en el cuerpo del mensaje antes de guardar.",
	'messages:notfound' => "No se pudo encontrar el mensaje especificado.",
	'messages:notdeleted' => "No se pudo borrar este mensaje.",
	'messages:nopermission' => "No tienes permiso para modificar este mensaje.",
	'messages:nomessages' => "No hay mensajes.",
	'messages:user:nonexist' => "No se pudo encontrar al receptor entre los usuarios registrados.",
	'messages:user:blank' => "No has seleccionado a nadie a quien enviar el mensaje.",

	'messages:deleted_sender' => 'Usuario borrado',

);
		
add_translation("es", $spanish);
