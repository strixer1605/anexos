<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salidas Educativas</title>
        <link rel="stylesheet" href="../../css/menuSalidas.css" type="text/css"></link>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg bg-dark" style="color: white; padding: 10px;">
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="../../imagenes/eest.webp" style="height:80px;">
                    <a class="navbar-brand" id="title" style="color: white; font-size:25px; margin-left: 30px;">Salidas Educativas</a>
                </div>
                <a href="profesores.php" class="btn btn-warning" style="color: white;">Atrás</a>
            </div>
        </nav>
        <br>

        <div class="d-flex align-items-center justify-content-center" style="height: calc(100vh - 120px);">
            <div class="container-custom">
                <header class="text-center">
                    <h3 class="my-0 mt-3" style="color: black; padding: 10px;">Administrar Salidas Educativas</h3>
                </header>

                <button class="btn btn-primary btn-create">Crear nueva salida</button>
                <h4>Pendientes</h4>
                <div class="salida-list">
                    <button class="btn btn-outline-primary salida-item">Salida n°1</button>
                </div>

                <button class="btn btn-secondary btn-history">Histórico de mis salidas</button>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybIVM2YBWrQQTg4lH/7f2P1UqlpHxG9hjMC4LbWRz4Pp0R8Z+" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pDf7OALdM4Od8J7LvUsTfS7xkz+G3EC5R61b74pOUmGHxRcICJrwwC69az6LaNB4" crossorigin="anonymous"></script>
        <script>
        </script>
    </body>
</html>
