<?php
    session_start();
    include('conexion.php');
    include('conexionescuela.php');

    if (isset($_SESSION['dni_profesor'])) {
        $dni = $_SESSION['dni_profesor'];
        $sql = "SELECT * FROM padrestutores WHERE dni = '$dni' AND ocupacion LIKE 'DOCENTE'";
        $result_doc = $conexion->query($sql);

        if ($result_doc && $result_doc->num_rows > 0) {
            $row = $result_doc->fetch_assoc();
            $_SESSION['nombre_doc'] = $row['nombre'];
            $_SESSION['apellido_doc'] = $row['apellido'];
            $_SESSION['ocup_doc'] = $row['ocupacion'];
            $_SESSION['telef_doc'] = $row['telefono'];

            $hijoSQL = 'SELECT `dni_alumnos` FROM `padresalumnos` WHERE `dni_padrestutores` = "' . $dni . '"';
            $resultadoHijos = mysqli_query($conexion, $hijoSQL);

            if ($resultadoHijos) {
                $hijos = [];
                while ($filaHijo = mysqli_fetch_assoc($resultadoHijos)) {
                    $dniAlumno = $filaHijo['dni_alumnos'];
                    echo $dniAlumno;
                    $alumnoSQL = "SELECT * FROM `alumnos` WHERE dni = '$dniAlumno'";
                    $resultadoAlumno = mysqli_query($conexion, $alumnoSQL);

                    if ($resultadoAlumno) {
                        while ($datosAlumno = mysqli_fetch_assoc($resultadoAlumno)) {
                            $hijos[] = $datosAlumno;
                        }
                    }
                }
                $_SESSION['hijos'] = $hijos; // Almacena los datos de los hijos en la sesión
            } else {
                $_SESSION['error'] = "Error al obtener DNIs de los alumnos asociados al padre";
            }
        } else {
            header('Location: error.php');
            exit;
        }
        $conexion->close();
    } else {
        header('Location: ../index.php');
        exit;
    }

    header("Location: ../indexs/profesores/profesores.php");
    exit;
?>
