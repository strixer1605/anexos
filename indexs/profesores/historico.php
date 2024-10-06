<?php
    session_start();
    if (!isset($_SESSION['dniProfesor'])) {
        header('Location: ../index.php');
        exit;
    }
    include('../../php/conexion.php');
    $idSalida = $_SESSION['idSalida'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu de Salidas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/historico.css">
    </head>
    <nav class="navbar navbar-custom">
        <div class="container-fluid d-flex align-items-center">
            <a onclick="window.history.back();" class="btn btn-warning ms-auto" style="color: white;">Atrás</a>
        </div>
    </nav>
    <body>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-md">
                    <h1>Histórico de mis salidas</h1>
                    <hr>
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Tipo de salida</th>
                                <th>Denominación</th>
                                <th>Estado final</th>
                                <th>Duración de la salida</th>
                                <th>Lugar visita</th>
                                <th>Fecha salida</th>
                                <th>Fecha regreso</th>
                                <th>Anexo 9</th>
                                <th>Fecha límite (entrega)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include('../../php/traerHistoricoSalidas.php'); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
