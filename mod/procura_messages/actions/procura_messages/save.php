<?php
/**
 * Fichero de acción asociado al formmulario de edición de borradores (views/default/forms/procura_messages/edit_draft.php)
 * Tendremos dos posibilidades, guardar borrador (nuevo o existente) o enviarlo (existente).
 */

// Obtenemos los valores del formulario
$subject = strip_tags(get_input('subject'));
$body = get_input('body');
$recipient_guid = get_input('recipient_guid');
$message_id = get_input('message_id');

elgg_make_sticky_form('messages');

$enviar =  false;
if (isset($_POST['enviar'])){
    $enviar = true;       
}

// Exigimos al menos el destinatario
$user = get_user($recipient_guid);
if (!$user) {
    register_error(elgg_echo("messages:user:nonexist"));
    forward("procura_messages/compose");
}
    
// Es necesario cargar la librería, puesto que parece que las acciones no pasan por el start
elgg_load_library('elgg:messages');

if ($enviar){                     
    $result = pr_messages_send_id($subject, $body, $recipient_guid, 0,  0, true, true,$message_id);
}else{                                   
    $result = pr_messages_save_con_id($subject, $body, $recipient_guid, 0,  0, false, true,$message_id);                                            
}

if (!$result) {
    register_error(elgg_echo("messages:error"));    
    forward("procura_messages/edit_draft/".$message_id);
}
    
elgg_clear_sticky_form('messages');         
forward('procura_messages/drafts/' . elgg_get_logged_in_user_entity()->username);
?>
