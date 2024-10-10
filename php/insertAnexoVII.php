<?php
// Incluir el archivo de conexión a la base de datos
session_start();
if (isset($_SESSION['dniPadre'])) {
    
    include 'conexion.php'; // Asegúrate de tener un archivo de conexión a la base de datos
    
    // Obtener el contenido JSON enviado desde el formulario
    $data = file_get_contents("php://input");
    $datos = json_decode($data, true); // Decodificar el JSON a un array asociativo
    
    // Asumiendo que ya tienes las variables $idSalida y $dniAlumno definidas
    $idSalida = $_SESSION['idSalida'];
    $dniAlumno = $_SESSION['dniAlumno'];
    
    // Extraer los datos del array
    $alergico = $datos['alergico'];
    $sufrioA = $datos['sufrioA'];
    $sufrioB = $datos['sufrioB'];
    $sufrioC = $datos['sufrioC'];
    $medicacion = $datos['medicacion'];
    $observaciones = $datos['indicaciones']; // Usamos 'indicaciones' como observaciones
    $obraSocial = $datos['obraSocial'];
    $aQue = $datos['aQue']; // Asumí que este es el tipo de alergia
    $otroMalestar = $datos['otrasInput']; // Usamos 'sufrioD' como otro malestar
    $tipoMedicacion = $datos['medicacionDetalles']; // Usamos 'medicacionDetalles' para detalles de medicación
    
    // Verificar si ya existe un registro con el mismo fkAnexoIV y dniAlumno
    $checkSql = "SELECT COUNT(*) FROM `anexovii` WHERE `fkAnexoIV` = ? AND `dniAlumno` = ?";
    $checkStmt = $conexion->prepare($checkSql);
    $checkStmt->bind_param("ii", $idSalida, $dniAlumno);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();
    
    if ($count > 0) {
        // Si existe, actualizar el registro
        $updateSql = "UPDATE `anexovii` SET `alergico` = ?, `sufrioA` = ?, `sufrioB` = ?, `sufrioC` = ?, `medicacion` = ?, `observaciones` = ?, `obraSocial` = ?, `tipoAlergia` = ?, `otroMalestar` = ?, `tipoMedicacion` = ? WHERE `fkAnexoIV` = ? AND `dniAlumno` = ?";
        
        $updateStmt = $conexion->prepare($updateSql);
        $updateStmt->bind_param("iiiiisisssii", $alergico, $sufrioA, $sufrioB, $sufrioC, $medicacion, $observaciones, $obraSocial, $aQue, $otroMalestar, $tipoMedicacion, $idSalida, $dniAlumno);
        
        if ($updateStmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar los datos: " . $updateStmt->error]);
        }
        
        $updateStmt->close();
    } else {
        // Si no existe, insertar el nuevo registro
        $insertSql = "INSERT INTO `anexovii`(`fkAnexoIV`, `dniAlumno`, `alergico`, `sufrioA`, `sufrioB`, `sufrioC`, `medicacion`, `observaciones`, `obraSocial`, `tipoAlergia`, `otroMalestar`, `tipoMedicacion`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Preparar la declaración
        $insertStmt = $conexion->prepare($insertSql);
        // Usa 's' para los campos que son cadenas (strings)
        $insertStmt->bind_param("iiiiiiisisss", $idSalida, $dniAlumno, $alergico, $sufrioA, $sufrioB, $sufrioC, $medicacion, $observaciones, $obraSocial, $aQue, $otroMalestar, $tipoMedicacion);
        
        // Ejecutar la consulta
        if ($insertStmt->execute()) {
            var_dump($otroMalestar);
            echo json_encode(["status" => "success", "message" => "Datos guardados correctamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al guardar los datos: " . $insertStmt->error]);
        }
        
        $insertStmt->close();
    }
    
    // Cerrar la conexión
    $conexion->close();
}
?>
