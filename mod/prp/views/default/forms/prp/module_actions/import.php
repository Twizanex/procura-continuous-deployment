<?php

/*
 * prp/module_actions/import form body
 * Formulario para importar acciones de modulo configuradas en un fichero
 */


$import_module_actions_title = elgg_echo('prp:forms:module_actions:import:title');
$import_module_actions_info = elgg_echo('prp:forms:module_actions:import:info');
    
// FICHERO
$fileupload_label = elgg_echo('prp:forms:module_actions:import:fileupload_label');
$fileupload_input =  elgg_view('input/file', array(
    'name' => 'module_actions_backup_json',
        ));

// boton upload
$upload_button = elgg_view('input/submit', array(
    'value' => elgg_echo('upload')
        ));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $vars["url"] . "admin/prp/module_actions",
        ));

// composicion del formulario
$form_body =  $url_to_forward_input_hidden ;
$form_body .= "<label>$fileupload_label</label><br/>$fileupload_input";
$form_body .= "</br>";
$form_body .= $upload_button;

?>
<div class="elgg-module elgg-module-inline" id="custom_fields_profile_type_form">
	<div class="elgg-head">
		<h3>
			<?php echo $import_module_actions_title; ?>
			<span class='custom_fields_more_info' id='more_info_import_module_actions'></span>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo $form_body; ?>
	</div>
</div>
<div class="custom_fields_more_info_text" id="text_more_info_import_module_actions"><?php echo $import_module_actions_info;?></div>

