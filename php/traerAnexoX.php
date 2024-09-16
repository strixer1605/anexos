<?php
    $idSalida = $_SESSION['idSalida'] ?? null;
    include('conexion.php');

    if (isset($idSalida)) {
        $sql = "SELECT * FROM anexox WHERE fkAnexoIV = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt === false) {
            error_log('Error preparando la consulta: ' . $conexion->error);
            die('Error interno del servidor.');
        }

        $stmt->bind_param('i', $idSalida);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } 

            echo '
                <div class="mb-5">
                    <label for="infraestructura" class="form-label">Infraestructura disponible:</label>
                    <textarea type="text" class="form-control" id="infraestructura" name="infraestructura" placeholder="Ingrese la infraestructura disponible" value="'.htmlspecialchars($row['infraestructuraDisponible'], ENT_QUOTES, 'UTF-8').'" required></textarea>
                </div>
                <div class="mb-5">
                    <label for="hospitales" class="form-label">Hospitales disponibles:</label>
                    <textarea type="text" class="form-control" id="hospitales" name="hospitales" placeholder="Ingrese los hospitales disponibles" value="'.htmlspecialchars($row['hospitalesDisponibles'], ENT_QUOTES, 'UTF-8').'" required></textarea>
                </div>
                <div class="mb-5">
                    <label for="mediosAlternativos" class="form-label">Medios alternativos:</label>
                    <textarea type="text" class="form-control" id="mediosAlternativos" name="mediosAlternativos" placeholder="Ingrese los medios alternativos" value="'.htmlspecialchars($row['mediosAlternativos'], ENT_QUOTES, 'UTF-8').'" required></textarea>
                </div>
                <div class="mb-5">
                    <label for="datosOpcionales" class="form-label">Datos opcionales:</label>
                    <textarea type="text" class="form-control" id="datosOpcionales" name="datosOpcionales" placeholder="Ingrese los datos opcionales" value="'.htmlspecialchars($row['datosOpcionales'], ENT_QUOTES, 'UTF-8').'" required></textarea>
                </div>
            ';
        } else {
            error_log('Error al ejecutar la consulta: ' . $stmt->error);
            die('Error interno del servidor.');
        }

        $stmt->close();
        $conexion->close();
    } else {
        die('Error: idSalida no está definido.');
    }
?>