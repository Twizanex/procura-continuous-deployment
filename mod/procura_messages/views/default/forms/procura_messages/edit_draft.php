<?php
/**
 * Compose draft form
 *
 * @package ElggMessages
 */

$message = elgg_extract('message', $vars, 0);
$message_id = $message->guid;

$recipient_guid = $message->toId;
$subject = $message->title;
$body = $message->description;
$recipients_options = array();

foreach ($vars['friends'] as $friend) {
	$recipients_options[$friend->guid] = $friend->name;
}

if (!array_key_exists($recipient_guid, $recipients_options)) {
	$recipient = get_entity($recipient_guid);
	if (elgg_instanceof($recipient, 'user')) {
		$recipients_options[$recipient_guid] = $recipient->name;
	}
}

$recipient_drop_down = elgg_view('input/dropdown', array(
	'name' => 'recipient_guid',
	'value' => $recipient_guid,
	'options_values' => $recipients_options,
));

?>
<div>
	<label><?php echo elgg_echo("messages:to"); ?>: </label>
	<?php echo $recipient_drop_down; ?>
</div>
<div>
	<label><?php echo elgg_echo("messages:title"); ?>: <br /></label>
	<?php echo elgg_view('input/text', array(
		'name' => 'subject',
		'value' => $subject,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo("messages:message"); ?>:</label>
	<?php echo elgg_view("input/longtext", array(
		'name' => 'body',
		'value' => $body,
	));
	?>
</div>

<div>
<?php echo elgg_view('input/hidden', array(
        'name' => 'message_id',
        'value' => $message_id));
?>
</div>

<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('messages:send'), 'name'=>'enviar')); ?>
        <?php echo elgg_view('input/submit', array('value' => elgg_echo('procura_messages:borrador'),'name'=>'borrador')); ?>  
</div>