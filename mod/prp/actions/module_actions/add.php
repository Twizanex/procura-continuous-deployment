<?php
/**
 * module_actions/add
 * registra una acción de un módulo
 */


// Recuperamos los datos del formulario
$module_name = get_input('module_name');
$action_name = get_input('action_name');
$action_title = get_input('action_title');

// registramos la acción del módulo
$result = prp_register_module_action($module_name, $action_name, $action_title);

if (!$result) {
    register_error(elgg_echo('prp:actions:module_actions:add:error'));
} else {
    system_message(elgg_echo('prp:actions:module_actions:add:ok'));
}

// comprobamos si tenemos una página de redireccion
$url_to_forward = get_input('url_to_forward');
if ($url_to_forward === NULL) {
    forward(REFERER);
} else {
    forward($url_to_forward);
}

