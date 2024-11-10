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

        // Convertir valores a cadenas solo si son arreglos, de lo contrario usarlos como están
        $nroRegistro = is_array($_POST['numeroRegistroArray']) ? implode(",", $_POST['numeroRegistroArray']) : $_POST['numeroRegistroArray'];
        $fechaHabilitacion = is_array($_POST['fechaHabilitacionArray']) ? implode(",", $_POST['fechaHabilitacionArray']) : $_POST['fechaHabilitacionArray'];
        $tipoHabilitacion = is_array($_POST['tipoHabilitacionArray']) ? implode(",", $_POST['tipoHabilitacionArray']) : $_POST['tipoHabilitacionArray'];
        $cantAsientos = is_array($_POST['cantidadAsientosArray']) ? implode(",", $_POST['cantidadAsientosArray']) : $_POST['cantidadAsientosArray'];
        $vigenciaVTV = is_array($_POST['vigenciaVTVArray']) ? implode(",", $_POST['vigenciaVTVArray']) : $_POST['vigenciaVTVArray'];
        $nroPoliza = is_array($_POST['polizaArray']) ? implode(",", $_POST['polizaArray']) : $_POST['polizaArray'];
        $tipoSeguro = is_array($_POST['tipoSeguroArray']) ? implode(",", $_POST['tipoSeguroArray']) : $_POST['tipoSeguroArray'];
        $nombreConductor = is_array($_POST['nombresConductoresArray']) ? implode(",", $_POST['nombresConductoresArray']) : $_POST['nombresConductoresArray'];
        $dniConductor = is_array($_POST['dnisConductoresArray']) ? implode(",", $_POST['dnisConductoresArray']) : $_POST['dnisConductoresArray'];
        $carnetConducir = is_array($_POST['carnetConductoresArray']) ? implode(",", $_POST['carnetConductoresArray']) : $_POST['carnetConductoresArray'];
        $vigenciaConductor = is_array($_POST['vigenciaConductoresArray']) ? implode(",", $_POST['vigenciaConductoresArray']) : $_POST['vigenciaConductoresArray'];

        $rutaArchivo = null;
        if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] == 0) {
            $uploadDir = '../archivosPDFAnexoVIII/';
            $filename = "adjuntoPDFsalida".$idSalida.".pdf";
            $rutaArchivo = $uploadDir . $filename;
        
            // Check if the file already exists and delete it if it does
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo); // Deletes the old file
            }
        
            // Move the new file to the directory
            if (!move_uploaded_file($_FILES['pdfFile']['tmp_name'], $rutaArchivo)) {
                die("Error al mover el archivo al directorio de destino.");
            }
        }

        $sqlVerificacion = "SELECT * FROM anexoviii WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        if ($result->num_rows > 0) {
            $sql = "UPDATE anexoviii SET 
                    nombreEmpresa = ?, 
                    nombreGerente = ?, 
                    domicilioEmpresa = ?, 
                    telefonoEmpresa = ?, 
                    domicilioGerente = ?, 
                    telefono = ?, 
                    telefonoMovil = ?, 
                    titularidadVehiculo = ?, 
                    rutaPDF = COALESCE(?, rutaPDF),
                    nroRegistro = ?, 
                    fechaHabilitacion = ?, 
                    tipoHabilitacion = ?, 
                    cantAsientos = ?, 
                    vigenciaVTV = ?, 
                    aseguradora = ?, 
                    nroPoliza = ?, 
                    tipoSeguro = ?, 
                    nombreConductor = ?, 
                    dniConductor = ?,
                    carnetConducir = ?, 
                    vigenciaConductor = ?
                    WHERE fkAnexoIV = ?";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("sssisiisssssississiisi", 
                $nombreEmpresa, 
                $nombreGerente, 
                $domicilioEmpresa, 
                $telefonoEmpresa, 
                $domicilioGerente, 
                $telefono, 
                $telefonoMovil, 
                $titularidadVehiculo, 
                $rutaArchivo,
                $nroRegistro, 
                $fechaHabilitacion, 
                $tipoHabilitacion, 
                $cantAsientos, 
                $vigenciaVTV, 
                $aseguradora, 
                $nroPoliza, 
                $tipoSeguro, 
                $nombreConductor, 
                $dniConductor, 
                $carnetConducir,
                $vigenciaConductor,
                $idSalida
            );

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $sql = "INSERT INTO `anexoviii`
                (`fkAnexoIV`, `nombreEmpresa`, `nombreGerente`, `domicilioEmpresa`, `telefonoEmpresa`, `domicilioGerente`, `telefono`, `telefonoMovil`, `titularidadVehiculo`, `rutaPDF`, `nroRegistro`, `fechaHabilitacion`, `tipoHabilitacion`, `cantAsientos`, `vigenciaVTV`, `aseguradora`, `nroPoliza`, `tipoSeguro`, `nombreConductor`, `dniConductor`, `carnetConducir`, `vigenciaConductor`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("isssisiisssssississiis", 
                $idSalida, 
                $nombreEmpresa, 
                $nombreGerente, 
                $domicilioEmpresa, 
                $telefonoEmpresa, 
                $domicilioGerente, 
                $telefono, 
                $telefonoMovil, 
                $titularidadVehiculo, 
                $rutaArchivo,
                $nroRegistro, 
                $fechaHabilitacion, 
                $tipoHabilitacion, 
                $cantAsientos, 
                $vigenciaVTV, 
                $aseguradora, 
                $nroPoliza, 
                $tipoSeguro, 
                $nombreConductor, 
                $dniConductor,
                $carnetConducir,
                $vigenciaConductor            
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
