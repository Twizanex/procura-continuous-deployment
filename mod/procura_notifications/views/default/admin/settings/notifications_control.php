<?php

/*
 * Página de administrador, para asginar notificaciones a usuarios según su relación con el destinatario
 */

elgg_load_library('procura:notifications');

$perfiles = elgg_view("procura_notifications/admin/profiles"); //lista de perfiles
$relaciones = elgg_view("procura_notifications/admin/relationships"); //lista de relaciones
//NOOOOO: $actions = elgg_view("procura_notifications/main_menu/actions"); //NO HAY actions, la acción de añadir/quitar está en cada item


$page_data = "<div style='float:left;'>" . $perfiles . $relaciones . "</div>";
	
//echo elgg_view("custom_index/admin/tabs", array("menu_items_selected" => true));
echo $page_data;