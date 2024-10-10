<?php
    session_start();
    error_reporting(0);
    // ini_set('display_errors', 1);

    if (!isset($_SESSION['dniProfesor'])) {
        header('Location: ../index.php');
        exit;
    }

    include('../../php/conexion.php');
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
    $idSalida = $_SESSION['idSalida'];
    if (!isset($idSalida)) {
        die("No se encontró idSalida en la sesión.");
    }

    $query = "SELECT estado FROM anexoiv WHERE idAnexoIV = ?";
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("i", $idSalida);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        if ($row = $result->fetch_assoc()) {
            if ($row['estado'] == 3) {
                // Si el estado es 3, redirige a menuSalidas
                header('Location: menuAdministrarSalidas.php');
                exit;
            } else {
                // echo "El estado no es 3. Estado actual: " . $row['estado'];
            }
        } else {
            // echo "No se encontraron resultados.";
        }
    } else {
        echo "Error en la consulta: " . $conexion->error;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu de Salidas</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/anexos.css">
    </head>
    <body>
        <nav class="navbar navbar-custom">
            <div class="container-fluid d-flex align-items-center">
                <a onclick="window.history.back();" class="btn btn-warning ms-auto" style="color: white;">Atrás</a>
            </div>
        </nav>

        <div class="registration-form">
            <div class="formulario-container">
                <div class="form-icon">
                    <span><i class="icon icon-pencil"></i></span>
                </div>
                <div style="text-align: center;">
                    <h2 style="color: black;">Menú de Anexos</h2>
                </div>
                <br>
                
                <?php include("../../php/traerEstadoAnexos.php")?>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="anexo5-tab" data-bs-toggle="tab" data-bs-target="#anexo5" type="button" role="tab" aria-controls="anexo5" aria-selected="true">Anexo 5</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="anexo8-tab" data-bs-toggle="tab" data-bs-target="#anexo8" type="button" role="tab" aria-controls="anexo8" aria-selected="false">Anexo 8</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="anexo9-tab" data-bs-toggle="tab" data-bs-target="#anexo9" type="button" role="tab" aria-controls="anexo9" aria-selected="false">Anexo 9</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="anexo10-tab" data-bs-toggle="tab" data-bs-target="#anexo10" type="button" role="tab" aria-controls="anexo10" aria-selected="false">Anexo 10</button>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="myTabContent"> 
                    <?php include('../../php/verificarInsertProfesorAV.php'); ?>
                    
                    <!-- Anexo 5 -->
                        <div class="tab-pane fade show active" id="anexo5" role="tabpanel" aria-labelledby="anexo5-tab">
                        <br>
                        <h2>Anexo 5</h2>
                        <br>
                        <form id="formAnexo5" class="formulario" action="../../php/insertAnexoV.php" method="POST">
                            <!-- Sección de DNI -->
                            <div class="row mb-4">
                                <div class="col-md-4 col-12">
                                    <label for="dniSearch" class="form-label">Insertar por DNI:</label>
                                    <input type="number" class="form-control" id="dniSearch" min = "0" oninput="validity.valid||(value='');" name="dniSearch" required pattern="\d{8}" placeholder="Insertar por DNI...">
                                </div>
                                <div class="col-md-4 col-12 mt-md-0 mt-2">
                                    <label for="coincidenciaPersona" class="form-label">Coincidencias:</label>
                                    <select class="form-control" name="coincidenciaPersona" id="coincidenciaPersona"></select>
                                </div>
                                <div class="col-md-4 col-12 mt-md-0 mt-2 d-flex align-items-end justify-content-center">
                                    <button type="button" id="agregarPersona" class="btn btn-success w-100">Cargar Persona</button>
                                </div>
                            </div>

                            <!-- Sección de Grupos -->
                            <div class="row mb-4">
                                <div class="col-md-8 col-12">
                                    <label for="grupos" class="form-label">Insertar por grupo:</label>
                                    <select id="grupos" name="grupos" class="form-control" style="cursor: pointer;" required>
                                        <?php include ('../../php/traerGrupos.php'); ?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12 mt-md-0 mt-2 d-flex align-items-end justify-content-center">
                                    <button type="button" class="btn btn-success w-100" id="cargarGrupo">Cargar Grupo</button>
                                </div>
                            </div>

                            <!-- Sección de Acompañante -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="acompanante" class="form-label">Insertar no docente:</label>
                                </div>
                                <div class="col-md-2 col-12 mt-2">
                                    <input type="text" class="form-control" id="dniAcompañante" name="dniAcompañante" placeholder="DNI..." required pattern="\d{8}">
                                </div>
                                <div class="col-md-4 col-12 mt-2">
                                    <input type="text" class="form-control" id="nombreAcompañante" name="nombreAcompañante" placeholder="Nombre y apellido..." required>
                                </div>
                                <div class="col-md-2 col-12 mt-2">
                                    <input type="number" class="form-control" id="edadAcompañante" name="edadAcompañante" placeholder="Edad..." required>
                                </div>
                                <div class="col-md-4 col-12 mt-2">
                                    <button id="cargarAcompañante" type="button" class="btn btn-success w-100">Cargar no docente</button>
                                </div>
                                <br>
                                <div id="advice" class="col-12" style="margin-top: 30px; text-align:center;">

                                </div>
                                <p style="margin-top: 5px;"><b>Atención:</b> Este panel es solamente una guía, la aprobación depende del Director.</p>
                            </div>
                            <div class="col-12 d-flex flex-row-reverse mb-1">
                                <button type="button" id="selectAll" class="btn btn-secondary">
                                    Seleccionar todo
                                </button>
                                <button type="button" id="eliminarSeleccionados" class="btn btn-danger mx-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-minus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                </button>
                            </div>

                            <!-- Tabla de Participantes -->
                            <div class="table-responsive" style="text-align: center;">
                                <table class="table table-striped-columns">
                                    <thead>
                                        <tr>
                                            <th scope="col">N°</th>
                                            <th scope="col">Apellido y Nombre</th>
                                            <th scope="col">Documento</th>
                                            <th scope="col">Alumno</th>
                                            <th scope="col">Edad</th>
                                            <th scope="col">Docente</th>
                                            <th scope="col">No Docente</th>
                                            <th scope="col">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaParticipantes">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>

                    <!-- Anexo 8 -->
                    <div class="tab-pane fade" id="anexo8" role="tabpanel" aria-labelledby="anexo8-tab">
                        <form id="formAnexoVIII" class="formulario" action="../../php/insertAnexoVIII.php" method="POST">
                            <br>
                            <h2>Anexo 8</h2>
                            <br>
                            <?php include ("../../php/traerAnexoVIII.php"); ?>
                        </form>
                        <button type="submit" class="btn btn-success" id="cargarAnexoVIII">Cargar Anexo 8</button>
                    </div>

                    <!-- Anexo 9 -->
                    <div class="tab-pane fade" id="anexo9" role="tabpanel" aria-labelledby="anexo9-tab">
                        <form id="formAnexoIX" class="formulario" enctype="multipart/form-data">
                            <br>
                            <h2>Anexo 9</h2>
                            <br>
                            <?php include ("../../php/traerAnexoIX.php"); ?>
                        </form>
                        <button type="submit" class="btn btn-success" id="cargarAnexoIX">Cargar Anexo 9</button>
                    </div>

                    <!-- Anexo 10 -->
                    <div class="tab-pane fade" id="anexo10" role="tabpanel" aria-labelledby="anexo10-tab">
                        <br>
                        <form id="formAnexoX" class="formulario" id="cargarAnexoX">
                            <h2>Anexo 10</h2>
                            <br>
                            <?php include ("../../php/traerAnexoX.php"); ?>
                        </form>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block create-account" id="cargarAnexoX">Cargar Anexo 10</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="../../js/enviarFormularios.js"></script>
        <script>
            var salidaIDSesion = "<?php echo $idSalida; ?>";
            var anexoIXHabil = "<?php echo $anexoixHabil; ?>";
        </script>
        <script src="../../js/accionesAnexoV.js"></script>

    </body>
</html>