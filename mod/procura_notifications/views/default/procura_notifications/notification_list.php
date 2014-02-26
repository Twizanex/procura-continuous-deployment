<div id="procura-notifications" class="procura-notifications">
    <div class="procura-content-grid">
<?php

$notificaciones = $vars['notificaciones'];
$orden_fecha = $vars['orden_fecha'];
$orden_nivel = $vars['orden_nivel'];

?>
        <table class="notifications_table">
            <thead>
                <tr>
                    <td></td>
                    <td><a class='white_a' href='?orden=<?php echo $orden_fecha ?>'>Fecha <?php echo (($orden_fecha=='fecha_asc')?'▲':'▼')?></a></td>
                    <td><a class='white_a' href='?orden=<?php echo $orden_nivel ?>'>Nivel <?php echo (($orden_nivel=='nivel_asc')?'▲':'▼')?></a></td>
                    <td>Origen</td>
                    <td>Mensaje</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
<?php

foreach ($notificaciones as $notificacion){
    echo elgg_view("object/notification", array ('notificacion' => $notificacion));
}

?>
            </tbody>
        </table>
    </div>
</div>