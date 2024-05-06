<?php
    include ('../modulos/conexion.php');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT * FROM `anexoiv` WHERE 1";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        echo '<select name="select_viaje" class="form-control-sm border-primary">
                <option value=""></option>';
        while ($fila = $resultado->fetch_assoc()) {
            echo
            '<option value="' . $fila['id'] . '">' . $fila['nombre_del_proyecto'] . '</option>';
        }
        echo '</select>';
    } else {
        echo "No se encontraron lugares en la base de datos.";
    }
    $conexion->close();
?>