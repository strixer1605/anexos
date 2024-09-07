<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include 'conexion.php';

if (isset($_POST['idAnexoIV'], $_POST['dni'], $_POST['nombreApellido'], $_POST['fechan'], $_POST['cargo'])) {
    $idAnexoIV = $_POST['idAnexoIV'];
    $dni = $_POST['dni'];
    $nombreApellido = $_POST['nombreApellido'];
    $fechan = $_POST['fechan'];
    $fechaActual = date("Y-m-d");
    
    // Convertir las fechas en objetos DateTime
    $fechaNacimiento = new DateTime($fechan);
    $fechaHoy = new DateTime($fechaActual);
    
    // Calcular la diferencia entre las dos fechas
    $diferencia = $fechaHoy->diff($fechaNacimiento);
    
    // Obtener la edad en años
    $edad = $diferencia->y;
    $cargo = $_POST['cargo'];
    
    //consulta para verificar que no se repitan los datos
    $sqlVerificar = "SELECT fkAnexoIV, dni FROM `anexov` WHERE dni = ? AND fkAnexoIV = ?";

    $stmtVerificar = $conexion->prepare($sqlVerificar);
    if ($stmtVerificar) {
        $stmtVerificar->bind_param('ii', $dni, $idAnexoIV);
        $stmtVerificar->execute();
        $resultVerificar = $stmtVerificar->get_result();

        if ($resultVerificar->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'La persona cargada ya está registrada en la salida']);
        } else {
            // Preparar y ejecutar la consulta de inserción
            $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sqlInsert);

            if ($stmt) {
                // Bindear los parámetros: 'i' para integer, 's' para string
                $stmt->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);

                if ($stmt->execute()) {
                    // Obtener todos los participantes después de la inserción
                    $sqlSelect = "SELECT dni, apellidoNombre, edad, cargo FROM anexov WHERE fkAnexoIV = ?";
                    $stmtSelect = $conexion->prepare($sqlSelect);
                    $stmtSelect->bind_param('i', $idAnexoIV);
                    $stmtSelect->execute();
                    $result = $stmtSelect->get_result();

                    $participantes = [];
                    while ($row = $result->fetch_assoc()) {
                        $participantes[] = $row; // Guardar cada participante en el array
                    }

                    // Devolver la respuesta JSON con el estado y los participantes
                    echo json_encode(['status' => 'success', 'message' => 'Registro insertado correctamente', 'participantes' => $participantes]);
                    
                    $stmtSelect->close();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al insertar el registro: ' . $stmt->error]);
                }

                $stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta: ' . $conexion->error]);
            }
        }
        $stmtVerificar->close();
    }
    $conexion->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
}
?>
