<?php

/*
 * Listado de relaciones.
 * El administrador indicará a qué usuarios con la 'relacion' seleccionada aquí, se
 * enviará una notificación cuando al usuario con el perfil elegido se le envíe una notificación.
 * Ejemplo:
 * Al usuario X(paciente) se le envía una notificación
 * Aquí se selecciona que cada vez que a un usuario (paciente) se le envíe una
 * notificación, se le enviará a todos los familiar-paciente
 * Al usuario Y(familiar-paciente de X) también se le enviará la notificación.
 */




/*
 * Se encapsulan las opciones del menú dentro de otro array denominado 'menu' para distinguir
 * fácilmente qué parámetros estamos personalizando en el envío.
 */
$lista_relaciones = prp_get_relation_names();
?>

<div class="elgg-module elgg-module-inline elgg-module-inline-custom_index">
	<div class="elgg-head">
		<h3>
			<?php echo elgg_echo('notificaciones:admin_settings_relationships -> Usuarios que también recibirán una notificación'); ?>
		</h3>
	</div>

<?php

foreach ($lista_relaciones as $relacion){
    
    $nombre_relacion = $relacion->title;
    $id_relacion = $relacion->guid;   
    
    $vars = array ('relacion' => $relacion);
    
    //Obtener la presentación de la relacion que se va a añadir/quitar
    $div_relacion = elgg_view("object/relationship_setup", $vars);//Se envía la entidad 'relation' entera
    
    //Obtenemos el perfil sobre el que se va a actuar
    $perfil = get_input("perfil");

    echo "<div class='procura-menu_setup-item'>";
    if (!empty($perfil)){ //Si no se ha indicado perfil, no se pinta el <form> (no tendría sentido)
        
        //Obtener la entidad que contiene el tipo de perfil
        $options = array(
            'type' => 'object',
            'subtype' => 'custom_profile_type',
            'metadata_value' => $perfil,
        );
        $perfiles = elgg_get_entities_from_metadata($options);
        $id_perfil = $perfiles[0]->guid;
        
        // Obtenemos la lista de GUIDs de las relaciones notificadas (guardadas previamente)
        $relaciones_notificadas = procura_notifications_get_relationships_destinations($id_perfil);
        
         // Si el botón se encuentra seleccionado para ese item de menú,
         // la opción ofrecida es "Quitar"; si no, "Añadir"
        if (in_array($id_relacion, $relaciones_notificadas)){//BUSCAR UN ELEMENTO DENTRO DE UN ARRAY
            $action = "action/procura_notifications/remove_notification_control";//AÚN NO DEFINIDA esta acción
            $nombre_accion = "Quitar";
        }else{
            $action = "action/procura_notifications/add_notification_control";
            $nombre_accion = "Añadir";
        }
        $form_body = elgg_view ('input/hidden', array('name' => 'perfil', 'value' => $id_perfil)); //Perfil elegido
        $form_body .= elgg_view ('input/hidden', array('name' => 'relationship', 'value' => $id_relacion)); //Relacion notificada
             
          

        $form_body .= elgg_view ('input/submit', array ('name' => 'submit','value' => $nombre_accion));
        echo elgg_view ('input/form', array ('body' => $form_body, 'action' => $action));
         
    }
    echo $div_relacion;
}

?>
</div>
</div>


