<?php
session_start();
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

// Verificar si el idAnexoIV está presente en la solicitud POST
if (isset($_GET['idSalida'])) {
    $_SESSION['idSalida'] = $_GET['idSalida'];
    $idSalida = $_SESSION['idSalida'];
    echo $idSalida;
    // Preparar la consulta SQL
    $sql = "SELECT denominacionProyecto FROM anexoiv WHERE idAnexoIV = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $idSalida); // Suponiendo que idAnexoIV es un entero

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        // Verificar si se encontró un resultado
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $denominacionProyecto = $row['denominacionProyecto'];

            $_SESSION['denominacionProyecto'] = $denominacionProyecto;

            header('Location: ../indexs/profesores/menuSalida.php');
            exit;
        } else {
            echo ('error');
        }
    } else {
        echo ('error');
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
} else {
    echo ('error');
}

$conexion->close();
?>