<?php
    include '../../php/verificarSessionPadres.php';

    $dniAlumno = $_SESSION['dniAlumno'];
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
    $idSalida = $_SESSION['idSalida'];
    error_reporting(0);

    // echo $dniAlumno;
    // echo $idSalida;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu de Salidas</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/padresAnexos.css">
    </head>
    <body>
        <nav class="navbar navbar-custom">
            <div class="container-fluid d-flex align-items-center">
                <button onclick="window.history.back()" class="btn btn-warning ms-auto" style="color: white;">Atrás</button>
            </div>
        </nav>

        <div class="registration-form">
            <div class="formulario-container">
                <div class="form-icon">
                    <span><i class="icon-heart"></i></span>
                </div>
                <div style="text-align: center;">
                    <h2 style="color: black;">Anexo 6</h2>
                    <h4 style="color: black;">(Constancia médica)</h4>
                </div>
                    <br>
                    <?php include('../../php/traerAnexoVI.php') ?>
                    <center><button type="submit" class="cargar" id="cargarAnexoVI">Cargar Anexo 6</button></center>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            window.onload = function() {
                toggleMedicacionInput(document.getElementById('obraSi').checked);
            };

            function toggleMedicacionInput(show) {
                document.getElementById('nomInput').style.display = show ? 'block' : 'none';
                document.getElementById('nroInput').style.display = show ? 'block' : 'none';
            }
        </script>
        <script src="../../js/enviarFormulariosPadres.js"></script>
    </body>
</html>