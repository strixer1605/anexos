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
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    // Leer el cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Decodificar JSON a un array asociativo

    if (isset($data['personas'])) {
        $personas = $data['personas'];
        $idAnexoIV = $_SESSION['idSalida'];

        foreach ($personas as $persona) {
            // Validar y extraer datos
            $dni = intval($persona['dni']);
            $nombreApellido = trim($persona['nombre'] . ' ' . $persona['apellido']);
            $fechan = $persona['fechan'];

            if (!$fechan || !DateTime::createFromFormat('Y-m-d', $fechan)) {
                continue; // Saltar si la fecha no es válida
            }

            //calculo de edad
            $fechaActual = date("Y-m-d");
            $fechaNacimiento = new DateTime($fechan);
            $fechaHoy = new DateTime($fechaActual);
            $edad = $fechaHoy->diff($fechaNacimiento)->y;

            // Verificar duplicados
            $sqlVerificar = "SELECT fkAnexoIV FROM `anexov` WHERE dni = ? AND fkAnexoIV = ?";
            $stmtVerificar = $conexion->prepare($sqlVerificar);
            $stmtVerificar->bind_param('ii', $dni, $idAnexoIV);
            $stmtVerificar->execute();
            $resultVerificar = $stmtVerificar->get_result();

            if ($resultVerificar->num_rows == 0) {
                // Inserción
                $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES (?, ?, ?, ?, ?)";
                $stmtInsert = $conexion->prepare($sqlInsert);
                $cargo = 3; // Asignar el cargo correspondiente

                $stmtInsert->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);
                $stmtInsert->execute();
                $stmtInsert->close();
            }
            $stmtVerificar->close();
        }

        echo json_encode(['status' => 'success', 'message' => 'Todas las personas procesadas correctamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se recibieron personas.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
}
?>
