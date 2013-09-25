<?php

	$relation_names_selected = elgg_extract("relation_names_selected", $vars, false);
	$module_actions_selected = elgg_extract("module_actions_selected", $vars, false);

	$tabs = array (array("text" => elgg_echo("admin:prp:relation_names"), "href" => "admin/prp/relation_names", "selected" => $relation_names_selected));	
	$tabs[] = array("text" => elgg_echo("admin:prp:module_actions"), "href" => "admin/prp/module_actions", "selected" => $module_actions_selected);

	echo elgg_view("navigation/tabs", array("tabs" => $tabs));