<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // $localidadEmpresa = !empty($_POST['localidadEmpresa']) ? $_POST['localidadEmpresa'] : '-';
        // $hospitales = !empty($_POST['hospitales']) ? $_POST['hospitales'] : '-';
        // $hospitalesTelefono = !empty($_POST['hospitalesTelefono']) ? $_POST['hospitalesTelefono'] : '-';
        // $hospitalesDireccion = !empty($_POST['hospitalesDireccion']) ? $_POST['hospitalesDireccion'] : '-';
        $empresas = $_POST['empresas'];
        $datosInfraestructura = $_POST['datosInfraestructura'];
        $hospitalesCercanos = $_POST['hospitalesCercanos'];
        $datosInteres = $_POST['datosInteres'];

        $sqlVerificacion = "SELECT * FROM planillainfoanexo WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        if ($result->num_rows > 0) {
            // Si existe, actualizar
            $sql = "UPDATE planillainfoanexo SET 
                        empresas = ?, 
                        datosInfraestructura = ?, 
                        hospitalesCercanos = ?, 
                        datosInteres = ?,
                    WHERE fkAnexoIV = ?";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("ssssi", 
                $empresas, 
                $datosInfraestructura, 
                $hospitalesCercanos, 
                $datosInteres, 
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
            $sql = "INSERT INTO `planillainfoanexo`(`fkAnexoIV`, `empresas`, `datosInfraestructura`, `hospitalesCercanos`, `datosInteres`) 
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("issss", 
                $idSalida, 
                $empresas, 
                $datosInfraestructura, 
                $hospitalesCercanos, 
                $datosInteres
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
