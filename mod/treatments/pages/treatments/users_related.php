<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Recuperamos todos los usuarios de la plataforma
$users_list = elgg_get_entities(array(
    'types' => 'user',    
    'limit' => false,
));

// comprobamos permiso para cada usuario
/* @var $user ElggUser */
foreach ($users_list as $user) {
    
    $view_treatment_permission = prp_check_module_action_permissions('treatments', 
            TreatmentsModuleActions::VIEW_TREATMENT_PRESCRIPTION, array(
                'user'=>$user,
            ));    
    if ($view_treatment_permission){
        $icon = elgg_view('output/img',array(
           'title'=>$user->name,
            'src'=>$user->getIconURL('medium'),
            'href'=>"treatments/treatment_prescription/list?user_guid=$user->guid",
                ));
        $body = elgg_view('output/url',array(
           'text'=>$user->name,
            'href'=>"treatments/treatment_prescription/list?user_guid=$user->guid",
        ));
        //$content .= elgg_view("user/elements/summary", array('entity'=>$user));
        $content .= elgg_view_image_block($icon, $body);
    }
}

// mostramos la pagina
$body = elgg_view_layout('one_colum', array('content' => $content));
echo elgg_view_page('treatments:pages:users_related:title', $body);
?>
