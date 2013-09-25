<?php

/*
 * prp/relations/add form body
 * Formulario para componer las características de una relacion entre dos usuarios
 */


// recuperamos el usuario
$subject_user = $vars['subject_user'];

$relation_title = elgg_echo('prp:forms:relations:add:title', array($subject_user->name));
$relation_info = elgg_echo('prp:forms:relations:add:info');

// comprobamos usuario que establece la relacion
$user = elgg_get_logged_in_user_entity();
$is_admin = elgg_is_admin_user($user->guid);
$user_profile = prp_get_user_profile_type($user);

// USUARIO SUBJECT
// campo oculto para el usuario subject
$subject_user_input_hidden = elgg_view('input/hidden', array(
    'name' => 'subject_user_guid',
    'value' => $subject_user->guid,
        ));

// USUARIO OBJECT
$object_user_label = elgg_echo('prp:forms:relations:add:object_user_label');
// recuperamos los usuarios
// recuperamos los usuarios de la plataforma
$options = array(
    'type' => 'user',
    //'limit' => 10,
    //'offset' => $users_offset,
);
$object_user_list = elgg_get_entities($options);


// valores de seleccion para tipos de relaciones, en función del perfil del usuario
$user_options_values = array();
foreach ($object_user_list as $object_user) {
    /* @var $subject_user ElggUser */
    if ($subject_user->guid != $object_user->guid){
    $user_options_values["$object_user->guid"] = $object_user->name;
    }
}
// dropdown para seleccionar el usuario
$object_user_input = elgg_view('input/dropdown', array(
    'name' => 'object_user_guid',
    'options_values' => $user_options_values,
        ));


// TIPO DE RELACION
$relation_name_label = elgg_echo('prp:forms:relations:add:relation_name_label');
// recuperamos los tipos de relacion
$relation_names_list = prp_get_relation_names();

// valores de seleccion para tipos de relaciones, en función del perfil del usuario
$options_values = array();
foreach ($relation_names_list as $relation_name) {
    /* @var $relation_name ElggPRPRelationName */
    // comprobamos perfiles admitidos
    if (($is_admin) | in_array($user_profile, $relation_name->allowed_profiles)) {
        $options_values["$relation_name->name"] = $relation_name->title;
    }
}
// dropdown para seleccionar el tipo de relacion
$relation_name_input = elgg_view('input/dropdown', array(
    'name' => 'relation_name',
    'options_values' => $options_values,
        ));


$button = elgg_view('input/submit', array(
    'value' => elgg_echo('add')
        ));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $vars["url"] . "prp/test/relations",
        ));
// composicion del formulario
echo <<<HTML
$subject_user_input_hidden
$url_to_forward_input_hidden 
<h3>$relation_title</h3>
<div>$relation_info</div>
<div>
    <label>$object_user_label</label><br/>
    $object_user_input
</div>    
<div>
    <label>$relation_name_label</label><br/>
    $relation_name_input
</div>    


<div class="elgg-foot">
    $button
</div>
HTML;

// TODO: componer valores por defecto y boton guardar en lugar de añadir
