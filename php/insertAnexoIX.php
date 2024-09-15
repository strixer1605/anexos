<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $razonSocial = $_POST['razonSocial'];
        $domicilioTransporte = $_POST['domicilioTransporte'];
        $telefonoTransporte = $_POST['telefonoTransporte'];
        $domicilioResponsable = $_POST['domicilioResponsable'];
        $telefonoResponsable = $_POST['telefonoResponsable'];
        $telefonoMovil = $_POST['telefonoMovil'];
        $titularidadVehiculo = $_POST['titularidadVehiculo'];
        $companiaAseguradora = $_POST['companiaAseguradora'];
        $numeroPoliza = $_POST['numeroPoliza'];
        $tipoSeguro = $_POST['tipoSeguro'];
        $nombreConductor1 = $_POST['nombreConductor1'];
        $dniConductor1 = $_POST['dniConductor1'];
        $licenciaConductor1 = $_POST['licenciaConductor1'];
        $vigenciaConductor1 = $_POST['vigenciaConductor1'];
        $nombreConductor2 = $_POST['nombreConductor2'];
        $dniConductor2 = $_POST['dniConductor2'];
        $licenciaConductor2 = $_POST['licenciaConductor2'];
        $vigenciaConductor2 = $_POST['vigenciaConductor2'];

        // Verificar si ya existe un registro para la salida
        $sqlVerificacion = "SELECT * FROM anexoix WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        if ($result->num_rows > 0) {
            // Si existe, actualizar
            $sql = "UPDATE anexoix SET 
                razonSocial = ?, 
                domicilioTransporte = ?, 
                telefonoTransporte = ?, 
                domicilioResponsable = ?, 
                telefono = ?, 
                telefonoMovil = ?, 
                titularidadVehiculo = ?, 
                companiaAseguradora = ?, 
                numeroPoliza = ?, 
                tipoSeguro = ?, 
                nombreConductor1 = ?, 
                dniConductor1 = ?, 
                numeroLicencia1 = ?, 
                vigencia1 = ?, 
                nombreConductor2 = ?, 
                dniConductor2 = ?, 
                numeroLicencia2 = ?, 
                vigencia2 = ?
                WHERE fkAnexoIV = ?";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("ssisiississiiiisiii", 
                $razonSocial, 
                $domicilioTransporte, 
                $telefonoTransporte, 
                $domicilioResponsable, 
                $telefonoResponsable, 
                $telefonoMovil, 
                $titularidadVehiculo, 
                $companiaAseguradora, 
                $numeroPoliza, 
                $tipoSeguro, 
                $nombreConductor1, 
                $dniConductor1, 
                $licenciaConductor1, 
                $vigenciaConductor1, 
                $nombreConductor2, 
                $dniConductor2, 
                $licenciaConductor2, 
                $vigenciaConductor2, 
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
            $sql = "INSERT INTO anexoix 
                (fkAnexoIV, razonSocial, domicilioTransporte, telefonoTransporte, domicilioResponsable, telefono, telefonoMovil, titularidadVehiculo, companiaAseguradora, numeroPoliza, tipoSeguro, nombreConductor1, dniConductor1, numeroLicencia1, vigencia1, nombreConductor2, dniConductor2, numeroLicencia2, vigencia2) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("issisiississiiisiii", 
                $idSalida, 
                $razonSocial, 
                $domicilioTransporte, 
                $telefonoTransporte, 
                $domicilioResponsable, 
                $telefonoResponsable, 
                $telefonoMovil, 
                $titularidadVehiculo, 
                $companiaAseguradora, 
                $numeroPoliza, 
                $tipoSeguro, 
                $nombreConductor1, 
                $dniConductor1, 
                $licenciaConductor1, 
                $vigenciaConductor1, 
                $nombreConductor2, 
                $dniConductor2, 
                $licenciaConductor2, 
                $vigenciaConductor2
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
