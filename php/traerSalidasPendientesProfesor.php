<?php
    $sqlSalidasPendientes = "SELECT `idAnexoIV`, `estado`, `denominacionProyecto`, `dniEncargado`, `cargo`, `fechaModificacion` FROM `anexoiv` WHERE dniEncargado = $dni AND estado = 1";
    $resultSalida = $conexion->query($sqlSalidasPendientes);

    if ($resultSalida === false) {
        echo "Error in query: " . $conexion->error;
    } elseif ($resultSalida->num_rows > 0) {
        while ($salida = $resultSalida->fetch_assoc()) {
            echo '<li>
                    <a href="../../php/traerDatosSalida.php?idSalida=' . $salida['idAnexoIV'] . '" class="btn form-control botones w-100 mb-3" >' . 
                       $salida['denominacionProyecto'] . 
                    '</a>
                  </li>';
        }
    } else {
        echo "No hay salidas pendientes.";
    }

    $resultSalida->close();
    $conexion->close();
?>
