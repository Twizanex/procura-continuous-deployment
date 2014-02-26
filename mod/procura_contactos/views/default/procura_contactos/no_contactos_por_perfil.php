<?php
/**
 * Se muestran los usuarios registrados en Procura que no tienen ningún tipo de relación con el usuario logueado.
 * Al pulsar sobre uno de los disponibles, pasará a ser "Amigo" y aparecerá en la lista de Agenda de Contactos, dentro del perfil
 * que tenga asignado.
 */
?>
<?php
// Obtengo todos los perfiles, ordenados alfabéticamente
$perfiles = pr_perfiles();
$usuario = $vars['usuario'];
$title = elgg_echo('procura_contactos:otros');
$conectados = $vars['conectados'];

// Insertamos la miga de pan correspondiente
/*
switch ($conectados) {
    case 1: elgg_push_breadcrumb(elgg_echo('procura_contactos:contactos'), elgg_get_site_url().'procura_contactos/contactos/'.$usuario->username);
        break;
    case 2: elgg_push_breadcrumb(elgg_echo('procura_contactos:otros'), elgg_get_site_url().'procura_contactos/otros/'.$usuario->username);
        break;
    default: break;
}*/            

// Lo comentamos hasta que esté refinado
pr_contactos_handle_breadcrum(array('otros'));

$content = '';
$total_contactos =0;
// Sólo tenemos los no conectados
$usuarios = array();
foreach ($perfiles as $perfil) {    
                 
    $usuarios=pr_get_users_not_conected_to_by_profile_and_id($usuario,$perfil->metadata_name);    
    
    // Sólo pintamos los perfiles que tengan contenido
    $numero_contactos = count($usuarios);    
    if ($numero_contactos>0){        
        
        //El total aparecerá en la cabecera
        $total_contactos = $total_contactos+$numero_contactos;
        
        $content = $content."<div class=procura-separador></div>
        <div class='elgg-head clearfix'>
        <h2 class='elgg-heading-main'>".$perfil->metadata_name."</h2>
        </div>";
        
        $i=0;        
        $content = $content."<div class='procura-lista-usuarios'> <ul>";        
        
        foreach ($usuarios as $individuo) {
            
            $url_contacto_aux = "action/procura_contactos/add?friend={$individuo->guid}";              
            //Añadir los tokens necesarios para la acción
            $url_contacto = elgg_add_action_tokens_to_url($url_contacto_aux);                       
            
            $vars = array('usuario'=>$individuo, 'url_contacto'=>$url_contacto,'conectados'=>$conectados);           
            $content = $content. elgg_view('object/foto_usuario', $vars);           
            $i++;            
        }
        $content = $content."</ul></div>";       
        
    } 
    
}

$title = $title.' '.$total_contactos;
// Construcción de la página completa, migas de pan incluídas
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
?>