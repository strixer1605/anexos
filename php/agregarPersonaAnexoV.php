<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include 'conexion.php';

if(isset($_POST['idAnexoIV'], $_POST['dni'], $_POST['nombreApellido'],  $_POST['fechan'], $_POST['cargo'])) {
    $idAnexoIV = $_POST['idAnexoIV'];
    $dni = $_POST['dni'];
    $nombreApellido = $_POST['nombreApellido'];
    $fechan = $_POST['fechan'];
    $fechaActual = date("Y-m-d");

    //convertir las fechas en objetos DateTime
    $fechaNacimiento = new DateTime($fechan);
    $fechaHoy = new DateTime($fechaActual);

    //calcular la diferencia entre las dos fechas
    $diferencia = $fechaHoy->diff($fechaNacimiento);

    //obtener la edad en años
    $edad = $diferencia->y; 
    $cargo = $_POST['cargo'];

    $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES ?, ?, ?, ?, ?";
    $stmt = $conexion->prepare($sqlInsert);
    $stmt->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);
    $stmt->execute();
    $result = $stmt->get_result();
}
