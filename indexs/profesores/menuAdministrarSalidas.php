<?php
    session_start();
    error_reporting(0);
    if (!isset($_SESSION['dniProfesor'])) {
        header('Location: ../index.php');
        exit;
    }
    include('../../php/conexion.php');
    
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

    $dni = $_SESSION['dniProfesor'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu de Salidas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/menuAdminSalidas.css">
    </head>
    <body>
        <nav class="navbar navbar-custom">
            <div class="container-fluid d-flex align-items-center">
                <a href="profesores.php" class="btn btn-warning ms-auto" style="color: white;">Atrás</a>
            </div>
        </nav>

        <div class="container">
            <h1>Administrar Salidas</h1>
            <br>
            <h2 class="subtitulo">Nuevas salidas</h2>
            <a href="formularioAnexoIV.php" class="btn-success form-control botones w-100 mb-5">Crear Salida</a>

            <div class="row mt-5">
                <div class="col-md-6">
                    <h3 class="subtitulo">Salidas Aprobadas</h3>
                    <hr>
                    <ul>
                        <?php include('../../php/traerSalidasAprobadasProfesor.php'); ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3 class="subtitulo">Salidas Pendientes</h3>
                    <hr>
                    <ul>
                        <?php include('../../php/traerSalidasPendientesProfesor.php'); ?>
                    </ul>
                </div>
            </div>
            <br><br>
            <a href="historico.php" class="btn-primary form-control botones w-100 mb-5">Histórico de mis salidas</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            window.onpopstate = function(event) {
                window.location.href = '../../indexs/profesores/menuAdministrarSalidas.php';
            };
        </script>
    </body>
</html>
