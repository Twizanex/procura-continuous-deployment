<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Comprobar que el usuario tiene permiso para gestionar o visualizar 
// tratamientos, en caso contrario redirigir a la página principal del módulo, 
// desde allí se definirá qué se le muestra
if (!elgg_is_admin_logged_in()) {  // el administrador siempre tiene pemiso
    $view_treatment_permission = true;
    $manage_treatment_permission = true;
} else {
    $view_treatment_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::VIEW_TREATMENT, null);
    $manage_treatment_permission = prp_check_module_action_permissions('treatments', TreatmentsModuleActions::MANAGE_TREATMENT, null);
}
if (!($view_treatment_permission OR $manage_treatment_permission)) {
    forward('treatments/index', 'treatments:pages:prescriptor_shell:no_permission');
}

$user_guid = elgg_get_logged_in_user_guid();
// preparar botones de contenido para redirigir a cada página
$treatment_list_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:prescriptor_shell:button:treatments'),
    "title" => elgg_echo('treatments:pages:prescriptor_shell:button:treatments:title'),
    "href" => $vars["url"] . "treatments/treatment/list",
    "class" => "elgg-button elgg-button-action"));

$patient_list_button = elgg_view("output/url", array(
    "text" => elgg_echo('treatments:pages:prescriptor_shell:button:patients'),
    "title" => elgg_echo('treatments:pages:prescriptor_shell:button:patients:title'),
    "href" => $vars["url"] . "treatments/users_related/list?relation=$patient_relation&user_guid=$user_guid",
    "class" => "elgg-button elgg-button-action"));

// TODO: mejorar aspecto de los botones


$content = $treatment_list_button . $patient_list_button;

// mostramos la pagina
$body = elgg_view_layout('one_colum', array('content' => $content));
echo elgg_view_page('treatments:pages:prescriptor_shell:title', $body);
