<?php
/**
 * Messages folder view (inbox, sent,drafts @sdrortega) 
 *
 * Provides form body for mass deleting messages
 *
 * @uses $vars['list'] List of messages
 */

echo '<div class="elgg-foot messages-buttonbank">';

// Pinta botón para la opción en la que no estemos (Buzón de entrada/mensajes enviados)
if ($vars['folder'] == "inbox") { //saber si estamos en el buzon de entrada    
    echo elgg_view('output/url', array(
			'href' => elgg_get_site_url().'procura_messages/sent',
			'text' => elgg_echo ('messages:sentmessages'),
                        'class' => 'elgg-button elgg-button-action',
			'is_trusted' => true,
                    ));
      
} else{
        echo elgg_view('output/url', array(
			'href' => elgg_get_site_url().'procura_messages/inbox',
			'text' => elgg_echo ('messages:inbox'),
                        'class' => 'elgg-button elgg-button-action',
			'is_trusted' => true,
                    ));
}

// Incluimos un botón para acceder a los borradores. Aparecerá siempre, menos cuado estemos en borradores
if ($vars['folder']!= 'drafts'){
    echo elgg_view('output/url', array(
			'href' => elgg_get_site_url().'procura_messages/drafts',
			'text' => elgg_echo ('procura_messages:drafts'),
                        'class' => 'elgg-button elgg-button-action',
			'is_trusted' => true,
                    ));
}

// Botón de "Nuevo mensaje"
echo elgg_view('output/url', array(
			'href' => elgg_get_site_url().'procura_messages/compose',
			'text' => elgg_echo('messages:new'),
                        'class' => 'elgg-button elgg-button-action',
			'is_trusted' => true,
));

$messages = $vars['list'];
if (!$messages) {
    echo '</div>';
    echo elgg_echo('messages:nomessages');
    return true;
}

// Botón para eliminar mensajes
echo elgg_view('input/submit', array(
	'value' => elgg_echo('delete'),
	'name' => 'delete',
	'class' => 'elgg-button-action',
	'title' => elgg_echo('deleteconfirm:plural'),
));

echo '</div>';

echo '<div class="messages-container">';
// Inclusión de cabecera para cada campo
echo
'<div class="messages-owner-cab">'.elgg_echo('procura_messages:nombre').'</div> 
<div class="messages-timestamp-cab">'.elgg_echo('procura_messages:fecha').'</div>
<div class="messages-subject-cab">'.elgg_echo('messages:title').'</div>
<div class="messages-delete"></div>';

echo $messages;
echo '</div>';