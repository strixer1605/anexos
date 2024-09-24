<?php
    echo $_SESSION['nombreDoc'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $estado = 1;
        $tipoSolicitud = intval($_POST['tipoSalida']);
        $region = $_POST['region'];
        $distrito = $_POST['distrito'];
        $institucionEducativa = $_POST['institucionEducativa'];
        $numeroInstitucion = $_POST['numero'];
        $domicilioInstitucion = $_POST['domicilio'];
        $telefonoInstitucion = $_POST['telefono'];
        $denominacionProyecto = $_POST['denominacionProyecto'];
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
        $cargo = 1;
        $cantidadAlumnos = 0;
        $cantDocentesAcompañantes = 1;
        $cantNoDocentesAcompañantes = 0;
        $nombreHospedaje = $_POST['nombreHospedaje'];
        $domicilioHospedaje = $_POST['domicilioHospedaje'];
        $telefonoHospedaje = $_POST['telefonoHospedaje'];
        $localidadHospedaje = $_POST['localidadHospedaje'];
        $gastosEstimativos = $_POST['gastosEstimativos'];
        $anexo8 = isset($_POST['anexo8']) ? 1 : 0;
        $anexo9 = isset($_POST['anexo9']) ? 1 : 0;
        $anexo10 = isset($_POST['anexo10']) ? 1 : 0;

        $sql = "INSERT INTO anexoiv (
            estado, tipoSolicitud, region, distrito, institucionEducativa, numeroInstitucion, domicilioInstitucion,
            telefonoInstitucion, denominacionProyecto, lugarVisita, fechaSalida, lugarSalida,
            horaSalida, fechaRegreso, lugarRegreso, horaRegreso, itinerario, actividades,
            dniEncargado, apellidoNombreEncargado, cargo, cantidadAlumnos, cantDocentes, cantAcompañantes,
            totalPersonas, nombreHospedaje, domicilioHospedaje, telefonoHospedaje, localidadHospedaje, gastosEstimativos, anexoVIIIHabil, anexoIXHabil, anexoXHabil
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param(
                "iiissisissssssssssisiiiiississiii",
                $estado, $tipoSolicitud, $region, $distrito, $institucionEducativa, $numeroInstitucion, $domicilioInstitucion,
                $telefonoInstitucion, $denominacionProyecto, $lugarVisita, $fechaSalida, $lugarSalida,
                $horaSalida, $fechaRegreso, $lugarRegreso, $horaRegreso, $itinerario, $actividades,
                $dniEncargado, $apellidoNombreEncargado, $cargo, $cantidadAlumnos, $cantDocentesAcompañantes, $cantNoDocentesAcompañantes,
                $totalPersonas, $nombreHospedaje, $domicilioHospedaje, $telefonoHospedaje, $localidadHospedaje,$gastosEstimativos, $anexo8, $anexo9, $anexo10
            );

            if ($stmt->execute()) {
                header('Location: ../indexs/profesores/menuAdministrarSalidas.php¿');
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
?>
