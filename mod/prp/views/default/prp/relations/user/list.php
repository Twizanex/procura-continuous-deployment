<?php

/*
 * prp/relations/users/list
 * Vista para mostrar las relaciones que tiene establecidas cada usuario con otros usuarios
 * - $vars['user']: usuario para mostrar sus relaciones
 * - $vars['user_relations_list']: lista de relaciones del usuario
 */

// recuperamos el usuario y sus relaciones
$user = $vars['user'];
$user_relations_list = $vars['user_relations_list'];

// preparamos la vista
$list = "";
foreach ($user_relations_list as $user_relation) {

    /* @var $related_user ElggUser */
    $related_user =  $user_relation['related_user'];
    $relation_name = $user_relation['relation_name'];
    
    $relation_name_label = prp_get_selected_relations_labels($relation_name->name);
    $list .= "<div>$related_user->name: $relation_name_label ";
    $list .= '<span class="elgg-icon elgg-icon-delete" title="'
            . elgg_echo('delete') . '" onclick="prpDeleteRelation(\'' 
            . $user->guid .'\', \'' . $related_user->guid .'\', \'' . $relation_name->name 
            . '\');"></span></div>';    
} 


?>

<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<h4>
			<?php echo elgg_echo('prp:views:relations:user:list:title', array($user->name)); ?>
		</h4>
	</div>
    <div class="elgg-body"> 
		<?php echo $list; ?>
	</div>
</div>
