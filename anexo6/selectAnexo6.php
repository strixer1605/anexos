<?php
    include ('../modulos/conexion.php');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT * FROM `anexo_iv`";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        echo '<select name="select_viaje" id="select_viaje" class="form-control-sm border-primary" onchange="actualizarInfo()">';
        echo '<option value=""></option>';
        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '" 
                        data-lugar="' . htmlspecialchars($fila['lugar_a_visitar'], ENT_QUOTES, 'UTF-8') . '"
                        data-dia-inicio="' . htmlspecialchars($fila['fecha1'], ENT_QUOTES, 'UTF-8') . '"
                        data-dia-fin="' . htmlspecialchars($fila['fecha2'], ENT_QUOTES, 'UTF-8') . '">'
                . htmlspecialchars($fila['nombre_del_proyecto'], ENT_QUOTES, 'UTF-8') . 
                '</option>';
        }
        echo '</select>';
        echo ' , a realizarse en las localidades de <input type="text" id="localSalida" class="form-control-sm border-primary">';
        echo ' , a realizarse entre los días <input type="text" id="dia_inicio" class="form-control-sm border-primary"> y <input type="text" id="dia_fin" class="form-control-sm border-primary"> del presente ciclo lectivo.';
    } else {
        echo "No se encontraron lugares en la base de datos.";
    }
    $conexion->close();
?>

<script>
function actualizarInfo() {
    var select = document.getElementById("select_viaje");
    var localInput = document.getElementById("localSalida");
    var diaInicioInput = document.getElementById("dia_inicio");
    var diaFinInput = document.getElementById("dia_fin");

    var selectedOption = select.options[select.selectedIndex];
    
    localInput.value = selectedOption.getAttribute("data-lugar") || "";
    diaInicioInput.value = selectedOption.getAttribute("data-dia-inicio") || "";
    diaFinInput.value = selectedOption.getAttribute("data-dia-fin") || "";
}
</script>
