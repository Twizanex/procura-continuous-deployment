<?php
/**
 * module_actions/export
 * Exporta las acciones de modulos definidas a un fichero
 */

// generamos la salida como un fichero
header("Content-Type: text/plain");
header('Content-Disposition: attachment; filename="module_actions.backup.json.txt"');

// recuperamos las acciones de modulo
$json = prp_get_module_actions_json();

// lo escribimos al fichero
echo $json;
exit();