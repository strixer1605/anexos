<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="../librerias/jquery.js?v=1" ></script>
        <link rel="stylesheet" href="../librerias/bootstrap.css">
        <link rel="stylesheet" href="../css/estilos.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>Menu</title>
    </head>
    <body>
        <a href="../modulos/logout.php" class="btn btn-danger">Cerrar sesión</a>
        <div class="row justify-content-center ">
            <div class="col-6">
                <h2 class="col-12 text-center mt-4">Opciones</h2>
                <div class="col-12 text-center mt-4">
                    <a href="salidasMenu.php" class="btn border-bottom border-top form-control" style="width: 100%;">Salidas Educativas</a>
                </div>
            </div>
            <div class="col-6">
                <h2 class="col-12 text-center mt-4">Hijos a Cargo</h2>
                <div class="col-12 text-center mt-4">
                    <?php
                        session_start();
                        if (empty($_SESSION['dni'])) {
                            // Redirigir al usuario a la página de inicio
                            header('Location: ../index.php');
                            exit;
                        }

                        include('../../modulos/config.php');
                        include('../../modulos/conexionescuela.php');

                        $dniPadre = $_SESSION['dni'];

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
                                        // Enlace con href que apunta a la página "salidas hijo"
                                        echo '<a href="../salidasHijos.php?dniAlumno='.$dniAlumno.'" class="btn border-bottom border-top form-control" style="width: 100%;">'.$apellidoAlumno.' '.$nombreAlumno.'</a><br><br>';
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
        <script src="../librerias/jquery.js?v=1"></script>
        <script src="../librerias/boostrap.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>