<?php
    session_start();
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['idAnexoIV'])) {

            $idAnexoIV = $_POST['idAnexoIV'];

            // Verificar si el anexo IX está habilitado
            $sqlAnexoIXHabil = "SELECT anexoixHabil FROM anexoiv WHERE idAnexoIV = ?";
            $stmtAnexoIXHabil = $conexion->prepare($sqlAnexoIXHabil);

            if ($stmtAnexoIXHabil) {
                $stmtAnexoIXHabil->bind_param('i', $idAnexoIV);
                $stmtAnexoIXHabil->execute();
                $resultAnexoIXHabil = $stmtAnexoIXHabil->get_result();
                $anexoixHabilitado = $resultAnexoIXHabil->fetch_assoc()['anexoixHabil'];
                $stmtAnexoIXHabil->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error en la consulta de habilitación del Anexo IX.']);
                exit;
            }

            // Consultar anexos V, VIII y X (IX se revisa si está habilitado)
            $sqlAnexoV = "SELECT COUNT(*) as count FROM anexov WHERE fkAnexoIV = ?";
            $sqlAnexoVIII = "SELECT COUNT(*) as count FROM anexoviii WHERE fkAnexoIV = ?";
            $sqlAnexoIX = "SELECT COUNT(*) as count FROM anexoix WHERE fkAnexoIV = ?";
            $sqlAnexoX = "SELECT COUNT(*) as count FROM anexox WHERE fkAnexoIV = ?";

            // Preparar las consultas
            $stmtAnexoV = $conexion->prepare($sqlAnexoV);
            $stmtAnexoVIII = $conexion->prepare($sqlAnexoVIII);
            $stmtAnexoX = $conexion->prepare($sqlAnexoX);

            if ($stmtAnexoV && $stmtAnexoVIII && $stmtAnexoX) {
                // Ejecutar y verificar Anexo V
                $stmtAnexoV->bind_param('i', $idAnexoIV);
                $stmtAnexoV->execute();
                $resultAnexoV = $stmtAnexoV->get_result();
                $anexoVCompleto = $resultAnexoV->fetch_assoc()['count'] > 0;
                $stmtAnexoV->close();

                // Ejecutar y verificar Anexo VIII
                $stmtAnexoVIII->bind_param('i', $idAnexoIV);
                $stmtAnexoVIII->execute();
                $resultAnexoVIII = $stmtAnexoVIII->get_result();
                $anexoVIIICompleto = $resultAnexoVIII->fetch_assoc()['count'] > 0;
                $stmtAnexoVIII->close();

                // Ejecutar y verificar Anexo X
                $stmtAnexoX->bind_param('i', $idAnexoIV);
                $stmtAnexoX->execute();
                $resultAnexoX = $stmtAnexoX->get_result();
                $anexoXCompleto = $resultAnexoX->fetch_assoc()['count'] > 0;
                $stmtAnexoX->close();

                // Verificar Anexo IX solo si está habilitado
                if ($anexoixHabilitado == 1) {
                    $stmtAnexoIX = $conexion->prepare($sqlAnexoIX);
                    if ($stmtAnexoIX) {
                        $stmtAnexoIX->bind_param('i', $idAnexoIV);
                        $stmtAnexoIX->execute();
                        $resultAnexoIX = $stmtAnexoIX->get_result();
                        $anexoIXCompleto = $resultAnexoIX->fetch_assoc()['count'] > 0;
                        $stmtAnexoIX->close();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error en la consulta del Anexo IX.']);
                        exit;
                    }
                } else {
                    // Si el Anexo IX no está habilitado, lo consideramos como completo
                    $anexoIXCompleto = true;
                }

                // Si todos los anexos están completos, proceder con el UPDATE
                if ($anexoVCompleto && $anexoVIIICompleto && $anexoXCompleto && $anexoIXCompleto) {
                    $sqlUpdate = "UPDATE anexoiv SET estado = 4 WHERE idAnexoIV = ?";
                    $stmtUpdate = $conexion->prepare($sqlUpdate);
                    if ($stmtUpdate) {
                        $stmtUpdate->bind_param('i', $idAnexoIV);
                        if ($stmtUpdate->execute()) {
                            echo json_encode(['status' => 'success', 'message' => 'Solicitud enviada correctamente. Tenga en cuenta que ya no podrá editar ni descargar los anexos hasta su aprobación.']);
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'Error al enviar solicitud.']);
                        }
                        $stmtUpdate->close();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error en la consulta de actualización.']);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Faltan anexos por completar.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de las consultas de verificación.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID de salida no proporcionado.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no permitido.']);
    }

    $conexion->close();
?>
