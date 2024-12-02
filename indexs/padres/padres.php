<?php
    session_start();

    if (empty($_SESSION['dniPadre'])) {
        header('Location: ../../index.php');
        exit;
    }

    include('../../php/conexion.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu de Inicio</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <br><a href="../../php/logout.php" class="btn btn-danger">Cerrar sesión</a>
            <div class="row justify-content-center ">
                <div class="col-6">
                    <h2 class="col-12 text-center mt-4">Alumnos a cargo</h2>
                    <div class="col-12 text-center mt-4">
                    <?php
                        $dniPadre = $_SESSION['dniPadre'];

                        $hijoSQL = "SELECT `dni_alumnos` FROM `padresalumnos` WHERE dni_padrestutores = '$dniPadre'";

                        $resultadoHijos = mysqli_query($conexion, $hijoSQL);
                        if ($resultadoHijos) {
                            while ($filaHijo = mysqli_fetch_assoc($resultadoHijos)) {

                                $dniAlumno = $filaHijo['dni_alumnos'];

                                $alumnoSQL = "SELECT `nombre`, `apellido` FROM `alumnos` WHERE dni = '$dniAlumno'";
                                $resultadoAlumno = mysqli_query($conexion, $alumnoSQL);

                                if ($resultadoAlumno) {
                                    while ($datosAlumno = mysqli_fetch_assoc($resultadoAlumno)) {
                                        $nombreAlumno = $datosAlumno['nombre'];
                                        $apellidoAlumno = $datosAlumno['apellido'];

                                        echo '<a href="../../php/traerDatosHijoSalida.php?dniAlumno='.$dniAlumno.'" class="btn border-bottom border-top form-control" style="width: 100%;">'.$apellidoAlumno.' '.$nombreAlumno.'</a><br><br>';
                                    }
                                } else {
                                    echo "Error al obtener datos del alumno";
                                }
                            }
                        } else {
                            echo "Error al obtener DNIs de los alumnos asociados al padre";
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>