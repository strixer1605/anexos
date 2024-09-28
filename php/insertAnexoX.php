<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Usar el guion medio si una variable viene vacía o es nula
        $localidadEmpresa = !empty($_POST['localidadEmpresa']) ? $_POST['localidadEmpresa'] : '-';
        $hospitales = !empty($_POST['hospitales']) ? $_POST['hospitales'] : '-';
        $hospitalesTelefono = !empty($_POST['hospitalesTelefono']) ? $_POST['hospitalesTelefono'] : '-';
        $hospitalesDireccion = !empty($_POST['hospitalesDireccion']) ? $_POST['hospitalesDireccion'] : '-';
        $hospitalesLocalidad = !empty($_POST['hospitalesLocalidad']) ? $_POST['hospitalesLocalidad'] : '-';
        $datosInteres = !empty($_POST['datosInteres']) ? $_POST['datosInteres'] : '';
        $datosInteresTelefono = !empty($_POST['datosInteresTelefono']) ? $_POST['datosInteresTelefono'] : '';
        $datosInteresDireccion = !empty($_POST['datosInteresDireccion']) ? $_POST['datosInteresDireccion'] : '';
        $datosInteresLocalidad = !empty($_POST['datosInteresLocalidad']) ? $_POST['datosInteresLocalidad'] : '';

        // Verificar si ya existe un registro para la salida en anexox
        $sqlVerificacion = "SELECT * FROM anexox WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        if ($result->num_rows > 0) {
            // Si existe, actualizar
            $sql = "UPDATE anexox SET 
                        localidadEmpresa = ?, 
                        hospitales = ?, 
                        hospitalesTelefono = ?, 
                        hospitalesDireccion = ?,
                        hospitalesLocalidad = ?,
                        datosInteresNombre = ?, 
                        datosInteresTelefono = ?, 
                        datosInteresDireccion = ?, 
                        datosInteresLocalidad = ? 
                    WHERE fkAnexoIV = ?";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("sssssssssi", 
                $localidadEmpresa, 
                $hospitales, 
                $hospitalesTelefono, 
                $hospitalesDireccion, 
                $hospitalesLocalidad, 
                $datosInteres, 
                $datosInteresTelefono, 
                $datosInteresDireccion, 
                $datosInteresLocalidad, 
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
            $sql = "INSERT INTO `anexox`(`fkAnexoIV`, `localidadEmpresa`, `hospitales`, `hospitalesTelefono`, `hospitalesDireccion`, `hospitalesLocalidad`, 
                                        `datosInteresNombre`, `datosInteresTelefono`, `datosInteresDireccion`, `datosInteresLocalidad`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("isssssssss", 
                $idSalida, 
                $localidadEmpresa, 
                $hospitales, 
                $hospitalesTelefono, 
                $hospitalesDireccion, 
                $hospitalesLocalidad, 
                $datosInteres, 
                $datosInteresTelefono, 
                $datosInteresDireccion, 
                $datosInteresLocalidad
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
