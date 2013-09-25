<?php
/*
 * Obtenemos el usuario actualmente identificado, para saber con quién estamos trabajando.
 */
$user = elgg_get_logged_in_user_entity();


$weather = "";
//$tipoUsuario = tipoUsuario($user);//Obsoleto, usar la función del PRP de abajo
$tipoUsuario = prp_get_user_profile_type($user);

//Obtener lista de elementos de menú para el perfil actual:
$lista_menus = procura_custom_index_get_menu_items_by_profile($tipoUsuario);//funcion de este mismo módulo 
foreach ($lista_menus as $item_menu) {
    $vars[] = array ("nombre" => $item_menu->item_name, "url" => $item_menu->item_url, "alt" => $item_menu->item_name);
}

/*
 * El problema está en asignar el 'weather' sólo al paciente
 * tendrá que hacerse como un permiso de "acción" en el prp
 */
if (strtolower($tipoUsuario) == "paciente"){
    elgg_load_js('procura.custom_index');
    $weather = elgg_view("custom_index/weather");
}

/*
 * Se encapsulan las opciones del menú dentro de otro array denominado 'menu' para distinguir
 * fácilmente qué parámetros estamos personalizando en el envío.
 */
$vars = array ('menu'=>$vars);

// Pintar los menús
$body = elgg_view ("custom_index/main_menu", $vars);
$body .= $weather;
echo elgg_view_page('', $body);
