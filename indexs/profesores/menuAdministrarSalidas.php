<?php
    session_start();
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
        <style>
            body {
                background-color: white;
                color: #fff;
                text-align: center;
            }
            .container {
                max-width: 900px;
                margin-top: 50px;
                padding: 30px;
                background-color: white;
                color: #000;
            }

            .navbar-custom {
                background-color: white;
                padding: 10px;
            }
            ul {
                padding-left: 0;
                list-style-type: none;
            }
            hr {
                border: 1px solid #D6D0D0;
                margin: 20px 0;
            }
            .botones {
                margin-bottom: 5px;
                max-width: 100%;
                height: auto !important;
                text-decoration: none !important;
                cursor: pointer;
                font-size: 16px;
                color: #000;
                border: 1px solid #ccc;
                transition: background-color 0.3s ease, border-color 0.3s ease;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            }

            .botones:focus,
            .botones:hover,
            .botones:active {
                border-color: transparent;
                outline: none;
            }

            .subtitulo {
                font-size: 24px;
                margin-bottom: 20px;
                font-weight: 400;
            }

            .btn-success {
                color: #fff;
                background-color: #5cb85c;
                border-color: #4cae4c;
            }
            .btn-primary {
                color: #fff;
                background-color: #337ab7;
                border-color: #2e6da4;
            }
        </style>
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
                        <li><a class="btn form-control botones w-100 mb-3">Salida 2</a></li>
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
            <button class="btn-primary form-control botones w-100 mb-5">Histórico de mis salidas</button>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
