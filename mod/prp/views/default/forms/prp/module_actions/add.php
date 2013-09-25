<?php

/*
 * prp/module_actions/add form body
 * Formulario para dar de alta una accion de modulo
 */


$action_module_title = elgg_echo('prp:forms:module_actions:add:title');
$action_module_info = elgg_echo('prp:forms:module_actions:add:info');

// ACTION_NAME
$action_name_label = elgg_echo('prp:forms:module_actions:add:action_name_label');
$action_name_input =  elgg_view('input/text', array(
    'name' => 'action_name',
        ));
// ACTION_TITLE
$action_title_label = elgg_echo('prp:forms:module_actions:add:action_title_label');
$action_title_input =  elgg_view('input/text', array(
    'name' => 'action_title',
        ));
// MODULE_NAME
$module_name_label = elgg_echo('prp:forms:module_actions:add:module_name_label');
$module_name_input =  elgg_view('input/text', array(
    'name' => 'module_name',
        ));

// boton alta
$save_button = elgg_view('input/submit', array(
    'value' => elgg_echo('add')
        ));

// botón para cancelar
$back_button = elgg_view("output/url", array(
    "text" => elgg_echo("cancel"), 
    "href" => $vars["url"] . "prp/test/module_actions", 
    "class" => "elgg-button elgg-button-action"));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $vars["url"] . "prp/test/module_actions",
        ));

// composicion del formulario
echo <<<HTML
$url_to_forward_input_hidden
<h3>$action_module_title</h3>
<div>$action_module_info</div>
<div>
    <label>$action_name_label</label><br/>
    $action_name_input
</div>    
<div>
    <label>$action_title_label</label><br/>
    $action_title_input
</div>    
<div>
    <label>$module_name_label</label><br/>
    $module_name_input
</div>    


<div class="elgg-foot">
    $save_button $back_button
</div>
HTML;

// TODO: componer valores por defecto y boton guardar en lugar de añadir
