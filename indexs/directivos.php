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
            <h1 class="text-center mt-5">Bienvenido, Salvado!</h1>
            <div class="container" style="margin-top: 20px;">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card" id="card-aprobar">
                            <div class="card-header">
                                Anexos
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
            <!-- Agregar un h1 aquí -->
            <h1 class="text-center mt-5">Hijos a cargo</h1>
            <!-- Fin de agregar h1 -->
            <div class="container" style="margin-bottom: 20px; margin-top:20px;">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card small-card" style="margin-bottom: 20px;">
                            <div class="card-body">
                                <h5 class="card-title">Nombre del hijo</h5>
                                <p class="card-text">Curso</p>
                                <a href="#" class="btn btn-primary">Inscribir</a>
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
    <footer>
        <img src="../imagenes/blancologo.webp" alt="" id="logofooter">
        <div class="footer-text">
            <p>
                DATOS DE CONTACTO:<br>
                Dirección: Calle 104 y 124. Santa teresita<br>
                Teléfono: (02246) 420535 Fax: 423529<br>
                E-mail: eest1lacosta@gmail.com
            </p>
        </div>
    </footer>
</html>