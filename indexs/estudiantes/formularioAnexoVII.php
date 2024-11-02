<?php
    include '../../php/verificarSessionEstudiantes.php';
    $_SESSION['idSalida'] = $_GET['idSalida'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .telefono-container {
                display: flex; /* Usar flexbox */
                align-items: center; /* Alinear verticalmente al centro */
                margin-bottom: 5px; /* Espacio entre entradas */
            }

            .telefono-label {
                flex: 0 0 80%; /* Tomar el 70% del ancho */
            }

            .telefono-button {
                flex: 0 0 20%; /* Tomar el 30% del ancho */
                text-align: right; /* Alinear el botón a la derecha */
            }
            @media (max-width: 570px) { /* Pantallas pequeñas */
                .telefono-container {
                    flex-direction: column; /* Cambiar a columna */
                    /* align-items: stretch; Alinear al inicio */
                }

                .telefono-label {
                    flex: 0 0 auto; /* Tamaño automático para el label */
                    margin-right: 0; /* Eliminar el margen derecho */
                    margin-bottom: 5px; /* Espacio inferior para separación */
                }

                .telefono-button {
                    width: 100%;
                }
            }
        </style>
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
                <span><i class="icon-notebook"></i></span>
            </div>
            <div style="text-align: center;">
                <h2 style="color: black;">Formulario Salida</h2>
            </div>
            <br>

            <div class="tab-content mt-3" id="myTabContent"> 
                <!-- Anexo 7 -->
                <div class="tab-pane fade show active" id="anexo7" role="tabpanel" aria-labelledby="anexo7-tab">
                    <br>
                    <center><h2>Anexo VII</h2></center>
                    <br>
                    <div id="formAnexoVII">
                        <?php 
                        include ("../../php/traerAnexoVII.php"); ?>
                        <br><br>
                        <center><button type="submit" class="cargar" id="cargarAnexoVII">Cargar Anexo 7</button></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        
    // Obtener los elementos
    const obraSocialSi = document.getElementById('obraSocialSi');
    const obraSocialNo = document.getElementById('obraSocialNo');
    const obraSocialNombreDiv = document.getElementById('obraSocialNombreDiv');
    const obraSocialNumeroDiv = document.getElementById('obraSocialNumeroDiv');

    // Función para mostrar u ocultar los campos de obra social
    function toggleObraSocialFields() {
        if (obraSocialSi.checked) {
            // Mostrar los campos si "Sí" está seleccionado
            obraSocialNombreDiv.style.display = 'block';
            obraSocialNumeroDiv.style.display = 'block';
        } else {
            // Ocultar los campos si "No" está seleccionado
            obraSocialNombreDiv.style.display = 'none';
            obraSocialNumeroDiv.style.display = 'none';
        }
    }

    // Agregar eventos de cambio a los radio buttons
    obraSocialSi.addEventListener('change', toggleObraSocialFields);
    obraSocialNo.addEventListener('change', toggleObraSocialFields);

    // Llamar a la función al cargar la página para establecer el estado inicial
    toggleObraSocialFields();
</script>
    <script src="../../js/enviarFormularioEstudiantes.js"></script>
</body>
</html>