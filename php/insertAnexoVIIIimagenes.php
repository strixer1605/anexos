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
        $telefonoMovil = "--";
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

        // Ruta de la carpeta en tu servidor donde guardarás los archivos
        $carpetaDestino = '../transporteDoc/';

        // Verifica si la carpeta existe, si no, créala
        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        // Array para guardar las rutas de los archivos
        $rutasArchivos = [];

        // Función para manejar la carga de archivos
        function manejarArchivo($campo) {
            global $carpetaDestino, $rutasArchivos;
            if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] === UPLOAD_ERR_OK) {
                // Genera un nombre único para el archivo para evitar conflictos
                $nombreArchivo = uniqid() . '-' . basename($_FILES[$campo]['name']);
                $rutaArchivo = $carpetaDestino . $nombreArchivo;

                // Mueve el archivo cargado a la carpeta de destino
                if (move_uploaded_file($_FILES[$campo]['tmp_name'], $rutaArchivo)) {
                    $rutasArchivos[$campo] = $rutaArchivo;
                    return $rutaArchivo;
                } else {
                    echo "Error al mover el archivo " . $campo . ".";
                    exit;
                }
            }
            return null;
        }

        // Maneja cada archivo
        $rutasArchivos['cedulaTransporte'] = manejarArchivo('cedulaTransporte');
        $rutasArchivos['certificadoAptitudTecnica'] = manejarArchivo('certificadoAptitudTecnica');
        $rutasArchivos['crnt'] = manejarArchivo('crnt');
        $rutasArchivos['vtvNacion'] = manejarArchivo('vtvNacion');
        $rutasArchivos['certificadoInspeccionVtvNacion'] = manejarArchivo('certificadoInspeccionVtvNacion');
        $rutasArchivos['registroControlModelo'] = manejarArchivo('registroControlModelo');
        $rutasArchivos['vtvProvincia'] = manejarArchivo('vtvProvincia');
        $rutasArchivos['documentacionConductores'] = manejarArchivo('documentacionConductores');

        $sqlVerificacion = "SELECT * FROM anexoix WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            
            $rutasArchivos['cedulaTransporte'] = $rutasArchivos['cedulaTransporte'] ?? $row['cedulaTransporte'];
            $rutasArchivos['certificadoAptitudTecnica'] = $rutasArchivos['certificadoAptitudTecnica'] ?? $row['certifAptTecnica'];
            $rutasArchivos['crnt'] = $rutasArchivos['crnt'] ?? $row['crnt'];
            $rutasArchivos['vtvNacion'] = $rutasArchivos['vtvNacion'] ?? $row['vtvNacion'];
            $rutasArchivos['certificadoInspeccionVtvNacion'] = $rutasArchivos['certificadoInspeccionVtvNacion'] ?? $row['certInspVtvNac'];
            $rutasArchivos['registroControlModelo'] = $rutasArchivos['registroControlModelo'] ?? $row['regisCrtlModelo'];
            $rutasArchivos['vtvProvincia'] = $rutasArchivos['vtvProvincia'] ?? $row['vtvProvincia'];
            $rutasArchivos['documentacionConductores'] = $rutasArchivos['documentacionConductores'] ?? $row['docConductores'];
            
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
                    vigencia2 = ?, 
                    cedulaTransporte = ?, 
                    certifAptTecnica = ?, 
                    crnt = ?, 
                    vtvNacion = ?, 
                    certInspVtvNac = ?, 
                    regisCrtlModelo = ?, 
                    vtvProvincia = ?, 
                    docConductores = ? 
                    WHERE fkAnexoIV = ?";
        
            $stmt = $conexion->prepare($sql);
        
            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }
        
            $stmt->bind_param("ssisiississiissiisssssssssi", 
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
                $rutasArchivos['cedulaTransporte'],
                $rutasArchivos['certificadoAptitudTecnica'],
                $rutasArchivos['crnt'],
                $rutasArchivos['vtvNacion'],
                $rutasArchivos['certificadoInspeccionVtvNacion'],
                $rutasArchivos['registroControlModelo'],
                $rutasArchivos['vtvProvincia'],
                $rutasArchivos['documentacionConductores'],
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
                (fkAnexoIV, razonSocial, domicilioTransporte, telefonoTransporte, domicilioResponsable, telefono, telefonoMovil, titularidadVehiculo, companiaAseguradora, numeroPoliza, tipoSeguro, nombreConductor1, dniConductor1, numeroLicencia1, vigencia1, nombreConductor2, dniConductor2, numeroLicencia2, vigencia2, cedulaTransporte, certifAptTecnica, crnt, vtvNacion, certInspVtvNac, regisCrtlModelo, vtvProvincia, docConductores) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("issisiississiissiisssssssss", 
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
                $vigenciaConductor2,
                $rutasArchivos['cedulaTransporte'],
                $rutasArchivos['certificadoAptitudTecnica'],
                $rutasArchivos['crnt'],
                $rutasArchivos['vtvNacion'],
                $rutasArchivos['certificadoInspeccionVtvNacion'],
                $rutasArchivos['registroControlModelo'],
                $rutasArchivos['vtvProvincia'],
                $rutasArchivos['documentacionConductores']
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
