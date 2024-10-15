<?php
    include '../../php/verificarSessionDirector.php';
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

    $dniDirector = $_SESSION['dniDirector'];
    $nombreDir = $_SESSION['nombreDir'];
    $apellidoDir = $_SESSION['apellidoDir'];
    $nombreCompletoDirector = $nombreDir." ".$apellidoDir;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Anexo IV - Salidas Educativas</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/adminSalidas.css">
    </head>
    <body>
        <a href="directivo.php" class="btn btn-warning" style="color: white;">Atrás</a>
        <div class="registration-form">
            <form>
                <div class="form-icon">
                    <span><i class="icon icon-pencil"></i></span>
                </div>
                <div style="text-align: center;">
                    <h2 style="color: black;">Adminstador de salidas</h2>
                </div>
                <br>
                <nav class="navbar navbar-expand-lg bg-dark" style="color: white; padding: 10px;">
                    <div class="container-fluid d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="../../imagenes/eest.webp" style="height:70px;">
                            <a class="navbar-brand" id="title" style="color: white; font-size:25px; margin-left: 15px;">Solicitudes</a>
                        </div>
                    </div>
                </nav>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Nº</th>
                                        <th>Nombre del Proyecto</th>
                                        <th>Tipo de Salida</th>
                                        <th>Lugar a Visitar</th>
                                        <th>Fecha de Salida</th>
                                        <th>Fecha de Regreso</th>
                                        <th>¿Menos De 24hs?</th>
                                        <th>¿Anexo IX?</th>
                                        <th>¿Anexos Completos?</th>
                                        <th>Fecha Límite</th>
                                        <th>Documento (PDF)</th>
                                        <th>Gestionar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody id="proyectosTabla">
                                </tbody>
                            </table>
                        </div>    
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center gap-2">
                    <a href="historicoDir.php" class="btn btn-block create-account" id="historicoButton">Histórico Salidas</a>
                    <a href="historicoDir.php" class="btn btn-block create-account" id="historicoButton">Descarga Anexo 11</a>
                </div>
            </form>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/date-fns@4.1/cdn.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../../js/adminSalidas.js"></script>    
    </body>
</html>