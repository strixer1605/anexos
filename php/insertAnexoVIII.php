<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nombreEmpresa = $_POST['nombreEmpresa'];
        $nombreGerente = $_POST['nombreGerente'];
        $domicilioEmpresa = $_POST['domicilioEmpresa'];
        $telefonoEmpresa = $_POST['telefonoEmpresa'];
        $domicilioGerente = $_POST['domicilioGerente'];
        $telefono = $_POST['telefono'];
        $telefonoMovil = $_POST['telefonoMovil'];
        $titularidadVehiculo = $_POST['titularidadVehiculo'];
        $aseguradora = $_POST['aseguradora'];
        $nombresConductores = explode(",", $_POST['nombresConductores']);
        $dnisConductores = explode(",", $_POST['dnisConductores']);
        $registrosVehiculos = explode(",", $_POST['registrosVehiculos']);
        $fechasHabilitacion = explode(",", $_POST['fechasHabilitacion']);
        $nombresConductores = explode(",", $_POST['nombresConductores']);
        $dnisConductores = explode(",", $_POST['dnisConductores']);
        $registrosVehiculos = explode(",", $_POST['registrosVehiculos']);
        $fechasHabilitacion = explode(",", $_POST['fechasHabilitacion']);
        $nombresConductores = explode(",", $_POST['nombresConductores']);
        $dnisConductores = explode(",", $_POST['dnisConductores']);
        $registrosVehiculos = explode(",", $_POST['registrosVehiculos']);

        $sqlVerificacion = "SELECT * FROM anexoix WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            
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
        
            $stmt->bind_param("ssisiississiisssssi", 
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
        }
        else {
            $sql = "INSERT INTO anexoix 
                (fkAnexoIV, razonSocial, domicilioTransporte, telefonoTransporte, domicilioResponsable, telefono, telefonoMovil, titularidadVehiculo, companiaAseguradora, numeroPoliza, tipoSeguro, nombreConductor1, dniConductor1, numeroLicencia1, vigencia1, nombreConductor2, dniConductor2, numeroLicencia2, vigencia2) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("issisiississiisssss", 
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
