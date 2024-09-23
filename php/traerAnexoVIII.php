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

            $nombreDoc = htmlspecialchars($_SESSION['nombreDoc'], ENT_QUOTES, 'UTF-8');
            $apellidoDoc = htmlspecialchars($_SESSION['apellidoDoc'], ENT_QUOTES, 'UTF-8');

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                $sqlAnexoIV = "SELECT * FROM anexoiv WHERE idAnexoIV = ?";
                $stmtAnexoIV = $conexion->prepare($sqlAnexoIV);

                if ($stmtAnexoIV === false) {
                    error_log('Error preparando la consulta 2: ' . $conexion->error);
                    die('Error interno del servidor.');
                }

                $stmtAnexoIV->bind_param('i', $idSalida);

                if ($stmtAnexoIV->execute()) {
                    $resultAnexoIV = $stmtAnexoIV->get_result();
                    if ($resultAnexoIV->num_rows > 0) {
                        $rowAnexoIV = $resultAnexoIV->fetch_assoc();
                        $row = [
                            'institucion' => $rowAnexoIV['institucionEducativa'] . ' ' . $rowAnexoIV['numeroInstitucion'],
                            'año' => '',
                            'division' => '',
                            'area' => 'Ninguna',
                            'docente' => $nombreDoc . ' ' . $apellidoDoc,
                            'objetivo' => '',
                            'fechaSalida' => $rowAnexoIV['fechaSalida'],
                            'lugaresVisitar' => $rowAnexoIV['lugarVisita'],
                            'descripcionPrevias' => '',
                            'responsablesPrevias' => $nombreDoc . ' ' . $apellidoDoc,
                            'observacionesPrevias' => '',
                            'descripcionDurante' => '',
                            'responsablesDurante' => $nombreDoc . ' ' . $apellidoDoc,
                            'observacionesDurante' => '',
                            'descripcionEvaluacion' => '',
                            'responsablesEvaluacion' => $nombreDoc . ' ' . $apellidoDoc,
                            'observacionesEvaluacion' => ''
                        ];
                        
                    } else {
                        die('Error: No se encontraron registros ni en anexoviii ni en anexoiv.');
                    }
                } else {
                    error_log('Error al ejecutar la consulta anexoiv: ' . $stmtAnexoIV->error);
                    die('Error interno del servidor.');
                }
                $stmtAnexoIV->close();
            }

            echo '
            <div class="mb-5">
                <label for="institucion" class="form-label">Institución Educativa:</label>
                <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Ingrese Institución..." value="'. htmlspecialchars($row['institucion'], ENT_QUOTES, 'UTF-8') .'" required pattern="[A-Za-z\s]+" readonly>
            </div>';
            include ('../../php/traerCursos.php');
            echo '<div class="mb-5">
                <label for="area" class="form-label">Área:</label>
                <select class="form-select" id="area" name="area" required>
                    <option disabled value="' .htmlspecialchars($row['area'], ENT_QUOTES, 'UTF-8'). '"selected>'. htmlspecialchars($row['area'], ENT_QUOTES, 'UTF-8') .'</option>
                    <option value="Biología">Biología</option>
                    <option value="Fisicoquímica">Fisicoquímica</option>
                    <option value="Lengua y Literatura">Lengua y Literatura</option>
                    <option value="Historia">Historia</option>
                    <option value="Geografía">Geografía</option>
                    <option value="Matemáticas">Matemáticas</option>
                    <option value="Educación Física">Educación Física</option>
                    <option value="Arte">Arte</option>
                    <option value="Programación">Programación</option>
                    <option value="Construcción">Construcción</option>
                    <option value="Turismo">Turismo</option>
                    <option value="Turismo">Múltiples Áreas</option>
                </select>
                <p style="margin-top: 5px; margin-left: 2px;">Nota: Si no selecciona nada, el área quedará en "Ninguna"</p>
            </div>
            <div class="mb-5">
                <label for="docente" class="form-label">Docente:</label>
                <input type="text" class="form-control" id="docente" name="docente" placeholder="Ingrese Docente..." value="'. htmlspecialchars($row['docente'], ENT_QUOTES, 'UTF-8') .'" required pattern="[A-Za-z\s]+" title="Solo se permiten letras en este campo.">
            </div>
            <div class="mb-5">
                <label for="objetivo" class="form-label">Objetivo:</label>
                <input type="text" class="form-control" id="objetivo" name="objetivo" placeholder="Ingrese Objetivo..." value="'. htmlspecialchars($row['objetivo'], ENT_QUOTES, 'UTF-8') .'" required>
            </div>
            <div class="mb-5">
                <label for="fechaSalida" class="form-label">Fecha de la Salida:</label>
                <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" value="'. htmlspecialchars($row['fechaSalida'], ENT_QUOTES, 'UTF-8') .'" required readonly>
            </div>
            <div class="mb-5">
                <label for="lugaresVisitar" class="form-label">Lugares a visitar:</label>
                <input type="text" class="form-control" id="lugaresVisitar" name="lugaresVisitar" placeholder="Ingrese Lugares..." value="'. htmlspecialchars($row['lugaresVisitar'], ENT_QUOTES, 'UTF-8') .'" required>
            </div>
            <div class="mb-5">
                <label for="descPrevia" class="form-label">Descripción previa:</label>
                <textarea class="form-control" id="descPrevia" name="descPrevia" placeholder="Ingrese Descripción..." required>'. htmlspecialchars($row['descripcionPrevias'], ENT_QUOTES, 'UTF-8') .'</textarea>
            </div>
            <div class="mb-5">
                <label for="respPrevia" class="form-label">Responsables (Previamente):</label>
                <textarea class="form-control" id="respPrevia" name="respPrevia" placeholder="Ingrese Responsables..." required>'. htmlspecialchars($row['responsablesPrevias'], ENT_QUOTES, 'UTF-8') .'</textarea>
                <p style="margin-top: 5px; margin-left: 2px;">Nota: Para ingresar otro docente, debe separarlo por comas.</p>    
            </div>
            <div class="mb-5">
                <label for="obsPrevia" class="form-label">Observaciones (Previamente):</label>
                <textarea class="form-control" id="obsPrevia" name="obsPrevia" placeholder="Ingrese Observaciones..." required>'. htmlspecialchars($row['observacionesPrevias'], ENT_QUOTES, 'UTF-8') .'</textarea>
            </div>
            <div class="mb-5">
                <label for="descDurante" class="form-label">Descripción (Durante):</label>
                <textarea class="form-control" id="descDurante" name="descDurante" placeholder="Ingrese Descripción..." required>'. htmlspecialchars($row['descripcionDurante'], ENT_QUOTES, 'UTF-8') .'</textarea>
            </div>
            <div class="mb-5">
                <label for="respDurante" class="form-label">Responsables (Durante):</label>
                <textarea class="form-control" id="respDurante" name="respDurante" placeholder="Ingrese Responsables..." required>'. htmlspecialchars($row['responsablesDurante'], ENT_QUOTES, 'UTF-8') .'</textarea>
                <p style="margin-top: 5px; margin-left: 2px;">Nota: Para ingresar otro docente, debe separarlo por comas.</p>    
            </div>
            <div class="mb-5">
                <label for="obsDurante" class="form-label">Observaciones (Durante):</label>
                <textarea class="form-control" id="obsDurante" name="obsDurante" placeholder="Ingrese Observaciones..." required>'. htmlspecialchars($row['observacionesDurante'], ENT_QUOTES, 'UTF-8') .'</textarea>
            </div>
            <div class="mb-5">
                <label for="descEvaluacion" class="form-label">Descripción (Evaluación):</label>
                <textarea class="form-control" id="descEvaluacion" name="descEvaluacion" placeholder="Ingrese Descripción..." required>'. htmlspecialchars($row['descripcionEvaluacion'], ENT_QUOTES, 'UTF-8') .'</textarea>
            </div>
            <div class="mb-5">
                <label for="respEvaluacion" class="form-label">Responsables (Evaluación):</label>
                <textarea class="form-control" id="respEvaluacion" name="respEvaluacion" placeholder="Ingrese Responsables..." required>' . htmlspecialchars($row['responsablesEvaluacion'], ENT_QUOTES, 'UTF-8') .'</textarea>
                <p style="margin-top: 5px; margin-left: 2px;">Nota: Para ingresar otro docente, debe separarlo por comas.</p>    
            </div>
            <div class="mb-5">
                <label for="obsEvaluacion" class="form-label">Observaciones (Evaluación):</label>
                <textarea class="form-control" id="obsEvaluacion" name="obsEvaluacion" placeholder="Ingrese Observaciones" required>'. htmlspecialchars($row['observacionesEvaluacion'], ENT_QUOTES, 'UTF-8') .'</textarea>
            </div>';
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
