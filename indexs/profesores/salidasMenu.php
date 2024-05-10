<?php
    session_start();
    if (empty($_SESSION['dni']) || empty($_SESSION['nombre_profesor']) || empty($_SESSION['apellido_profesor'])) {
        header('Location: ../index.php');
        exit;
    }
    $dni_encargado = $_SESSION['dni'];
    include('../../modulos/conexion.php');

    $sql = "SELECT `id`, `estado`, `nombre_del_proyecto`, `fecha_modificacion` FROM `anexo_iv` WHERE dni_encargado=$dni_encargado AND estado = 1";
    $anexoiv = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salidas Educativas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../../librerias/bootstrap.css">
        <link rel="stylesheet" href="../../css/salidasMenu.css">
    </head>
    <body>
        <div id="content-wrapper">
            <nav class="navbar navbar-expand-lg bg-body-tertiary" style="color: gray;">
                <div class="container-fluid">
                    <img src="../../imagenes/eest.webp" alt="" id="logo">
                    <a class="navbar-brand" id="title">Salidas Educativas</a>
                    <a href="profesores.php" class="btn btn-warning" style="color: white;">Atrás</a>
                </div>
            </nav>
            <h1 class="text-center mt-5">Administración</h1>
            <div class="row justify-content-center ">
                <div class="col-6">
                    <h2 class="col-12 text-center mt-4">Opciones</h2>
                    <div class="col-12 text-center mt-4">
                        <div class="container" style="margin-top: 20px;">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <a href="../../anexo4/anexo4.php" class="btn-success form-control botones" style="text-decoration:none;">Crear Salida Educativa</a>
                                    <br>
                                    <!-- <a href="" class="btn-primary form-control botones">Opcion extra</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <h2 class="col-12 text-center mt-4">Salidas en proceso a cargo</h2>
                    <div class="col-12 text-center mt-4">
                        <div class="container" style="margin-top: 20px;">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <?php 
                                        if (mysqli_num_rows($anexoiv) > 0) {
                                            $firstRow = mysqli_fetch_assoc($anexoiv);
                                            echo '<div class="d-inline-flex align-items-center">';
                                            echo '<p class="btn border form-control mb-0" style="cursor: text; width: 250px;">' . $firstRow['nombre_del_proyecto'] . '</p>';
                                            echo '<a href="../../anexo5/anexo5.php?id=' . $firstRow['id'] . '&nombre=' . urlencode($firstRow['nombre_del_proyecto']) . '" class="btn btn-sm btn-success botones" style="text-decoration: none; margin-left: 5px; height: auto; font-size:16px; padding:5px;">Participantes</a>';
                                            echo '<a href="../../anexo8/anexo8.php?id=' . $firstRow['id'] . '&nombre=' . urlencode($firstRow['nombre_del_proyecto']) . '" class="btn btn-sm btn-primary botones" style="text-decoration: none; margin-left: 5px; height: auto; font-size:16px; padding:5px;">Actividades</a>';
                                            echo '</div>';

                                            while ($resp = mysqli_fetch_assoc($anexoiv)) {
                                                echo '<div class="d-inline-flex align-items-center mt-2">';
                                                echo '<p class="btn border form-control mb-0" style="cursor: text; width: 250px;">' . $resp['nombre_del_proyecto'] . '</p>';
                                                echo '<a href="../../anexo5/anexo5.php?id=' . $resp['id'] . '&nombre=' . urlencode($resp['nombre_del_proyecto']) . '" class="btn btn-sm btn-success botones" style="text-decoration: none; margin-left: 5px; height: auto; font-size:16px; padding:5px;">Participantes</a>';
                                                echo '<a href="../../anexo8/anexo8.php?id=' . $resp['id'] . '&nombre=' . urlencode($resp['nombre_del_proyecto']) . '" class="btn btn-sm btn-primary botones" style="text-decoration: none; margin-left: 5px; height: auto; font-size:16px; padding:5px;">Actividades</a>';
                                                echo '</div>';
                                            }
                                        } else {
                                            echo '<p>No hay salidas disponibles.</p>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../../librerias/jquery.js?v=1"></script>
        <script src="../../librerias/boostrap.js"></script>
    </body>
</html>
