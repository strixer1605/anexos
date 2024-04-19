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
                    <a class="navbar-brand">Salidas Educativas</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Dropdown
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                            </li>
                        </ul>
                    </div>
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
                                <a href="#" class="btn btn-primary">Lista de salidas</a>
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
        <div>
            <img src="../imagenes/blancologo.webp" alt="" id="logo">
        </div>
    </footer>
</html>