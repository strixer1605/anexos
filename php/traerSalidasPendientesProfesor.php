<?php
    $sqlSalidasPendientes = "SELECT `idAnexoIV`, `estado`, `denominacionProyecto`, `dniEncargado`, `cargo`, `fechaModificacion` FROM `anexoiv` WHERE dniEncargado = $dni AND estado = 1";
    $resultSalida = $conexion->query($sqlSalidasPendientes);

    if ($resultSalida->num_rows > 0) {
        while ($salida = $resultSalida->fetch_assoc()) {
            echo '<li>
                    <a href="#" class="btn form-control botones w-100 mb-3" 
                       onclick="enviarValor(' . $salida['idAnexoIV'] . ')">' . 
                       $salida['denominacionProyecto'] . 
                    '</a>
                  </li>';
        }
    } else {
        echo "Error: " . $resultSalida->error;
    }

    $resultSalida->close();
    $conexion->close();
?>

<!-- Formulario oculto -->
<form id="formEnvio" method="POST" action="menuSalida.php" style="display:none;">
    <input type="hidden" name="idAnexoIV" id="idAnexoIV" value="">
</form>

<script>
    function enviarValor(idAnexoIV) {
        document.getElementById('idAnexoIV').value = idAnexoIV; // Asignar el valor al input oculto
        document.getElementById('formEnvio').submit(); // Enviar el formulario
    }
</script>
