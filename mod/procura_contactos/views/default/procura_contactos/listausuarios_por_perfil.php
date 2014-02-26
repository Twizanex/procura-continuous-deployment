<?php
/**
 * Para cada uno de los perfiles existentes, se buscan los usuarios correspondientes
 * vars['conectados'] = 1 -> usuarios relacionados con el dado
 * vars['conectados'] = 2 -> usuarios NO relacionados con el dado
 * Se llama a la vista perfil + usuarios por cada perfil. Se concatenan todas en la misma página
 */
?>
<?php
// Obtengo todos los perfiles, ordenados alfabéticamente
$perfiles = pr_perfiles();

$usuario = $vars['usuario'];
$title = $vars['titulo'];
$conectados = $vars['conectados']; //1=conetados, 2=no conectados, 3=todos

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
pr_contactos_handle_breadcrum($page[0]);

$content = '';
$total_contactos =0;
foreach ($perfiles as $perfil) {    
    $usuarios = array();
    switch ($conectados) {
        case 1:$usuarios = pr_get_users_conected_to_by_profile($usuario,$perfil->metadata_name);  
            break;
        /*
        case 2: //$usuarios = pr_get_users_not_conected_to_by_profile($usuario,$perfil->metadata_name);                
                $usuarios = pr_get_users_not_conected_to_by_profile_and_id($usuario,$perfil->metadata_name);
                //var_dump($usuarios);
            break;
         * 
         */
        default:
            break;
    }
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
            // Sólo podremos  ir al detalle si es un contacto
            if ($conectados != 2){
                $url_contacto = elgg_get_site_url()."procura_contactos/detalle_contacto/".$individuo->username;
            }
            $vars = array('usuario'=>$individuo, 'url_contacto'=>$url_contacto,'conectados'=>$conectados);           
            $content .= elgg_view('object/foto_usuario', $vars);           
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