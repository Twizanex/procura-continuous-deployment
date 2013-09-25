<?php
/**
 * relations/names/export
 * Exporta los tipos de relacion definidos a un fichero
 */

// generamos la salida como un fichero
header("Content-Type: text/plain");
header('Content-Disposition: attachment; filename="relation_names_backup.json.txt"');

// recuperamos los tipos de relaciones
$json = prp_get_relation_names_json();

// lo escribimos al fichero
echo $json;
exit();