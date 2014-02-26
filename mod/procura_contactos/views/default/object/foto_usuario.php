<?php

/*
 * Imagen de un contacto y redirección a la acción de añadir amigo, si procede
 */
?>
<?php
    $individuo = $vars['usuario'];    
    $url_contacto = $vars['url_contacto']; 
    $img_usuario = $individuo->getIconURL($size='medium');     
    $conectados = $vars['conectados'];
    // Según sea contacto o no, se mostrará un título u otro
    //$title = $es_contacto?$individuo->name:"Añadir a la Agenda de Contactos";
    // Siempre el nombre del usuario
    $title = $individuo->name;
?>    

<li> 
    <div class='procura-contacto '>    
        <?php if ($conectados == 2){ ?>
        <a href='#'> 
        <?php } else{?>
             <a href='<?php echo $url_contacto?>'> 
         <?php }?>
            <p><?php echo $individuo->name?></p>                 
            <img class='elgg-avatar-medium' src='<?php echo $img_usuario?>' title='<?php echo $title?>' alt='<?php echo $individuo->name?>'/>            
        </a>              
     </div>  
    
     <?php            
     // El botón sólo aparecerá si el usuario no tiene contacto con el logueado
        if ($conectados == 2){
            echo elgg_view('output/url', array(
			'href' => $url_contacto,
			'text' => elgg_echo('contactos:add:friend'),
                        'class' => 'elgg-button elgg-button-action',
			'is_trusted' => true,
                    ));
         }
      ?>
</li>
