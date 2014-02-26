<?php
/**
* Send a message action
* Redireccionando todo a procura_messages
* Modified from @package ElggMessages
*/

$subject = strip_tags(get_input('subject'));
$body = get_input('body');
$recipient_guid = get_input('recipient_guid');

// Hay que cargar la librería. Como no pasa por el start, no la encuentra
elgg_load_library('elgg:messages');

$borrador =  false;
if (isset($_POST['borrador'])){
    $borrador = true;       
}
elgg_make_sticky_form('messages');

//$reply = get_input('reply',0); // this is the guid of the message replying to

if (!$borrador){
    if (!$recipient_guid) {
        register_error(elgg_echo("messages:user:blank"));
        forward("procura_messages/compose");
    }

    $user = get_user($recipient_guid);
    if (!$user) {
        register_error(elgg_echo("messages:user:nonexist"));
        forward("procura_messages/compose");
    }

    // Make sure the message field, send to field and title are not blank
    if  (!$body || !$subject)  {
        register_error(elgg_echo("messages:blank"));
        forward("procura_messages/compose");
    }

    // Otherwise, 'send' the message     
    $result = pr_messages_send_id($subject, $body, $recipient_guid, 0,  0, true, true,0);

    if (!$result) {
        register_error(elgg_echo("messages:error"));
        forward("procura_messages/compose");
    }

    elgg_clear_sticky_form('messages');

    system_message(elgg_echo("messages:posted"));
}else{             
    // Para los borradores, exigimos que al menos, haya destinatario
    $user = get_user($recipient_guid);
    if (!$user) {
        register_error(elgg_echo("messages:user:nonexist"));
        forward("procura_messages/compose");
    }
        
    $result = pr_messages_save_con_id($subject, $body, $recipient_guid, 0,  0, false, true,0);  
    
    if (!$result) {
        register_error(elgg_echo("messages:error"));
        forward("procura_messages/compose");
    }
    
    elgg_clear_sticky_form('messages');         
    forward('procura_messages/drafts/' . elgg_get_logged_in_user_entity()->username);
}
forward('procura_messages/inbox/' . elgg_get_logged_in_user_entity()->username);
