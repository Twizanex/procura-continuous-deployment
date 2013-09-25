<?php

/*
 * prp/relations/names/import form body
 * Formulario para importar tipos de relaciones configuradas en un fichero
 */


$import_relation_names_title = elgg_echo('prp:forms:relations:names:import:title');
$import_relation_names_info = elgg_echo('prp:forms:relations:names:import:info');
    
// FICHERO
$fileupload_label = elgg_echo('prp:forms:relations:names:import:fileupload_label');
$fileupload_input =  elgg_view('input/file', array(
    'name' => 'relation_names_backup_json',
        ));

// boton upload
$upload_button = elgg_view('input/submit', array(
    'value' => elgg_echo('upload')
        ));

// campo oculto para la pagina a la que redirige la accion
$url_to_forward_input_hidden = elgg_view('input/hidden', array(
    'name' => 'url_to_forward',
    'value' => $vars["url"] . "admin/prp/relation_names",
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
			<?php echo $import_relation_names_title; ?>
			<span class='custom_fields_more_info' id='more_info_import_relation_names'></span>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo $form_body; ?>
	</div>
</div>
<div class="custom_fields_more_info_text" id="text_more_info_import_relation_names"><?php echo $import_relation_names_info;?></div>

