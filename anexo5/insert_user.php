<?php
include('../modulos/conexion.php');

$mensaje = ''; // Inicializa la variable del mensaje

$apellido_y_nombre = $_POST['nom_ape'];
$documento = $_POST['doc'];
$edad = $_POST['edad'];
$cargo = $_POST['cargo'];

// Utiliza una sentencia preparada para evitar la inyección de SQL
$sql = "INSERT INTO `anexov`(`apellido_y_nombre`, `documento`, `edad`, `cargo`) VALUES (?, ?, ?, ?)";

if ($stmt = mysqli_prepare($conexion, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssss", $apellido_y_nombre, $documento, $edad, $cargo);

    if (mysqli_stmt_execute($stmt)) {
        $mensaje = 'Se guardó correctamente';
    } else {
        $mensaje = 'Se produjo un error al guardar: ' . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
} else {
    $mensaje = 'Error en la preparación de la sentencia.';
}

mysqli_close($conexion);

// Muestra el mensaje en el lugar adecuado en tu HTML
?>


