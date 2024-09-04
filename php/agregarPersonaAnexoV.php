<?php

include 'conexion.php';

if(isset($_POST['idAnexoIV'], $_POST['dni'], $_POST['nombreApellido'], $_POST['cargo'])) {
    $idAnexoIV = $_POST['idAnexoIV'];
    $dni = $_POST['dni'];
    $nombreApellido = $_POST['nombreApellido'];
    $cargo = $_POST['cargo'];

    $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES ";
}

$datos = [];

$datos[0] = $dni;
$datos[1] = $nombreApellido;
$datos[2] = $cargo;

echo json_encode($datos);