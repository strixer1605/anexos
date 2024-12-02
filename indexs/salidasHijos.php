<?php
    session_start();

    if (isset($_SESSION['dniProfesor'])) {
        $dniPadre = $_SESSION['dniProfesor'];
    } elseif (isset($_SESSION['dniDirector'])) {
        $dniPadre = $_SESSION['dniDirector'];
    } elseif (isset($_SESSION['dniPadre'])) {
        $dniPadre = $_SESSION['dniPadre'];
    } else {
        header('Location: ../index.php');
        exit;
    }

    if (empty($dniPadre)) {
        header('Location: ../index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salidas Educativas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-custom" style="padding: 10px;">
            <div class="container-fluid d-flex align-items-center">
                <a onclick="window.history.back();" class="btn btn-warning ms-auto"  style="color: white; font-family: system-ui;">Atrás</a>
            </div>
        </nav>
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-6">
                    <h2 class="col-12 text-center mt-4">Opciones</h2>
                    <div class="col-12 text-center mt-4">
                        <a href="hijos/hijosMenu.php" class="btn border-bottom border-top form-control" style="width: 100%;">Salidas Educativas</a><br><br>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>