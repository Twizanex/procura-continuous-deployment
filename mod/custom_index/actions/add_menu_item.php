<?php
/*
 * Crear relación entre item del menú y Perfil
 * 
 * @package custom_index
 */

// start a new sticky form session in case of failure
//elgg_make_sticky_form('menuItem'); //Innecesario

// store errors to pass along
$error = FALSE;
$forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();


// Parámetros enviados
$perfil = get_input('perfil');
$item = get_input('menu');
$url = get_input ('url');

// campos obligatorios para que se pueda guardar la entidad:
if (empty($perfil) || empty($item) || empty($url)){
    $error = elgg_echo("p_ind:add_menu_item:error");
}

//Guardar el elemento si no se ha producido ningún error
if (!$error) {

    $menuItem = new ProcuraMenuItem();
    // Algunos valores por defecto:
    $values = array(
            'title' => '',
            'description' => '',
            'status' => '1',
            'access_id' => ACCESS_PUBLIC,
            'item_name' => $item,
            'profile_asigned' => $perfil,
            'item_url' => $url,
    );    
    
    //Asignar valores al objeto menuItem
    foreach ($values as $name => $value) {
        if (FALSE === ($menuItem->$name = $value)) {
            $error = elgg_echo('p_ind:add_menu_item:error' . "$name=$value");
            register_error($error);
            forward($forward_url);
	}
    }
    
    //Y ahora guardarlo
	if ($menuItem->save()) {
            // remove sticky form entries
            //elgg_clear_sticky_form('menuItem'); //Innecesario
            
            // mensaje de éxito
            system_message(elgg_echo('p_ind:add_menu_item:exito'));
            
            forward($forward_url);
            
        }
        register_error(elgg_echo ("p_ind:add_menu_item:error"));
	forward($forward_url);
}
register_error($error);
forward($forward_url);



