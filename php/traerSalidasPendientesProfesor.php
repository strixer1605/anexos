<?php
    $sqlSalidasPendientes = "SELECT `idAnexoIV`, `estado`, `denominacionProyecto`, `dniEncargado`, `cargo`, `fechaModificacion` FROM `anexoiv` WHERE dniEncargado = $dni AND estado = 1";
    $resultSalida = $conexion->query($sqlSalidasPendientes);

    if ($resultSalida->num_rows > 0) {
        $salida = $resultSalida->fetch_assoc();
        echo '<li><a class="btn form-control botones w-100 mb-3" href="menuSalida.php?salida='.$salida['idAnexoIV'].'">'.$salida['denominacionProyecto'].'</a></li>';
    } else {
        echo "Error: " . $resultSalida->error;
    }

    $resultSalida->close();
    $conexion->close();
?>