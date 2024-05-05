<?php
    session_start();
    // echo $dniUsuario;
    if (empty($_SESSION['dni'])) {
        // Redirigir al usuario a la página de inicio
        header('Location: ../index.php');
        exit;
    }
    $dniUsuario = $_SESSION['dni'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salidas Educativas</title>
        <link rel="stylesheet" href="../librerias/bootstrap.css">
        <link rel="stylesheet" href="../css/estilos.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div id="content-wrapper">
            <nav class="navbar navbar-expand-lg bg-body-tertiary" style="color: gray;">
                <div class="container-fluid">
                    <img src="../imagenes/eest.webp" alt="" id="logo">
                    <a class="navbar-brand" id="title">Salidas Educativas</a>
                    <a href="../modulos/logout.php" class="btn btn-danger">Cerrar sesión</a>
                </div>
            </nav>
            <br><br>
            <h1 class="text-center mt-5">(Nombre del hijo)</h1>
            <div class="container" style="margin-top: 20px;">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card" id="card-aprobar">
                            <div class="card-header">
                                <h4>Seleccionar la salida</h4>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Aprobación de salidas</h5>
                                <p class="card-text">Aprobar salidas educativas. Las salidas pueden estar: Aprobadas, pendientes o canceladas/desaprobadas</p>
                                <a href="aprobar.php" class="btn btn-primary">Lista de salidas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../librerias/jquery.js?v=1"></script>
        <script src="../librerias/boostrap.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>