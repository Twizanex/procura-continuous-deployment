<?php

/*
 * test/relations
 * Muestra los usuarios y las relaciones definidas para cada usuario, permitiendo eliminarlas o dar de alta nuevas relaciones
 */

// cualquier usuario puede ver esta página
//admin_gatekeeper();
//elgg_set_context('admin');

// titulo
$title = elgg_echo('prp:pages:test:relations:title');

// contenido
$content = elgg_view_title($title);
$content .= elgg_echo('prp:pages:test:relations:info');

// comprobamos si estamos haciendo scroll de usuarios
$users_offset = get_input('users_offset', $default = 0);

// contamos el numero de usuarios (para paginacion)
$options = array(
    'type' => 'user',
    'count' => TRUE,
);
$num_users = elgg_get_entities($options);
$max_users_per_page = 5;
// recuperamos los usuarios de la plataforma
$options = array(
    'type' => 'user',
    'limit' => $max_users_per_page,
    'offset' => $users_offset,
);
$users_list = elgg_get_entities($options);

// para cada usuario, mostramos sus relaciones, junto con un botón para añadir nuevas
foreach ($users_list as $user) {
    // recuperamos las relaciones del usuario
    $user_relations_list = prp_get_user_relations($user);
    // Mostramos las relaciones del usuario
    $vars = array(
        'user' => $user,
        'user_relations_list' => $user_relations_list,
    );
    $content .= elgg_view('prp/relations/user/list', $vars);

    // añadimos un botón para añadir nuevas relaciones
    $add_relation_button = elgg_view("output/url", array(
        "text" => elgg_echo("add"),
        "href" => $vars["url"] . "prp/forms/relation?user_guid=$user->guid",
        "class" => "elgg-button elgg-button-action"));
    $content .= $add_relation_button;
    
    // añadimos un botón para eliminar todas las relaciones
    $delete_relations_button = elgg_view("output/url", array(
        "text" => elgg_echo("clear"),
        "onclick" => "prpDeleteAllRelations('$user->guid');",
        "class" => "elgg-button elgg-button-action"));
    $content .= $delete_relations_button;
}

// calculamos nevagacion
if ($num_users > $max_users_per_page) {
    $content .= "</br></br>";
    // navegacion hacia adelante
    if ($users_offset < ($num_users - $max_users_per_page)) {
        $next_offset = $users_offset + $max_users_per_page;
        $next_page_button = elgg_view("output/url", array(
            "text" => elgg_echo("next"),
            "href" => $vars["url"] . "prp/test/relations?users_offset=$next_offset",
            "class" => "elgg-button elgg-button-action"));
        $content .= $next_page_button;
    }
    if ($users_offset > 0) {
        $back_offset = $users_offset - $max_users_per_page;
        $back_page_button = elgg_view("output/url", array(
            "text" => elgg_echo("back"),
            "href" => $vars["url"] . "prp/test/relations?users_offset=$back_offset",
            "class" => "elgg-button elgg-button-action"));
        $content .= $back_page_button;
    }
}
// añadimos botones de navegacion
// Visualizacion de la pagina
$body = elgg_view_layout('one_sidebar', array('content' => $content));
//echo elgg_view_page($title, $body, 'admin');
echo elgg_view_page($title, $body);