<?php
    include('../modulos/conexion.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre_del_proyecto =  $_POST['nombre_del_proyecto'];
        $denominacion_proyecto = $_POST['denominacion_proyecto'];
        $lugar_a_visitar = $_POST['lugar_a_visitar'];
        $apellido_y_nombre = $_POST['apellido_y_nombre'];
        $cargo = $_POST['cargo'];
        $fecha1 =  $_POST['fecha1'];
        $lugar1 =  $_POST['lugar1'];
        $fecha2 =  $_POST['fecha2'];
        $lugar2 =  $_POST['lugar2'];
        $intenerario =  $_POST['intenerario'];
        $actividades =  $_POST['actividades'];
        $cantidad_de_alumnos =  $_POST['cantidad_de_alumnos'];
        $cantidad_de_docentes_acompañantes =  $_POST['cantidad_de_docentes_acompañantes'];
        $cantidad_de_no_docentes_acompañantes =  $_POST['cantidad_de_no_docentes_acompañantes'];
        $total_de_personas =  $_POST['total_de_personas'];
        $hospedaje =  $_POST['hospedaje'];
        $domicilio_del_hospedaje =  $_POST['domicilio_del_hospedaje'];
        $telefono_del_hospedaje =  $_POST['telefono_del_hospedaje'];
        $localidad_del_hospedaje =  $_POST['localidad_del_hospedaje'];

        $sql = "INSERT INTO `anexo_iv`(`nombre_del_proyecto`, `denominacion_proyecto`, `lugar_a_visitar`, `fecha1`, `lugar1`, `fecha2`, `lugar2`, `intenerario`, `actividades`,
        `apellido_y_nombre`, `cargo`, `cantidad_de_alumnos`, `cantidad_de_docentes_acompañantes`, `cantidad_de_no_docentes_acompañantes`,
        `total_de_personas`, `hospedaje`, `domicilio_del_hospedaje`, `telefono_del_hospedaje`, `localidad_del_hospedaje`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssssssssiiiissis", $nombre_del_proyecto, $denominacion_proyecto, $lugar_a_visitar, $fecha1, $lugar1, $fecha2, $lugar2,
        $intenerario, $actividades, $apellido_y_nombre, $cargo, $cantidad_de_alumnos, $cantidad_de_docentes_acompañantes, $cantidad_de_no_docentes_acompañantes,
        $total_de_personas, $hospedaje, $domicilio_del_hospedaje, $telefono_del_hospedaje, $localidad_del_hospedaje);

        // Execute the statement
        if ($stmt->execute()) {
            echo 'Se guardó correctamente.';
        } else {
            echo 'Se produjo un error al guardar: ' . $conexion->error;
        }

        // Close statement
        $stmt->close();
    }
?>