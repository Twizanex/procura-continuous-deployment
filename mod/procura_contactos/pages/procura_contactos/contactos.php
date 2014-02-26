<?php

/*
  contactos.php
 */
$title = elgg_echo('menu:contactos');
$user = elgg_get_logged_in_user_entity();
pr_contactos_handle_breadcrum($page);

if ($page[0]=='contactos' || $page[0] =='otros'){
    if (!isset($page[1])){
        $usuario = $user;
    }else{
        $usuario = get_user_by_username($page[1]);
    }
}else{// Creo que no tiene sentido
    $usuario = get_user_by_username($page[0]);
}
$titulo = '';

if ($user != $usuario){
    // Estamos buscando los contactos de uno de mis contactos
    $titulo = elgg_echo('procura_contactos:contactos_p',array($usuario->name));
}else{
    // Buscamos los contactos del propio usuario
    $usuario = $user;
    $titulo = elgg_echo('procura_contactos:contactos');    
}

$vista = 'procura_contactos/listausuarios_por_perfil';

switch ($page[0]){
    case 'contactos': $conectados = 1;          
          break;
    case 'otros': 
        $titulo = elgg_echo('procura_contactos:otros');
        $conectados = 2;
        $vista = 'procura_contactos/no_contactos_por_perfil';
        break;  
    case 'detalle_contacto':        
         $vista = "object/menu_contactos";
        break;
    default: $conectados = 1;
            break;
}    

// Pasarle un array que tenga el título, el usuario base y si queremos los conectados o no
$mi_array = array('titulo'=>$titulo,'usuario'=>$usuario,'conectados'=>$conectados);

echo elgg_view($vista,$mi_array);
?>
