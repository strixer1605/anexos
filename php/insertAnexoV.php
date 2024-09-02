<?php
    include('db_connection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dni = $_POST['dni'];
        $curso = $_POST['curso'];
        $dni_acompanante = $_POST['dni_acompanante'];
        $nombre_acompanante = $_POST['nombre_acompanante'];
        $edad_acompanante = $_POST['edad_acompanante'];

        $sql = "INSERT INTO anexo_5 (dni, curso, dni_acompanante, nombre_acompanante, edad_acompanante) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isisi", $dni, $curso, $dni_acompanante, $nombre_acompanante, $edad_acompanante);

        if ($stmt->execute()) {
            echo "Datos insertados correctamente";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
?>
