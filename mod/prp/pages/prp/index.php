<?php

/*
 * prp/index
 * Página de entrada principal del módulo, a efectos de pruebas del módulo
 */

// establecemos el contexto a prp (aunque posiblemente no lo usemos)
elgg_set_context('prp');

$title = elgg_echo('prp:pages:index:title');
$content = elgg_view_title($title);

// preparamos los enlaces a las distintas páginas
$prp_links = array(
    'admin/relation_names',
    'admin/module_actions',
    'admin/profile_permissions',
    'test/relations',
    'test/module_actions',
    'test/profile_permissions',
    'forms/relation_name',
    'forms/relation',
    'forms/module_action',
    'forms/add_module_action',
    'forms/profile_permission',
);

$base_url = elgg_get_site_url();
foreach ($prp_links as $link) {
    $link_options = array(
        'text' => $link,
        'href' => $base_url . "prp/$link",
    );
    $content .= elgg_view('output/url',$link_options);
    $content .= "<br/>";
    
}

// use special admin layout
$body = elgg_view_layout('one_colum', array('content' => $content));
echo elgg_view_page($title, $body);

