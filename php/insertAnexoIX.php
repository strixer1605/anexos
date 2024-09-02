<?php
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
        // $dniConductor1 = $_POST['dniConductor1'];
        // $licenciaConductor1 = $_POST['licenciaConductor1'];
        // $vigenciaConductor1 = $_POST['vigenciaConductor1'];
        $nombreConductor2 = $_POST['nombreConductor2'];
        // $dniConductor2 = $_POST['dniConductor2'];
        // $licenciaConductor2 = $_POST['licenciaConductor2'];
        // $vigenciaConductor2 = $_POST['vigenciaConductor2'];

        $sql = "INSERT INTO anexo_9 (razon_social, domicilio_transporte, telefono_transporte, domicilio_responsable, telefono_responsable, telefono_movil, titularidad_vehiculo, compania_aseguradora, numero_poliza, tipo_seguro, nombre_conductor1, dni_conductor1, licencia_conductor1, vigencia_conductor1, nombre_conductor2, dni_conductor2, licencia_conductor2, vigencia_conductor2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssssssssssssssss", $razonSocial, $domicilioTransporte, $telefonoTransporte, $domicilioResponsable, $telefonoResponsable, $telefonoMovil, $titularidadVehiculo, $companiaAseguradora, $numeroPoliza, $tipoSeguro, $nombreConductor1, $dniConductor1, $licenciaConductor1, $vigenciaConductor1, $nombreConductor2, $dniConductor2, $licenciaConductor2, $vigenciaConductor2);

        if ($stmt->execute()) {
            echo "Datos insertados correctamente";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conexion->close();
    }
?>
