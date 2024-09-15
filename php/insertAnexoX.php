<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $infraestructura = $_POST['infraestructura'];
        $hospitales = $_POST['hospitales'];
        $mediosAlternativos = $_POST['mediosAlternativos'];
        $datosOpcionales = $_POST['datosOpcionales'];

        // Verificar si ya existe un registro para la salida en anexox
        $sqlVerificacion = "SELECT * FROM anexox WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        if ($result->num_rows > 0) {
            // Si existe, actualizar
            $sql = "UPDATE anexox SET 
                infraestructuraDisponible = ?, 
                hospitalesDisponibles = ?, 
                mediosAlternativos = ?, 
                datosOpcionales = ? 
                WHERE fkAnexoIV = ?";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("ssssi", 
                $infraestructura, 
                $hospitales, 
                $mediosAlternativos, 
                $datosOpcionales, 
                $idSalida
            );

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();

        } else {
            // Si no existe, insertar
            $sql = "INSERT INTO anexox 
                (fkAnexoIV, infraestructuraDisponible, hospitalesDisponibles, mediosAlternativos, datosOpcionales) 
                VALUES (?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("issss", 
                $idSalida, 
                $infraestructura, 
                $hospitales, 
                $mediosAlternativos, 
                $datosOpcionales
            );

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }

        $stmtVerificacion->close();
        $conexion->close();
    }
?>
