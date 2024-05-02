<?php
    include('../modulos/conexion.php');

    $sql = "SELECT * FROM `cargo` WHERE 1";
    $anexoiv = mysqli_query($conexion, $sql);

    echo '<select id="cargo" class="form-control">';
    echo '<option value="" disabled selected>Cargo</option>';
    while ($resp = mysqli_fetch_assoc($anexoiv)) {
        echo '<option value='.$resp['id_cargo'].'>'.$resp['Cargo'].'</option>';
    };
    echo '</select>'; 
?>