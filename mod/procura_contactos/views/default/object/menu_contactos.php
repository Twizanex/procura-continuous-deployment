
<?php
/** 
 * Pinta todas las opciones de menú para una ficha de usuario
 * eliminarmos tipoUsuario($user) y usamos la función del prp
 * Viene de detalle_contacto
 */

/********************************************************/
?>
<?php
    $user = $vars['usuario'];
    $img_usuario = $user->getIconURL($size='medium');    
?>

    <div class='procura-contacto-inner-left'>
        <a href='<?php echo elgg_get_site_url() ?>profile/<?php echo $user->username?>'>
                  <img class='elgg-avatar-medium' src='<?php echo $img_usuario?>' title='<?php echo $user->name?>' alt='<?php echo $user->name?>'/>
                  <h2><?php echo $user->name;  ?></h2>
        </a>
        <div class='procura-separador'></div>
        <div>
    <ul id='procura-contacto-menu'> 
        <?php  
        $i = 0; //tal vez sea util para posicionar las opciones del menú
        $flotar = '';           
        foreach ($vars['menu_contactos'] as $nombre=>$valor){ 
            $flotar = posicionar_boton_menu($i);
            $vars = array ('contacto_item' => array ('nombre'=>$nombre, 'valor' => $valor, 'posicion' => $i,'flotar'=>$flotar));
            echo elgg_view("object/contacto_item", $vars);
            
            $i++;
        }
        ?>
            </ul>
    </div>
    </div> 
    <div class='procura-contacto-inner-right'>
        <!-- Incluir datos del usuario y los botones corresopondientes en horizontal-->
            <?php echo "<div><p class='procura-etiquetas'>" .elgg_echo('contactos:nombre'). "</p><p class='procura-etiquetas-desc'>".$user->name."</p></div>"?>
            <?php echo "<div><p class='procura-etiquetas'>" .elgg_echo('contactos:mail'). "</p><p class='procura-etiquetas-desc'>".$user->email ."</p></div>"?>
            <?php echo "<div><p class='procura-etiquetas'>" .elgg_echo('contactos:perfil'). "</p><p class='procura-etiquetas-desc'>".prp_get_user_profile_type($user)."</p></div>"?>
            <?php
            $profile_fields = elgg_get_config('profile_fields');
            if (is_array($profile_fields) && sizeof($profile_fields) > 0) {
                foreach ($profile_fields as $shortname => $valtype) {                    
                    if ($shortname == "description") {
			// skip about me and put at bottom
			continue;
                    }
                        $value = $user->$shortname;

                    // Pintar sólo el campo extra teléfono
                    if ($shortname == "Telefono"){
                        echo "<div><p class='procura-etiquetas'>";
                        //echo elgg_echo('profile:'.$shortname.': ');
                        echo elgg_echo($shortname.': ');
                        echo "</p><p class='procura-etiquetas-desc'>";
                        if (!empty($value)) {
                           echo elgg_view("output/{$valtype}", array('value' => $user->$shortname));				
                        }
                        echo "</p></div>";
                    }
                }
            }
            
            if (!elgg_get_config('profile_custom_fields')) {
                if ($user->description) {
                      echo elgg_echo("profile:aboutme");          
                      echo elgg_view('output/longtext', array('value' => $user->description, 'class' => 'mtn'));
                }
            }
            ?>      
    </div>   
    <div class='procura-separador'></div>
    