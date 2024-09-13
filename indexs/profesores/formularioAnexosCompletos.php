<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
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
                <a href="menuAdministrarSalidas.php" class="btn btn-warning ms-auto" style="color: white;">Atrás</a>
            </div>
        </nav>

        <div class="container mt-4">
            <h2>Menú de Anexos</h2>
            <br>
            <?php include("../../php/traerEstadoAnexos.php")?>
            <!-- Tabs -->
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
                <!-- Anexo 5 -->
                <div class="tab-pane fade show active" id="anexo5" role="tabpanel" aria-labelledby="anexo5-tab">
                    <h2>Anexo 5</h2>
                    <br>
                    <form id="formAnexo5" class="formulario" action="../../php/insertAnexoV.php" method="POST">
                        <!-- Sección de DNI -->
                        <div class="row mb-4">
                            <div class="col-md-4 col-12">
                                <label for="dniSearch" class="form-label">DNI:</label>
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
                                <label for="grupos" class="form-label">Grupos:</label>
                                <select id="grupos" name="grupos" class="form-control" required>
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
                                <label for="acompanante" class="form-label">Insertar Acompañante:</label>
                            </div>
                            <div class="col-md-4 col-12 mt-2">
                                <input type="text" class="form-control" id="dniAcompañante" name="dniAcompañante" placeholder="DNI" required pattern="\d{8}">
                            </div>
                            <div class="col-md-4 col-12 mt-2">
                                <input type="text" class="form-control" id="nombreAcompañante" name="nombreAcompañante" placeholder="Nombre y apellido" required>
                            </div>
                            <div class="col-md-4 col-12 mt-2">
                                <input type="number" class="form-control" id="edadAcompañante" name="edadAcompañante" placeholder="Edad" required>
                            </div>
                            <div class="col-12 mt-2 d-flex justify-content-center">
                                <button id="cargarAcompañante" type="button" class="btn btn-success w-50">Cargar Acompañante</button>
                            </div>
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
                        <div class="table-responsive">
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
                                    <!-- Contenido dinámico -->
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                
                <!-- Anexo 8 -->
                <div class="tab-pane fade" id="anexo8" role="tabpanel" aria-labelledby="anexo8-tab">
                    <h2>Anexo 8</h2>
                    <br>
                    <form id="formAnexoVIII" class="formulario" action="../../php/insertAnexoVIII.php" method="POST">
                        <?php include ("../../php/traerAnexoVIII.php"); ?>
                    </form>
                    <button type="submit" class="btn btn-success" id="cargarAnexoVIII">Cargar Anexo 8</button>
                </div>

                <!-- Anexo 9 -->
                <div class="tab-pane fade" id="anexo9" role="tabpanel" aria-labelledby="anexo9-tab">
                    <h2>Anexo 9</h2>
                    <br>
                    <form id="formAnexoIX" class="formulario">
                        <div class="mb-5">
                            <label for="razonSocial" class="form-label">Razon Social:</label>
                            <input type="text" class="form-control" id="razonSocial" name="razonSocial" placeholder="Ingrese la razón social" required>
                        </div>

                        <div class="mb-5">
                            <label for="domicilioTransporte" class="form-label">Domicilio del transporte:</label>
                            <input type="text" class="form-control" id="domicilioTransporte" name="domicilioTransporte" placeholder="Ingrese el domicilio del transporte" required>
                        </div>

                        <div class="mb-5">
                            <label for="telefonoTransporte" class="form-label">Teléfono del transporte:</label>
                            <input type="number" class="form-control" id="telefonoTransporte" name="telefonoTransporte" placeholder="Ingrese el número" required>
                        </div>

                        <div class="mb-5">
                            <label for="domicilioResponsable" class="form-label">Domicilio del responsable:</label>
                            <input type="text" class="form-control" id="domicilioResponsable" name="domicilioResponsable" placeholder="Ingrese el domicilio del responsable" required>
                        </div>

                        <div class="mb-5">
                            <label for="telefonoResponsable" class="form-label">Teléfono:</label>
                            <input type="number" class="form-control" id="telefonoResponsable" name="telefonoResponsable" placeholder="Ingrese el teléfono" required>
                        </div>

                        <div class="mb-5">
                            <label for="telefonoMovil" class="form-label">Teléfono Movil:</label>
                            <input type="number" class="form-control" id="telefonoMovil" name="telefonoMovil" placeholder="Ingrese el teléfono móvil" required>
                        </div>

                        <div class="mb-5">
                            <label for="titularidadVehiculo" class="form-label">Titularidad del vehículo:</label>
                            <input type="text" class="form-control" id="titularidadVehiculo" name="titularidadVehiculo" placeholder="Ingrese la titularidad del vehículo" required>
                        </div>

                        <div class="mb-5">
                            <label for="companiaAseguradora" class="form-label">Compañía aseguradora:</label>
                            <input type="text" class="form-control" id="companiaAseguradora" name="companiaAseguradora" placeholder="Ingrese la compañía aseguradora" required>
                        </div>

                        <div class="mb-5">
                            <label for="numeroPoliza" class="form-label">Número de póliza:</label>
                            <input type="number" class="form-control" id="numeroPoliza" name="numeroPoliza" placeholder="Ingrese el número de póliza" required>
                        </div>

                        <div class="mb-5">
                            <label for="tipoSeguro" class="form-label">Tipo de seguro:</label>
                            <input type="text" class="form-control" id="tipoSeguro" name="tipoSeguro" placeholder="Ingrese el tipo de seguro" required>
                        </div>

                        <div class="mb-5">
                            <label for="nombreConductor1" class="form-label">Nombre del Conductor 1:</label>
                            <input type="text" class="form-control" id="nombreConductor1" name="nombreConductor1" placeholder="Ingrese el nombre del conductor 1" required>
                        </div>

                        <!-- <div class="mb-5">
                            <label for="dniConductor1" class="form-label">DNI del Conductor 1:</label>
                            <input type="number" class="form-control" id="dniConductor1" name="dniConductor1" placeholder="Ingrese el DNI del conductor 1" required>
                        </div>

                        <div class="mb-5">
                            <label for="licenciaConductor1" class="form-label">Licencia del Conductor 1:</label>
                            <input type="number" class="form-control" id="licenciaConductor1" name="licenciaConductor1" placeholder="Ingrese la licencia del conductor 1" required>
                        </div>

                        <div class="mb-5">
                            <label for="vigenciaConductor1" class="form-label">Vigencia del Conductor 1:</label>
                            <input type="number" class="form-control" id="vigenciaConductor1" name="vigenciaConductor1" placeholder="Ingrese la vigencia de la licencia del conductor 1" required>
                        </div> -->

                        <div class="mb-5">
                            <label for="nombreConductor2" class="form-label">Nombre del Conductor 2:</label>
                            <input type="text" class="form-control" id="nombreConductor2" name="nombreConductor2" placeholder="Ingrese el nombre del conductor 2" required>
                        </div>

                        <!-- <div class="mb-5">
                            <label for="dniConductor2" class="form-label">DNI del Conductor 2:</label>
                            <input type="number" class="form-control" id="dniConductor2" name="dniConductor2" placeholder="Ingrese el DNI del conductor 2" required>
                        </div>

                        <div class="mb-5">
                            <label for="licenciaConductor2" class="form-label">Licencia del Conductor 2:</label>
                            <input type="number" class="form-control" id="licenciaConductor2" name="licenciaConductor2" placeholder="Ingrese la licencia del conductor 2" required>
                        </div>

                        <div class="mb-5">
                            <label for="vigenciaConductor2" class="form-label">Vigencia del Conductor 2:</label>
                            <input type="number" class="form-control" id="vigenciaConductor2" name="vigenciaConductor2" placeholder="Ingrese la vigencia de la licencia del conductor 2" required>
                        </div> -->
                    </form>
                    <button type="submit" class="btn btn-success" id="cargarAnexoIX">Cargar Anexo 9</button>
                </div>

                <!-- Anexo 10 -->
                <div class="tab-pane fade" id="anexo10" role="tabpanel" aria-labelledby="anexo10-tab">
                    <h2>Anexo 10</h2>
                    <br>
                    <form id="formAnexoX" class="formulario">
                        <div class="mb-5">
                            <label for="infraestructura" class="form-label">Infraestructura disponible:</label>
                            <input type="text" class="form-control" id="infraestructura" name="infraestructura" placeholder="Ingrese la infraestructura disponible" required>
                        </div>
                        <div class="mb-5">
                            <label for="hospitales" class="form-label">Hospitales disponibles:</label>
                            <input type="text" class="form-control" id="hospitales" name="hospitales" placeholder="Ingrese los hospitales disponibles" required>
                        </div>
                        <div class="mb-5">
                            <label for="mediosAlternativos" class="form-label">Medios alternativos:</label>
                            <input type="text" class="form-control" id="mediosAlternativos" name="mediosAlternativos" placeholder="Ingrese los medios alternativos" required>
                        </div>
                        <div class="mb-5">
                            <label for="datosOpcionales" class="form-label">Datos opcionales:</label>
                            <input type="text" class="form-control" id="datosOpcionales" name="datosOpcionales" placeholder="Ingrese los datos opcionales" required>
                        </div>
                    </form>
                    <button type="submit" class="btn btn-success" id="cargarAnexoX">Cargar Anexo 10</button>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="../../js/enviarFormularios.js"></script>
        <script>
            var salidaIDSesion = "<?php echo $idSalida; ?>";
            var anexoVIIIHabil = "<?php echo $anexoviiiHabil; ?>";
            var anexoIXHabil = "<?php echo $anexoixHabil; ?>";
            var anexoXHabil = "<?php echo $anexoxHabil; ?>";
        </script>
        <script src="../../js/accionesAnexoV.js"></script>
    </body>
</html>