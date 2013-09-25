
<style type="text/css">
.elgg-module-inline-custom_index{
    float: left;
    margin: 20px 5%;
    width: 40%;
}

.procura-menu-item{
    text-align: center;
}

.procura-menu_setup-item-icon{
    height: 3em;
}

.procura-menu_setup-item-container{
    display: inline;
}

.procura-menu_setup-item-icon-container{
    display: inline;
    position: absolute;
    margin-top: -1.5em;
    margin-left: 1em;
}

.procura-menu_setup-item{
    margin-left: 20%;
    margin-bottom: 1.5em;
    padding-top: 2em;
}
</style>

<?php
/*
 * Página de administrador, para asginar botones en el menú principal a tipos de perfil
 */


$items = elgg_view("custom_index/main_menu/items"); //lista de botones
$profiles = elgg_view("custom_index/main_menu/profiles"); //lista de perfiles
//NOOOOO: $actions = elgg_view("custom_index/main_menu/actions"); //NO HAY actions, la acción de añadir/quitar está en cada item


$page_data = "<div style='float:left;'>" . $profiles . $items . "</div>";
	
echo elgg_view("custom_index/admin/tabs", array("menu_items_selected" => true));
echo $page_data;



