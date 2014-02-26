<?php
/**
 * page/components/table
 * Vista personalizada para mostrar una tabla
 * 
 * @todo Mover a procura_commons
 * Utiliza:
 * - $vars['columns']: Array con los encabezados de las columnas
 * - $vars['rows']: Array con el contenido a mostrar en cada celda de cada fila
 * - $vars['class']: Clase adicional para aplicar estilo a la tabla
 * - $vars['row_classes']: Clases específicas para aplicar estilos propios a cada fila
 */

// TODO: Mover a Procura-commons o equivalente

// mostramos el encabezado
// encabezado de la tabla
$table_contents = '<thead><tr>';
foreach ($vars['columns'] as $column) {
    $table_contents .= "<th>$column</th>";
}
$table_contents .= '</tr></thead>';

// filas de la tabla
for ($i = 0; $i < count($vars['rows']); $i++) {
    $row = $vars['rows'][$i];
    // comprobamos si se han definido clases adicionales para cada fila
    if (isset($vars['row_classes'])) {
        $row_class = $vars['row_classes'][$i];
        $table_contents .= "<tr class=$row_class>";
    } else {
        $table_contents .= "<tr>";
    }
    foreach ($row as $cell) {
        $table_contents .= "<td>$cell</td>";
    }
    $table_contents .= "</tr>";
}
?>
<div class="elgg-table <?php echo $vars['class']; ?>">
    <table>
        <?php echo $table_contents; ?>
    </table>
</div>
