<?php
/*
 * prp/relations/names/list
 * Vista para mostrar los tipos de relaciones admitidas, y botones para 
 * añadir/importar/exportar tipos de relaciones. Utiliza:
 * - $vars['relation_names_list']: lista de tipos de relaciones
 */

// recuperamos los tipos de relaciones
$relation_names_list = $vars['relation_names_list'];
$list_options = array(
    'show_edit_icon' => true,
    'show_delete_icon' => true,
);
$list = elgg_view_entity_list($relation_names_list, $list_options);
?>

<div class="elgg-module elgg-module-inline">
    <div class="elgg-head">
        <h3>
            <?php echo elgg_echo('prp:views:relations:names:list:title'); ?>
            <span class='custom_fields_more_info' id='more_info_relation_names_list'></span>
        </h3>
    </div>
    <div class="elgg-body" id="custom_fields_profile_types_list_custom"> 
        <?php echo $list; ?>
    </div>
</div>
<div class="custom_fields_more_info_text" id="text_more_info_relation_names_list"><?php echo elgg_echo("prp:tooltips:more_info_relation_names_list"); ?></div>