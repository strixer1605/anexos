<?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';

    if (!empty($empresa) && !empty($direccion) && !empty($localidad) && !empty($telefono)) {
        $empresa = mysqli_real_escape_string($conexion, $empresa);
        $direccion = mysqli_real_escape_string($conexion, $direccion);
        $localidad = mysqli_real_escape_string($conexion, $localidad);
        $telefono = mysqli_real_escape_string($conexion, $telefono);

        $sql = "INSERT INTO `anexox`(`empresa`, `direccion`, `localidad`, `telefono`) 
                VALUES ('$empresa', '$direccion', '$localidad', '$telefono')";

        if (mysqli_query($conexion, $sql)) {
            echo 'Se guardó correctamente';
        } else {
            echo 'Error al guardar en la base de datos';
        }
    } else {
        echo 'Completa todos los campos';
    }
} else {
    echo 'Método de solicitud incorrecto';
}
?>



