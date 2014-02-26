<?php
/*
 * Vista del avatar del contacto
 */
    $nombre = $vars['contacto_item']['nombre'];
    $valor = $vars['contacto_item']['valor'];
    $indice = $vars['contacto_item']['posicion'];
    $flotar = $vars['contacto_item']['flotar'];
    $aux_arr = explode(':', $nombre); // POrque lo nombres aquí son del tipo men_contact:loquesea        
    $icono = $aux_arr[1];
    $alt = elgg_echo($nombre);
    $img_url = elgg_get_site_url() . "mod/procura_contactos/graphics/" . $icono . ".png";
    //procura-menu-item$flotar
    echo "<li class='linea elgg-avatar-medium '>         
            <a href='$valor'> <img class='procura-menu-item' src='$img_url' title='$alt' alt='$alt'/> </a>                         
          </li>";
?>
