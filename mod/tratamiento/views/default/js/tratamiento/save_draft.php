<?php
/**
 * Save draft through ajax
 *
 * @package Tratamiento
 */
?>
elgg.provide('elgg.tratamiento');

/*
 * Attempt to save and update the input with the guid.
 */
elgg.tratamiento.saveDraftCallback = function(data, textStatus, XHR) {
	if (textStatus == 'success' && data.success == true) {
		var form = $('form[name=tratamiento_post]');

		// update the guid input element for new posts that now have a guid
		form.find('input[name=guid]').val(data.guid);

		oldDescription = form.find('textarea[name=description]').val();

		var d = new Date();
		var mins = d.getMinutes() + '';
		if (mins.length == 1) {
			mins = '0' + mins;
		}
		$(".tratamiento-save-status-time").html(d.toLocaleDateString() + " @ " + d.getHours() + ":" + mins);
	} else {
		$(".tratamiento-save-status-time").html(elgg.echo('error'));
	}
};

elgg.tratamiento.saveDraft = function() {
	if (typeof(tinyMCE) != 'undefined') {
		tinyMCE.triggerSave();
	}

	// only save on changed content
	var form = $('form[name=tratamiento_post]');
	var description = form.find('textarea[name=description]').val();
	var title = form.find('input[name=title]').val();

	if (!(description && title) || (description == oldDescription)) {
		return false;
	}

	var draftURL = elgg.config.wwwroot + "action/tratamiento/auto_save_revision";
	var postData = form.serializeArray();

	// force draft status
	$(postData).each(function(i, e) {
		if (e.name == 'status') {
			e.value = 'draft';
		}
	});

	$.post(draftURL, postData, elgg.tratamiento.saveDraftCallback, 'json');
};

elgg.tratamiento.init = function() {
	// get a copy of the body to compare for auto save
	oldDescription = $('form[name=tratamiento_post]').find('textarea[name=description]').val();
	
	setInterval(elgg.tratamiento.saveDraft, 60000);
};

elgg.register_hook_handler('init', 'system', elgg.tratamiento.init);