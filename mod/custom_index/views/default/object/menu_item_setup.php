<?php

/**
 * Toma el item que hay en menu_item y extrae cada una de sus propiedades.
 * Como imagen, se toma el icono que tenga el mismo nombre que la opción de menú.
 * No genera un enlace.
 */

$nombre = $vars['menu_item']['nombre'];
$valor = $vars['menu_item']['valor'];//En la página de setup, el icono NO debe ser un enlace al módulo
$indice = $vars['menu_item']['posicion'];
$flotar = $vars['menu_item']['flotar'];
$aux_arr = explode('_', $nombre);
$icono = $aux_arr[1];
if ($icono == null){
    $icono = "indeterminado";
}
$alt = elgg_echo($nombre);
$img_url = elgg_get_site_url() . "mod/custom_index/graphics/" . $icono . ".gif";

echo "<div class='procura-menu_setup-item-container'>$alt</div>
        <div class='procura-menu_setup-item-icon-container'>
            <img class='procura-menu_setup-item-icon' src='$img_url' title='$alt' alt='$alt'/>
        </div>";
?>
