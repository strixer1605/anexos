<?php
    session_start();
    include('conexion.php');
    include('conexionescuela.php');

    if (isset($_SESSION['dni_director'])) {
        $dni_dir = $_SESSION['dni_director'];
        $sql_dir = "SELECT * FROM padrestutores WHERE dni = '$dni_dir' AND ocupacion LIKE 'DIRECTOR'";
        $result_dir = $conexion->query($sql_dir);

        if ($result_dir && $result_dir->num_rows > 0) {
            $row = $result_dir->fetch_assoc();
            $_SESSION['nombre_dir'] = $row['nombre'];
            $_SESSION['apellido_dir'] = $row['apellido'];
            $_SESSION['ocup_dir'] = $row['ocupacion'];
            $_SESSION['telef_dir'] = $row['telefono'];

            $hijoSQL = 'SELECT `dni_alumnos` FROM `padresalumnos` WHERE `dni_padrestutores` = "' . $dni_dir . '"';
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

    header("Location: ../indexs/director/directivos.php");
    exit;
?>
