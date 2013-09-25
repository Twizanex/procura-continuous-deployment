
<div id="procura-index" class="procura-index" onmousemove="elgg.custom_index.restaurarTiempo()">
    <div class="procura-content-grid">
<?php
$i = 0; //tal vez sea util para posicionar las opciones del menú
$flotar = '';
/*
 * Ya no se hace así:
foreach ($vars['menu'] as $nombre=>$valor){
    $flotar = posicionar_boton_menu($i);
    $vars = array ('menu_item' => array ('nombre'=>$nombre, 'valor' => $valor, 'posicion' => $i,'flotar'=>$flotar));
    echo elgg_view("object/menu_item", $vars);
    $i++;
}
 */



foreach ($vars['menu'] as $menu_items){
    $nombre = $menu_items["nombre"];
    $valor = $menu_items["url"];
    $flotar = posicionar_boton_menu($i);
    $vars = array ('menu_item' => array ('nombre'=>$nombre, 'valor' => $valor, 'posicion' => $i,'flotar'=>$flotar));
    echo elgg_view("object/menu_item", $vars);
    $i++;
}

?>
    </div>
</div>