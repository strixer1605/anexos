<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include 'conexion.php';

if(isset($_POST['idAnexoIV'], $_POST['dni'], $_POST['nombreApellido'], $_POST['fechan'], $_POST['cargo'])) {
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

    // Preparar y ejecutar la consulta de inserción
    $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sqlInsert);

    if ($stmt) {
        // Bindear los parámetros: i = integer, s = string
        $stmt->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Registro insertado correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar el registro']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta']);
    }

    $conexion->close();
}
?>
