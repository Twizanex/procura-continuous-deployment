<?php

/*
 * Muestra un objeto ElggTreatment
 */

// recuperamos el tratamiento
/* @var $treatment ElggTreatment */
$treatment = $vars['entity'];
// TODO: comprobar tipo con elgg_instace_of

// comprobamos si se trata de la vista reducida o ampliada
if ($vars['full_view']) {
    // mostramos todos los atributos
    $title = elgg_view_title($treatment->name);
    $body = elgg_view_module('treatment-description', elgg_echo('treatments:object:treatment:label:description'), $treatment->description);
    $body .= elgg_view_module('treatment-benefits', elgg_echo('treatments:object:treatment:label:benefits'), $treatment->benefits);
    $body .= elgg_view_module('treatment-instructions', elgg_echo('treatments:object:treatment:label:instructions'), $treatment->instructions);
    $body .= elgg_view_module('treatment-category', elgg_echo('treatments:object:treatment:label:category'), $treatment->category);
    $body .= elgg_view_module('treatment-level', elgg_echo('treatments:object:treatment:label:level'), $treatment->level);
    echo elgg_view_module('treatment-full-view', $title, $body);
} else {
    // mostramos una vista resumida
    $title = elgg_view_title($treatment->name);
    $body .= elgg_view_module('treatment-category', elgg_echo('treatments:object:treatment:label:category'), $treatment->category);
    $body .= elgg_view_module('treatment-level', elgg_echo('treatments:object:treatment:label:level'), $treatment->level);
    echo elgg_view_module('treatment-summary-view', $title, $body);
}

