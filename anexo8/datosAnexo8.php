<?php
    include('../modulos/conexion.php');

    if(isset($_GET['id'])) {
        $id_salida = $_GET['id'];
        $sql = "SELECT * FROM `anexo_iv` WHERE id = ?";

        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_salida);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            while ($resp = mysqli_fetch_assoc($result)) {
                echo '<td><input type="date" name="caja7" class="form-control" value="'.$resp['fecha1'].'"></td>';
                echo '<td><textarea name="caja8" class="form-control">'.$resp['lugar_a_visitar'].'</textarea></td>';
            }
        } else {
            echo "No se encontraron resultados.";
        }
        echo '<script>var id_salida = "' . $id_salida . '";</script>';
        mysqli_stmt_close($stmt);
    } else {
        echo "No se proporcionó un ID.";
    }
?>
