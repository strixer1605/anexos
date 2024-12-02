<?php include '../../php/verificarSessionEstudiantes.php'; ?>

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
                    <h2 class="col-12 text-center mt-4">Opciones</h2>
                    <div class="col-12 text-center mt-4">
                        <?php
                            if ($edad >= 18) {
                                echo '
                                    <a href="estudiantesSalidas.php" class="btn border-bottom border-top form-control" style="width: 100%;">Salidas Educativas</a><br><br>
                                ';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>