<?php
    session_start();
    include ('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['idAnexoIV'])) {

            $idAnexoIV = $_POST['idAnexoIV'];
            $sql = "UPDATE anexoiv SET estado = 4 WHERE idAnexoIV = ?";
            $stmt = $conexion->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('i', $idAnexoIV);
                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Solicitud enviada correctamente. Tenga en cuenta que ya no podrá editar ni descargar los anexos hasta su aprobación.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al enviar solicitud.']);
                }
                $stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error en la consulta.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID de salida no proporcionado.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no permitido.']);
    }

    $conexion->close();
?>
