<?php
    $idSalida = $_SESSION['idSalida'] ?? null;
    include('conexion.php');

    if (isset($idSalida)) {
        $sql = "SELECT * FROM anexoviii WHERE fkAnexoIV = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt === false) {
            error_log('Error preparando la consulta: ' . $conexion->error);
            die('Error interno del servidor.');
        }

        $stmt->bind_param('i', $idSalida);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Escape the values before outputting them
            $nombreDoc = htmlspecialchars($_SESSION['nombreDoc'], ENT_QUOTES, 'UTF-8');
            $apellidoDoc = htmlspecialchars($_SESSION['apellidoDoc'], ENT_QUOTES, 'UTF-8');

            echo '
                <div class="mb-5">
                    <label for="institucion" class="form-label">Institución Educativa:</label>
                    <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Ingrese Institución" value="'.$row['institucion'].'" required pattern="[A-Za-z\s]+">
                </div>
                <div class="mb-5">
                    <label for="anio" class="form-label">Año:</label>
                    <input type="number" class="form-control" id="anio" name="anio" placeholder="Ingrese Año" required value="'.$row['año'].'">
                </div>
                <div class="mb-5">
                    <label for="division" class="form-label">División:</label>
                    <input type="text" class="form-control" id="division" name="division" placeholder="Ingrese División" value="'.$row['division'].'" required>
                </div>
                <div class="mb-5">
                    <label for="area" class="form-label">Área:</label>
                    <input type="text" class="form-control" id="area" name="area" placeholder="Ingrese Área" value="Programacion" required>
                </div>
                <div class="mb-5">
                    <label for="docente" class="form-label">Docente:</label>
                    <input type="text" class="form-control" id="docente" name="docente" placeholder="Ingrese Docente" value="' . $nombreDoc . ' ' . $apellidoDoc . '" required>
                </div>
                <div class="mb-5">
                    <label for="objetivo" class="form-label">Objetivo:</label>
                    <input type="text" class="form-control" id="objetivo" name="objetivo" placeholder="Ingrese Objetivo" value="'.$row['objetivo'].'" required>
                </div>
                <div class="mb-5">
                    <label for="fechaSalida" class="form-label">Fecha de la Salida:</label>
                    <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" value="'.$row['fechaSalida'].'" required>
                </div>
                <div class="mb-5">
                    <label for="lugaresVisitar" class="form-label">Lugares a visitar:</label>
                    <input type="text" class="form-control" id="lugaresVisitar" name="lugaresVisitar" placeholder="Ingrese Lugares" value="'.$row['lugaresVisitar'].'" required>
                </div>
                <div class="mb-5">
                    <label for="descPrevia" class="form-label">Descripción previa:</label>
                    <input type="text" class="form-control" id="descPrevia" name="descPrevia" placeholder="Ingrese Descripción" value="'.$row['descripcionPrevias'].'" required>
                </div>
                <div class="mb-5">
                    <label for="respPrevia" class="form-label"A>Responsables (Previamente):</label>
                    <input type="text" class="form-control" id="respPrevia" name="respPrevia" placeholder="Ingrese Responsables" value="'.$row['responsablesPrevias'].'" required>
                </div>
                <div class="mb-5">
                    <label for="obsPrevia" class="form-label">Observaciones (Previamente):</label>
                    <input type="text" class="form-control" id="obsPrevia" name="obsPrevia" placeholder="Ingrese Observaciones" value="'.$row['observacionesPrevias'].'" required>
                </div>
                <div class="mb-5">
                    <label for="descDurante" class="form-label">Descripción (Durante):</label>
                    <input type="text" class="form-control" id="descDurante" name="descDurante" placeholder="Ingrese Descripción" value="'.$row['descripcionDurante'].'" required>
                </div>
                <div class="mb-5">
                    <label for="respDurante" class="form-label">Responsables (Durante):</label>
                    <input type="text" class="form-control" id="respDurante" name="respDurante" placeholder="Ingrese Responsables" value="'.$row['responsablesDurante'].'" required>
                </div>
                <div class="mb-5">
                    <label for="obsDurante" class="form-label">Observaciones (Durante):</label>
                    <input type="text" class="form-control" id="obsDurante" name="obsDurante" placeholder="Ingrese Observaciones" value="'.$row['observacionesDurante'].'" required>
                </div>
                <div class="mb-5">
                    <label for="descEvaluacion" class="form-label">Descripción (Evaluación):</label>
                    <input type="text" class="form-control" id="descEvaluacion" name="descEvaluacion" placeholder="Ingrese Descripción" value="'.$row['descripcionEvaluacion'].'" required>
                </div>
                <div class="mb-5">
                    <label for="respEvaluacion" class="form-label">Responsables (Evaluación):</label>
                    <input type="text" class="form-control" id="respEvaluacion" name="respEvaluacion" placeholder="Ingrese Responsables" value="'.$row['responsablesEvaluacion'].'" required>
                </div>
                <div class="mb-5">
                    <label for="obsEvaluacion" class="form-label">Observaciones (Evaluación):</label>
                    <input type="text" class="form-control" id="obsEvaluacion" name="obsEvaluacion" placeholder="Ingrese Observaciones" value="'.$row['observacionesEvaluacion'].'" required>
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
