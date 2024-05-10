<?php
    include('../modulos/conexion.php');
    $sql = "SELECT * FROM `cargo` WHERE id_cargo <> ?";

    $cargo_a_ocultar = 3;

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cargo_a_ocultar);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    echo '<select id="cargo" class="form-control-sm border-primary">';
    $counter = 0;
    while ($resp = mysqli_fetch_assoc($result)) {
        $counter++;
        if ($counter == 2) {
            echo '<option value="'.$resp['id_cargo'].'" selected>'.$resp['Cargo'].'</option>';
        } else {
            echo '<option value="'.$resp['id_cargo'].'">'.$resp['Cargo'].'</option>';
        }
    }
    echo '</select>'; 

    mysqli_stmt_close($stmt);
?>
