<?php
    // Iniciar la sesión
    session_start();
    if (isset($_SESSION['dniPadre'])) {
        
        include 'conexion.php'; // Asegúrate de tener un archivo de conexión a la base de datos
        
        // Obtener los datos enviados por FormData
        $constancia = $_POST['constancia'];
        $obraSocial = $_POST['obraSocial'];
        $nombreObra = $_POST['nombreObra'];
        $nroObra = $_POST['nroObra'];

        // Variables de sesión ya definidas
        $idSalida = $_SESSION['idSalida'];
        $dniAlumno = $_SESSION['dniAlumno'];
        
        // Reemplazar valores vacíos con "-"
        if (empty($constancia)) {
            $constancia = "-";
        }

        if ($obraSocial == 0) {
            $nombreObra = "-";
            $nroObra = "-";
        } else {
            // Si obraSocial es distinto de 0, verificar los valores específicos de nombre y número
            if (empty($nombreObra)) {
                $nombreObra = "-";
            }
            if (empty($nroObra)) {
                $nroObra = "-";
            }
        }
        
        // Verificar si ya existe un registro con el mismo fkAnexoIV y dniAlumno
        $checkSql = "SELECT COUNT(*) FROM `anexovi` WHERE `fkAnexoIV` = ? AND `dniAlumno` = ?";
        $checkStmt = $conexion->prepare($checkSql);
        $checkStmt->bind_param("ii", $idSalida, $dniAlumno);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();
        
        if ($count > 0) {
            // Si existe, actualizar el registro
            $updateSql = "UPDATE `anexovi` SET `constanciaMedica` = ?, `obraSocial` = ?, `nombreObra` = ?, `nSocio` = ? WHERE `fkAnexoIV` = ? AND `dniAlumno` = ?";
            
            $updateStmt = $conexion->prepare($updateSql);
            $updateStmt->bind_param("sissii", $constancia, $obraSocial, $nombreObra, $nroObra, $idSalida, $dniAlumno);
            
            if ($updateStmt->execute()) {
                echo json_encode(["success" => true, "message" => "Datos actualizados correctamente."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al actualizar los datos: " . $updateStmt->error]);
            }
            
            $updateStmt->close();
        } else {
            // Si no existe, insertar el nuevo registro
            $insertSql = "INSERT INTO `anexovi`(`fkAnexoIV`, `dniAlumno`, `constanciaMedica`, `obraSocial`, `nombreObra`, `nSocio`) VALUES (?, ?, ?, ?, ?, ?)";
            
            // Preparar la declaración
            $insertStmt = $conexion->prepare($insertSql);
            $insertStmt->bind_param("iisiss", $idSalida, $dniAlumno, $constancia, $obraSocial, $nombreObra, $nroObra);
            
            // Ejecutar la consulta
            if ($insertStmt->execute()) {
                echo json_encode(["success" => true, "message" => "Datos guardados correctamente."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al guardar los datos: " . $insertStmt->error]);
            }
            
            $insertStmt->close();
        }
        
        // Cerrar la conexión
        $conexion->close();
    } else {
        echo json_encode(["success" => false, "message" => "Sesión no iniciada."]);
    }
?>
