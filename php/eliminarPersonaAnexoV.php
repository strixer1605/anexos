<?php
session_start();

if (isset($_POST['dniList'])) {
    $dniList = $_POST['dniList'];
    $idSalida = $_SESSION['idSalida'];

    include ('conexion.php');

    $dniListString = implode(",", array_map('intval', $dniList));

    $sql = "DELETE FROM anexov WHERE dni in ($dniListString) AND fkAnexoIV = $idSalida";

    if($conexion->query($sql) === TRUE) {
        echo "Personas eliminadas correctamente";
    } else {
        echo "error al eliminar: " . $conexion->error;
    }

    $conexion->close();
}