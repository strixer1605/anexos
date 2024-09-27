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
        $cantidadAlumnos = 0;
        $cantDocentes = 1;
        $cantAcompañantes = 0;
        $nombreHospedaje = $_POST['nombreHospedaje'];
        $domicilioHospedaje = $_POST['domicilioHospedaje'];
        $telefonoHospedaje = $_POST['telefonoHospedaje'];
        $localidadHospedaje = $_POST['localidadHospedaje'];
        $gastosEstimativos = $_POST['gastosEstimativos'];
        // $anexo8 = isset($_POST['anexo8']) ? 1 : 0;
        $anexo9 = isset($_POST['anexo9']) ? 1 : 0;
        // $anexo10 = isset($_POST['anexo10']) ? 1 : 0;

        $sql = "INSERT INTO anexoiv (
            estado, tipoSolicitud, distanciaSalida, region, distrito, institucionEducativa, numeroInstitucion, domicilioInstitucion,
            telefonoInstitucion, denominacionProyecto, localidadViaje, lugarVisita, fechaSalida, lugarSalida,
            horaSalida, fechaRegreso, lugarRegreso, horaRegreso, itinerario, actividades,
            dniEncargado, apellidoNombreEncargado, cargo, cantidadAlumnos, cantDocentes, cantAcompañantes,
            nombreHospedaje, domicilioHospedaje, telefonoHospedaje, localidadHospedaje, gastosEstimativos, anexoIXHabil
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param(
                "iiiissisisssssssssssisiiiississi",
                $estado, $tipoSolicitud, $distanciaSalida, $region, $distrito, $institucionEducativa, $numeroInstitucion, $domicilioInstitucion,
                $telefonoInstitucion, $denominacionProyecto, $localidadViaje, $lugarVisita, $fechaSalida, $lugarSalida,
                $horaSalida, $fechaRegreso, $lugarRegreso, $horaRegreso, $itinerario, $actividades,
                $dniEncargado, $apellidoNombreEncargado, $cargo, $cantidadAlumnos, $cantDocentes, $cantAcompañantes,
                $nombreHospedaje, $domicilioHospedaje, $telefonoHospedaje, $localidadHospedaje,$gastosEstimativos, $anexo9
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
