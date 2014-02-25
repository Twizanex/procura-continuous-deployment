<?php

/**
 * Toma el item que hay en menu_item y extrae cada una de sus propiedades.
 * Como imagen, se toma el icono que tenga el mismo nombre que la opción de menú
 */

$nombre = $vars['menu_item']['nombre'];
$valor = $vars['menu_item']['valor'];
$indice = $vars['menu_item']['posicion'];
$flotar = $vars['menu_item']['flotar'];
$aux_arr = explode('_', $nombre);
$icono = $aux_arr[1];
if ($icono == null){
    $icono = "indeterminado";
}
$alt = elgg_echo($nombre);
$img_url = elgg_get_site_url() . "mod/custom_index/graphics/" . $icono . ".gif";

echo "<div class='elgg-button procura-button-menu-item procura-menu-item$flotar procura-menu-item  $indice '>        
        <a href='$valor'>
            <img class='procura-menu-item-icon' src='$img_url' title='$alt' alt='$alt'/>
        <p>$alt</p>
        </a>        
     </div>";
?>
