<?php
    include('../modulos/conexion.php');

    $sql = "SELECT `id`, `estado`, `nombre_del_proyecto`, `fecha_modificacion` FROM `anexo_iv` WHERE estado = 1";
    $anexoiv = mysqli_query($conexion, $sql);

    echo '<select id="salida" class="form-control">';
    while ($resp = mysqli_fetch_assoc($anexoiv)) {
        echo '<option value='.$resp['id'].'>'.$resp['nombre_del_proyecto'].'</option>';
    };
    echo '</select>'; 
?>