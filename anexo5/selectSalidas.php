<?php
    include('../modulos/conexion.php');

    $id_salida = $_GET['id'];

    $sql = "SELECT `id`, `estado`, `nombre_del_proyecto`, `fecha_modificacion` FROM `anexo_iv` WHERE id=$id_salida AND dni_encargado=$dni_encargado AND estado = 1";
    $anexoiv = mysqli_query($conexion, $sql);

    while ($resp = mysqli_fetch_assoc($anexoiv)) {
        echo '<p value='.$resp['id'].'>'.$resp['nombre_del_proyecto'].'</p>';
    };
?>