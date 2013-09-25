<?php
/**
 * Tratamiento sidebar menu showing revisions
 *
 * @package Tratamiento
 */

//If editing a post, show the previous revisions and drafts.
$tratamiento = elgg_extract('entity', $vars, FALSE);

if (elgg_instanceof($tratamiento, 'object', 'tratamiento') && $tratamiento->canEdit()) {
	$owner = $tratamiento->getOwnerEntity();
	$revisions = array();

	$auto_save_annotations = $tratamiento->getAnnotations('tratamiento_auto_save', 1);
	if ($auto_save_annotations) {
		$revisions[] = $auto_save_annotations[0];
	}

	// count(FALSE) == 1!  AHHH!!!
	$saved_revisions = $tratamiento->getAnnotations('tratamiento_revision', 10, 0, 'time_created DESC');
	if ($saved_revisions) {
		$revision_count = count($saved_revisions);
	} else {
		$revision_count = 0;
	}

	$revisions = array_merge($revisions, $saved_revisions);

	if ($revisions) {
		$title = elgg_echo('tratamiento:revisions');

		$n = count($revisions);
		$body = '<ul class="tratamiento-revisions">';

		$load_base_url = "tratamiento/edit/{$tratamiento->getGUID()}";

		// show the "published revision"
		if ($tratamiento->status == 'published') {
			$load = elgg_view('output/url', array(
				'href' => $load_base_url,
				'text' => elgg_echo('tratamiento:status:published'),
				'is_trusted' => true,
			));

			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($tratamiento->time_created) . "</span>";

			$body .= "<li>$load : $time</li>";
		}

		foreach ($revisions as $revision) {
			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($revision->time_created) . "</span>";

			if ($revision->name == 'tratamiento_auto_save') {
				$revision_lang = elgg_echo('tratamiento:auto_saved_revision');
			} else {
				$revision_lang = elgg_echo('tratamiento:revision') . " $n";
			}
			$load = elgg_view('output/url', array(
				'href' => "$load_base_url/$revision->id",
				'text' => $revision_lang,
				'is_trusted' => true,
			));

			$text = "$load: $time";
			$class = 'class="auto-saved"';

			$n--;

			$body .= "<li $class>$text</li>";
		}

		$body .= '</ul>';

		echo elgg_view_module('aside', $title, $body);
	}
}