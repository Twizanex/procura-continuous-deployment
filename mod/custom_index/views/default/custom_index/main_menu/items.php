<?php

/*
 * pintar todos los items posibles del menú
 */
/*
$lista_menu_items[] = array ("nombre" => "p_ind:agenda", "url" => "event_calendar/list/" . date("o-m-d") . "/week/mine", "alt" => "p_ind:agenda");
$lista_menu_items[] = array ("nombre" => "p_ind:contactos", "url" => "#", "alt" => "p_ind:contactos");
$lista_menu_items[] = array ("nombre" => "p_ind:actividades", "url" => "#", "alt" => "p_ind:actividades");
$lista_menu_items[] = array ("nombre" => "p_ind:recursos", "url" => "#", "alt" => "p_ind:recursos");
$lista_menu_items[] = array ("nombre" => "p_ind:otros_u", "url" => "#", "alt" => "p_ind:otros_u");
$lista_menu_items[] = array ("nombre" => "p_ind:evolucion", "url" => "#", "alt" => "p_ind:evolucion");
$lista_menu_items[] = array ("nombre" => "p_ind:disciplina", "url" => "#", "alt" => "p_ind:disciplina");
$lista_menu_items[] = array ("nombre" => "p_ind:notificaciones", "url" => "#", "alt" => "p_ind:notificaciones");
$lista_menu_items[] = array ("nombre" => "p_ind:comunidad", "url" => "#", "alt" => "p_ind:comunidad");
$lista_menu_items[] = array ("nombre" => "p_ind:perfil", "url" => "#", "alt" => "p_ind:perfil");
$lista_menu_items[] = array ("nombre" => "p_ind:seleccionar_p", "url" => "#", "alt" => "p_ind:seleccionar_p");
$lista_menu_items[] = array ("nombre" => "p_ind:recetas", "url" => "#", "alt" => "p_ind:recetas");
$lista_menu_items[] = array ("nombre" => "p_ind:juegos", "url" => "#", "alt" => "p_ind:juegos");
$lista_menu_items[] = array ("nombre" => "p_ind:contactos_p", "url" => "#", "alt" => "p_ind:contactos_p");
// La referencia a otros usuarios se hará en cada menú de usuario,
// pues es algo variable según el paciente seleccionado
//$paciente = procura_get_users_by_relation($user, "pac-cui"); //NO ME GUSTA NADA ESTA definición DE RELACIONES
$lista_menu_items[] = array ("nombre" => "p_ind:agenda_p", "url" => "event_calendar/list/" . date("o-m-d") . "/week/", "alt" => "p_ind:agenda_p");
///////////////////////////
$lista_menu_items[] = array ("nombre" => "p_ind:actividades_p", "url" => "#", "alt" => "p_ind:actividades_p");
$lista_menu_items[] = array ("nombre" => "p_ind:paciente", "url" => "#", "alt" => "p_ind:paciente");
$lista_menu_items[] = array ("nombre" => "p_ind:pautas", "url" => "#", "alt" => "p_ind:pautas");
*/


$lista_menu_items = $CONFIG->menus['site']; //devuelve la lista entera de opciones del menú principal.

?>

<div class="elgg-module elgg-module-inline elgg-module-inline-custom_index">
	<div class="elgg-head">
		<h3>
			<?php echo elgg_echo('Lista de opciones del menú'); ?>
		</h3>
	</div>

<?php

/*
 * Según el usuario, se enviarán unos parámetros u otros
 * a la página /views/default/custom_index/main_menú.php
 */
//echo "En lugar de llamar a otra página, se tienen que pintar aquí mismo los botones y el botón del formulario asociado";
//echo elgg_view ("custom_index/main_menu", $vars); //NO, por la explicación de justo arriba


foreach ($lista_menu_items as $menu_items){
    
    $nombre = $menu_items->getData('name');
    $valor = $menu_items->getHref();
    $flotar = posicionar_boton_menu(0); //Innecesario
    $vars = array ('menu_item' => array ('nombre'=>$nombre, 'valor' => $valor, 'posicion' => $i,'flotar'=>$flotar));
    $boton = elgg_view("object/menu_item_setup", $vars);//Boton que sólo es el dibujo de la opción de menú
    
    
    /*
     * Obtenemos el perfil sobre el que se va a actuar
     */
    //$url = $vars['url'] . "admin/appearance/menu_items_control"; //No se utiliza
    $perfil = get_input("perfil");
    //echo "<br/>El perfil elegido es: " . $perfil; //Sólo como información durante el desarrollo

    echo "<div class='procura-menu_setup-item'>";
    if (!empty($perfil)){ //Si no se ha indicado perfil, no se pinta el <form> (no tendría sentido)
        
        // Obtenemos la lista de items de menú, pero para comparar con el actual,
        // sólo nos interesa el nombre
        $items_asignados = procura_custom_index_get_menu_items_by_profile($perfil);
        foreach ($items_asignados as $item) {
            $nombres_items_asignados[] = $item->item_name;
            if ($item->item_name == $nombre)
                $guid_menu_item = $item->guid; //Cuando aparezca la opción "Quitar",
                                            //esto indicará el GUID del elemento a eliminar
        }

         // Si el botón se encuentra seleccionado para ese item de menú,
         //  la opción ofrecida es "Quitar", y si no, "Añadir"
        if (in_array($nombre, $nombres_items_asignados)){//BUSCAR UN ELEMENTO DENTRO DE UN ARRAY
            $action = "action/custom_index/remove_menu_item";
            $nombre_accion = "Quitar";
            $form_body = elgg_view('input/hidden', array('name' => 'id_menu_item', 'value' => $guid_menu_item));
        }else{
            $action = "action/custom_index/add_menu_item";
            $nombre_accion = "Añadir";
            $form_body = elgg_view ('input/hidden', array('name' => 'perfil', 'value' => $perfil)); //Perfil asociado
            $form_body .= elgg_view ('input/hidden', array('name' => 'menu', 'value' => $nombre)); //Nombre del item
            $form_body .= elgg_view ('input/hidden', array('name' => 'url', 'value' => $valor)); //url del item
        }   

        $form_body .= elgg_view ('input/submit', array ('name' => 'submit','value' => $nombre_accion));
        echo elgg_view ('input/form', array ('body' => $form_body, 'action' => $action));
    }
    echo $boton . "</div>";
}

?>
</div>