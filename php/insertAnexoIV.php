<?php
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
        $cantidadAlumnos = $_POST['cantAlumnos'];
        $cantDocentesAcompañantes = $_POST['cantDocentes'];
        $cantNoDocentesAcompañantes = $_POST['cantNoDocentes'];
        $totalPersonas = $_POST['totalPersonas'];
        $nombreHospedaje = $_POST['nombreHospedaje'];
        $domicilioHospedaje = $_POST['domicilioHospedaje'];
        $telefonoHospedaje = $_POST['telefonoHospedaje'];
        $localidadHospedaje = $_POST['localidadHospedaje'];

        $sql = "INSERT INTO anexoiv (
            estado, tipoSolicitud, region, distrito, institucionEducativa, numeroInstitucion, domicilioInstitucion,
            telefonoInstitucion, denominacionProyecto, lugarVisita, fechaSalida, lugarSalida,
            horaSalida, fechaRegreso, lugarRegreso, horaRegreso, itinerario, actividades,
            dniEncargado, apellidoNombreEncargado, cargo, cantidadAlumnos, cantDocentesAcompañantes, cantNoDocentesAcompañantes,
            totalPersonas, nombreHospedaje, domicilioHospedaje, telefonoHospedaje, localidadHospedaje
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param(
                "iiissisissssssssssisiiiiissis",
                $estado, $tipoSolicitud, $region, $distrito, $institucionEducativa, $numeroInstitucion, $domicilioInstitucion,
                $telefonoInstitucion, $denominacionProyecto, $lugarVisita, $fechaSalida, $lugarSalida,
                $horaSalida, $fechaRegreso, $lugarRegreso, $horaRegreso, $itinerario, $actividades,
                $dniEncargado, $apellidoNombreEncargado, $cargo, $cantidadAlumnos, $cantDocentesAcompañantes, $cantNoDocentesAcompañantes,
                $totalPersonas, $nombreHospedaje, $domicilioHospedaje, $telefonoHospedaje, $localidadHospedaje
            );

            if ($stmt->execute()) {
                echo "Datos insertados correctamente";
            } else {
                echo "Error: " . $stmt->error;
                echo $sql;
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
