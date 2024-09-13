<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $infraestructura = $_POST['infraestructura'];
        $hospitales = $_POST['hospitales'];
        $mediosAlternativos = $_POST['mediosAlternativos'];
        $datosOpcionales = $_POST['datosOpcionales'];

        $sql = "INSERT INTO anexox (fkAnexoIV, infraestructuraDisponible, hospitalesDisponibles, mediosAlternativos, datosOpcionales) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("issss", $idSalida, $infraestructura, $hospitales, $mediosAlternativos, $datosOpcionales);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conexion->close();
    }
?>
