<?php
/**
 * informacion sidebar menu showing revisions
 *
 * @package informacion
 */

//If editing a post, show the previous revisions and drafts.
$informacion = elgg_extract('entity', $vars, FALSE);

if (elgg_instanceof($informacion, 'object', 'informacion') && $informacion->canEdit()) {
	$owner = $informacion->getOwnerEntity();
	$revisions = array();

	$auto_save_annotations = $informacion->getAnnotations('informacion_auto_save', 1);
	if ($auto_save_annotations) {
		$revisions[] = $auto_save_annotations[0];
	}

	// count(FALSE) == 1!  AHHH!!!
	$saved_revisions = $informacion->getAnnotations('informacion_revision', 10, 0, 'time_created DESC');
	if ($saved_revisions) {
		$revision_count = count($saved_revisions);
	} else {
		$revision_count = 0;
	}

	$revisions = array_merge($revisions, $saved_revisions);

	if ($revisions) {
		$title = elgg_echo('informacion:revisions');

		$n = count($revisions);
		$body = '<ul class="informacion-revisions">';

		$load_base_url = "informacion/edit/{$informacion->getGUID()}";

		// show the "published revision"
		if ($informacion->status == 'published') {
			$load = elgg_view('output/url', array(
				'href' => $load_base_url,
				'text' => elgg_echo('informacion:status:published'),
				'is_trusted' => true,
			));

			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($informacion->time_created) . "</span>";

			$body .= "<li>$load : $time</li>";
		}

		foreach ($revisions as $revision) {
			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($revision->time_created) . "</span>";

			if ($revision->name == 'informacion_auto_save') {
				$revision_lang = elgg_echo('informacion:auto_saved_revision');
			} else {
				$revision_lang = elgg_echo('informacion:revision') . " $n";
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