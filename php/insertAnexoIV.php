<?php
    session_start();
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $estado = 1;
        $tipoSolicitud = intval($_POST['tipoSalida']);
        $distanciaSalida = intval($_POST['distanciaSalida']);
        $region = $_POST['region'];
        $distrito = $_POST['distrito'];
        $institucionEducativa = $_POST['institucionEducativa'];
        $numeroInstitucion = $_POST['numero'];
        $domicilioInstitucion = $_POST['domicilio'];
        $telefonoInstitucion = $_POST['telefono'];
        $denominacionProyecto = $_POST['denominacionProyecto'];
        $localidadViaje = $_POST['localidadViaje'];
        $lugarVisita = $_POST['lugarVisitar'];
        $fechaSalida = $_POST['fechaSalida'];
        $lugarSalida = $_POST['lugarSalida'];
        $horaSalida = $_POST['horaSalida'];
        $fechaRegreso = $_POST['fechaRegreso'];
        $lugarRegreso = $_POST['lugarRegreso'];
        $horaRegreso = $_POST['horaRegreso'];
        $itinerario = $_POST['itinerario'];
        $actividades = $_POST['actividades'];
        $dniEncargado = $_POST['dniEncargado'];
        $apellidoNombreEncargado = $_POST['nombreEncargado'];
        $cargo = 2;
        $nombreHospedaje = !empty($_POST['nombreHospedaje']) ? $_POST['nombreHospedaje'] : '-';
        $domicilioHospedaje = !empty($_POST['domicilioHospedaje']) ? $_POST['domicilioHospedaje'] : '-';
        $telefonoHospedaje = !empty($_POST['telefonoHospedaje']) ? $_POST['telefonoHospedaje'] : '-';
        $localidadHospedaje = !empty($_POST['localidadHospedaje']) ? $_POST['localidadHospedaje'] : '-';
        $gastosEstimativos = $_POST['gastosEstimativos'];
        $anexo9 = isset($_POST['anexo9']) ? 1 : 0;
        $fechaLimite = $_POST['fechaLimite'];

        $sql = "INSERT INTO anexoiv (
            estado, tipoSolicitud, distanciaSalida, region, distrito, institucionEducativa, numeroInstitucion, domicilioInstitucion,
            telefonoInstitucion, denominacionProyecto, localidadViaje, lugarVisita, fechaSalida, lugarSalida,
            horaSalida, fechaRegreso, lugarRegreso, horaRegreso, itinerario, actividades,
            dniEncargado, apellidoNombreEncargado, cargo, nombreHospedaje, domicilioHospedaje, telefonoHospedaje, 
            localidadHospedaje, gastosEstimativos, anexoIXHabil, fechaLimite
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param(
                "iiiissisisssssssssssisississis",
                $estado, $tipoSolicitud, $distanciaSalida, $region, $distrito, $institucionEducativa, $numeroInstitucion, $domicilioInstitucion,
                $telefonoInstitucion, $denominacionProyecto, $localidadViaje, $lugarVisita, $fechaSalida, $lugarSalida,
                $horaSalida, $fechaRegreso, $lugarRegreso, $horaRegreso, $itinerario, $actividades,
                $dniEncargado, $apellidoNombreEncargado, $cargo, $nombreHospedaje, $domicilioHospedaje, $telefonoHospedaje, 
                $localidadHospedaje,$gastosEstimativos, $anexo9, $fechaLimite
            );

            if ($stmt->execute()) {
                echo 'success';
                exit();
            } else {
                echo "Error: " . $stmt->error;
                echo "<br> SQL: " . $sql;
            }
            

            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conexion->error;
        }

        $conexion->close();
    } else {
        echo "Método de solicitud no permitido.";
    }
    ob_end_flush();
?>
