<?php

/*
 * Lista de perfiles de usuario a los que se va a asignar el reenvío de notificaciones.
 * La explicación con ejemplos está en views/default/procura_notifications/admin/relationships
 */

/*
 * Copypasteado de custom_index, que funcionaba bien
 */

// recuperamos la lista de custom_profiles
$options = array(
    'type' => 'object',
    'subtype' => 'custom_profile_type',
);
$profile_list = elgg_get_entities($options);
?>

<style type="text/css">
.custom_index_profile_types_list_custom{
    margin-left: 2em;
    padding: 1.7em;
}
</style>

<div class="elgg-module elgg-module-inline elgg-module-inline-custom_index">
	<div class="elgg-head">
		<h3>
			<?php echo elgg_echo('Lista de perfiles de usuario'); ?>
		</h3>
	</div>
    
    <script type="text/javascript">
        <?php
        /*
         * Se debe introducir la variable 'url' de javascript mediante PHP,
         * porque es una URL que puede cambiar según datos del servidor.
         */
        echo "var url = '" . $vars['url'] . "admin/settings/notifications_control?perfil=';";
        ?>
         /*
         * Función para redirigir el explorador a la misma página pero con el perfil seleccionado
         */
        function funcioncilla (perfil){
            url += perfil;
            window.location = url; //Redirigir la URL a una que añada el perfil seleccionado
        }
    </script>
    
	<?php
        
        //A continuación se pintan los tipos de perfil, con un radioButton para seleccionar sobre cual
        //se va a asignar el botón
        foreach ($profile_list as $profile_item){
            $profile_name = $profile_item->metadata_name;
            
            echo "<div class='elgg-body custom_index_profile_types_list_custom'
                 id='custom_index_profile_types_list_custom_" .
                    $profile_name .
                 "'>";
            if (get_input("perfil") == $profile_name){ //Si el perfil seleccionado coincide con esta opción, pintarlo como seleccionado
                $radio_button = elgg_view("input/radio", array(
                        "name" => "profile_type_select",
                        'value' => '1',
                        'checked' => TRUE,
                        "js" => "onclick='funcioncilla(\"" . $profile_name . "\");'",//ESTA FUNCIÓN SE ENCARGARÁ DE CAMBIAR LOS BOTONES MOSTRADOS PARA CADA PERFIL
                        'options' => array(
                            $profile_name => TRUE,
                    )));
            }else{
                $radio_button = elgg_view("input/radio", array(
                        "name" => "profile_type_select",
                        "js" => "onclick='funcioncilla(\"" . $profile_name . "\");'",//ESTA FUNCIÓN SE ENCARGARÁ DE CAMBIAR LOS BOTONES MOSTRADOS PARA CADA PERFIL
                        'options' => array(
                            $profile_name => $profile_name,
                    )));
            }
            echo $radio_button;
            
            echo "</div>";
        } ?>    
</div>



