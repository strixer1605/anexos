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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/formularioIV.css">
    </head>
    <body>
        <nav class="navbar navbar-custom">
            <div class="container-fluid d-flex align-items-center">
                <button onclick="window.history.back()" class="btn btn-warning ms-auto" style="color: white;">Atrás</button>
                </div>
            </nav>

        <div class="container mt-4">
            <h2>Menú de Anexos</h2>
            <medium class="form-text text-muted">Si desea modificar la informacion solo cargue denuevo el formulario.</medium>

            <br>
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="anexo6-tab" data-bs-toggle="tab" data-bs-target="#anexo6" type="button" role="tab" aria-controls="anexo6" aria-selected="true">Anexo 6</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="anexo7-tab" data-bs-toggle="tab" data-bs-target="#anexo7" type="button" role="tab" aria-controls="anexo7" aria-selected="false">Anexo 7</button>
                </li>
            </ul>

            <div class="tab-content mt-3" id="myTabContent"> 
                <!-- Anexo 6 -->
                <div class="tab-pane fade show active" id="anexo6" role="tabpanel" aria-labelledby="anexo6-tab">
                    <h2>Anexo 6</h2>
                    <br>
                        <?php include('../../php/traerAnexoVI.php') ?>
                        
                        <center><button type="submit" class="btn btn-success mt-2" id="cargarAnexoVI">Cargar Anexo 6</button></center>
                </div>
                
                <!-- Anexo 7 -->
                <div class="tab-pane fade" id="anexo7" role="tabpanel" aria-labelledby="anexo7-tab">
                    <h2>Anexo 7</h2>
                    <br>
                    <div id="formAnexoVII">
                            <?php include ("../../php/traerAnexoVII.php"); ?>
                        <button type="submit" class="btn btn-success" id="cargarAnexoVII">Cargar Anexo 7</button>
                    </div>

                </div>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            

            // Mostrar/ocultar inputs de alergias y medicación
            function toggleAlergiaInput(show) {
                document.getElementById('alergiaInput').style.display = show ? 'block' : 'none';
            }

            function toggleMedicacionInput(show) {
                document.getElementById('medicacionInput').style.display = show ? 'block' : 'none';
            }

            function toggleOtrasInput() {
                const otrasCheckbox = document.getElementById('otras');
                const otrasInput = document.getElementById('otrasInput');
                otrasInput.style.display = otrasCheckbox.checked ? 'block' : 'none';
            }

            function toggleObraSocialMensaje(show) {
                document.getElementById('obraSocialMensaje').style.display = show ? 'block' : 'none';
            }
        </script>
        <script src="../../js/enviarFormulariosPadres.js"></script>
    </body>
</html>