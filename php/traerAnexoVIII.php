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
                            'area' => '',
                            'docente' => $apellidoDoc . ' ' . $nombreDoc,
                            'objetivo' => '',
                            'fechaSalida' => $rowAnexoIV['fechaSalida'],
                            'lugaresVisitar' => $rowAnexoIV['lugarVisita'],
                            'descripcionPrevias' => '',
                            'responsablesPrevias' => $apellidoDoc . ' ' . $nombreDoc . ',',
                            'observacionesPrevias' => '',
                            'descripcionDurante' => '',
                            'responsablesDurante' => $apellidoDoc . ' ' . $nombreDoc . ',',
                            'observacionesDurante' => '',
                            'descripcionEvaluacion' => '',
                            'responsablesEvaluacion' => $apellidoDoc . ' ' . $nombreDoc . ',',
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
            echo '<div class="mb-5">';
                include ("../../php/traerMaterias.php");
            echo '</div>
        
            <div class="mb-5">
                <label for="docente" class="form-label">Docente:</label>
                <input class="form-control" readonly id="docente" name="docente" value="' . htmlspecialchars($row['docente'], ENT_QUOTES, 'UTF-8') . '">
            </div>

            
            <div class="mb-5">
                <label for="fechaSalida" class="form-label">Fecha de la Salida:</label>
                <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" value="'. htmlspecialchars($row['fechaSalida'], ENT_QUOTES, 'UTF-8') .'" required readonly>
            </div>
            <div class="mb-5">
                <label for="lugaresVisitar" class="form-label">Lugares a visitar:</label>
                <input type="text" class="form-control" id="lugaresVisitar" name="lugaresVisitar" placeholder="Ingrese Lugares..." value="'. htmlspecialchars($row['lugaresVisitar'], ENT_QUOTES, 'UTF-8') .'" required readonly>
            </div>';
            include 'datosSelectAnexoVIII.php';
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
