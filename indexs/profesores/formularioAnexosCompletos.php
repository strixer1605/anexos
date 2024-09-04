<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu de Salidas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/formularioIV.css">
    </head>
    <body>
        <nav class="navbar navbar-custom">
            <div class="container-fluid d-flex align-items-center">
                <a href="menuAdministrarSalidas.php" class="btn btn-warning ms-auto" style="color: white;">Atrás</a>
            </div>
        </nav>

        <div class="container">
            <h2>Anexo 5</h2>
            <br>
            <form id="formAnexo5" class="formulario" action="../../php/insertAnexoV.php" method="POST">
                <label for="dni_search" class="form-label">DNI:</label>
                <div class="mb-5" style="display: flex; align-items: center;">
                    <input type="number" class="form-control" id="dni_search" name="dni_search" required pattern="\d{8}" placeholder="Insertar por DNI..." style="width: 91%; margin-right:10px;">
                    <button type="button" class="btn btn-success">
                        Cargar
                    </button>
                </div>
                <label for="cursos" class="form-label">Cursos:</label>
                <div class="mb-5" style="display: flex; align-items: center;">
                    <select id="cursos" name="cursos" class="form-control" required placeholder="Insertar por curso..." style="width: 91%; margin-right:10px;">
                        <option value="6C">6°C</option>
                        <option value="6B">6°B</option>
                        <option value="7A">7°A</option>
                        <option value="7C">7°C</option>
                    </select>
                    <button type="button" class="btn btn-success">
                        Cargar
                    </button>
                </div>

                <div class="mb-5">
                    <label for="acompanante" class="form-label">Insertar Acompañante:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="dni_acompanante" name="dni_acompanante" placeholder="DNI" required pattern="\d{8}">
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="nombre_acompanante" name="nombre_acompanante" placeholder="Nombre y apellido" required>
                    </div>
                    <div class="mb-2">
                        <input type="number" class="form-control" id="edad_acompanante" name="edad_acompanante" placeholder="Edad" required>
                    </div>
                    <button type="button" class="btn btn-success">
                        Cargar
                    </button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Nombre y apellido</th>
                            <th scope="col">Edad</th>
                            <th scope="col">Alumno</th>
                            <th scope="col">Docente</th>
                            <th scope="col">Acompañante</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </form>
            <br>
            <h2>Anexo 8</h2>
            <br>
            <form id="formAnexoXII" class="formulario" action="../../php/insertAnexoVIII .php" method="POST">
                <div class="mb-5">
                    <label for="institucion" class="form-label">Institución Educativa:</label>
                    <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Ingrese Institución" value="E.E.S.T. Nº1" required pattern="[A-Za-z\s]+">
                </div>
                <div class="mb-5">
                    <label for="anio" class="form-label">Año:</label>
                    <input type="number" class="form-control" id="anio" name="anio" placeholder="Ingrese Año" required>
                </div>
                <div class="mb-5">
                    <label for="division" class="form-label">División:</label>
                    <input type="text" class="form-control" id="division" name="division" placeholder="Ingrese División" required>
                </div>
                <div class="mb-5">
                    <label for="area" class="form-label">Área:</label>
                    <input type="text" class="form-control" id="area" name="area" placeholder="Ingrese Área" required>
                </div>
                <div class="mb-5">
                    <label for="docente" class="form-label">Docente:</label>
                    <input type="text" class="form-control" id="docente" name="docente" placeholder="Ingrese Docente" required>
                </div>
                <div class="mb-5">
                    <label for="objetivo" class="form-label">Objetivo:</label>
                    <input type="text" class="form-control" id="objetivo" name="objetivo" placeholder="Ingrese Objetivo" required>
                </div>
                <div class="mb-5">
                    <label for="fechaSalida" class="form-label">Fecha de la Salida:</label>
                    <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" required>
                </div>
                <div class="mb-5">
                    <label for="lugaresVisitar" class="form-label">Lugares a visitar:</label>
                    <input type="text" class="form-control" id="lugaresVisitar" name="lugaresVisitar" placeholder="Ingrese Lugares" required>
                </div>
                <div class="mb-5">
                    <label for="descPrevia" class="form-label">Descripción previa:</label>
                    <input type="text" class="form-control" id="descPrevia" name="descPrevia" placeholder="Ingrese Descripción" required>
                </div>
                <div class="mb-5">
                    <label for="respPrevia" class="form-label">Responsables (Previamente):</label>
                    <input type="text" class="form-control" id="respPrevia" name="respPrevia" placeholder="Ingrese Responsables" required>
                </div>
                <div class="mb-5">
                    <label for="obsPrevia" class="form-label">Observaciones (Previamente):</label>
                    <input type="text" class="form-control" id="obsPrevia" name="obsPrevia" placeholder="Ingrese Observaciones" required>
                </div>
                <div class="mb-5">
                    <label for="descDurante" class="form-label">Descripción (Durante):</label>
                    <input type="text" class="form-control" id="descDurante" name="descDurante" placeholder="Ingrese Descripción" required>
                </div>
                <div class="mb-5">
                    <label for="respDurante" class="form-label">Responsables (Durante):</label>
                    <input type="text" class="form-control" id="respDurante" name="respDurante" placeholder="Ingrese Responsables" required>
                </div>
                <div class="mb-5">
                    <label for="obsDurante" class="form-label">Observaciones (Durante):</label>
                    <input type="text" class="form-control" id="obsDurante" name="obsDurante" placeholder="Ingrese Observaciones" required>
                </div>
                <div class="mb-5">
                    <label for="descEvaluacion" class="form-label">Descripción (Evaluación):</label>
                    <input type="text" class="form-control" id="descEvaluacion" name="descEvaluacion" placeholder="Ingrese Descripción" required>
                </div>
                <div class="mb-5">
                    <label for="respEvaluacion" class="form-label">Responsables (Evaluación):</label>
                    <input type="text" class="form-control" id="respEvaluacion" name="respEvaluacion" placeholder="Ingrese Responsables" required>
                </div>
                <div class="mb-5">
                    <label for="obsEvaluacion" class="form-label">Observaciones (Evaluación):</label>
                    <input type="text" class="form-control" id="obsEvaluacion" name="obsEvaluacion" placeholder="Ingrese Observaciones" required>
                </div>
            </form>
            <br>
            <h2>Anexo 9</h2>
            <br>
            <form id="formularioSalidaIX" class="formulario">
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
            <br>
            <h2>Anexo 10</h2>
            <br>
            <form id="formularioSalidaX" class="formulario">
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
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success" id="cargar">Cargar</button>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../../js/enviarFormularios.js"></script>
    </body>
</html>