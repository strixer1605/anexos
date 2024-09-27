<?php
    session_start();
    if (!isset($_SESSION['dniProfesor'])) {
        header('Location: ../index.php');
        exit;
    }
    include('../../php/conexion.php');
    
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

    $dniProfesor = $_SESSION['dniProfesor'];
    $nombrePro = $_SESSION['nombreDoc'];
    $apellidoPro = $_SESSION['apellidoDoc'];
    $nombreCompletoProfesor = $nombrePro." ".$apellidoPro;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu de Salidas</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            <h2>Anexo IV (Carga)</h2>
            <br>
            <form id="formAnexoIV" class="formulario" action="../../php/insertAnexoIV.php" method="POST">
                <div class="anexos-section">
                    <label>¿Utilizar Anexo 9?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="anexo9" name="anexo9" value="true" checked>
                        <label class="form-check-label" for="anexo9">Anexo 9</label>
                    </div>
                </div>

                <label>Tipo de Salida:</label><br>
                <div class="form-check-radio">
                    <input type="radio" id="representacion" name="tipoSalida" value="1" class="radiobutton">
                    <label for="representacion" class="form-check-label">Salida de Representación Institucional</label>
                </div>
                <div class="form-check-radio">
                    <input type="radio" id="educativa" name="tipoSalida" value="2" class="radiobutton">
                    <label for="educativa" class="form-check-label">Salida Educativa</label>
                </div>
                <br>
                <label>Distancia de salida:</label><br>
                <div class="form-check-radio mb-2">
                    <input type="radio" id="clase1" name="distanciaSalida" value="1" class="radiobutton">
                    <label for="clase1" class="form-check-label">Dentro del barrio o área geográfica inmediata.</label>
                </div>
                <div class="form-check-radio mb-2">
                    <input type="radio" id="clase2" name="distanciaSalida" value="2" class="radiobutton">
                    <label for="clase2" class="form-check-label">Dentro del Distrito o Distrito limítrofe (Dentro o fuera de la región)</label>
                </div>
                <div class="form-check-radio mb-2">
                    <input type="radio" id="clase3" name="distanciaSalida" value="3" class="radiobutton">
                    <label for="clase3" class="form-check-label">Dentro del Distrito con más de 24 horas de duración.</label>
                </div>
                <div class="form-check-radio mb-2">
                    <input type="radio" id="clase4" name="distanciaSalida" value="4" class="radiobutton">
                    <label for="clase4" class="form-check-label">Fuera del Distrito, no limítrofe, con regreso en el día.</label>
                </div>
                <div class="form-check-radio mb-2">
                    <input type="radio" id="clase5" name="distanciaSalida" value="5" class="radiobutton">
                    <label for="clase5" class="form-check-label">Fuera del Distrito por más de 24 de duración (No limítrofe, dentro de la Región)</label>
                </div>
                <div class="form-check-radio mb-2">
                    <input type="radio" id="clase6" name="distanciaSalida" value="6" class="radiobutton">
                    <label for="clase6" class="form-check-label">Fuera de la Región, a ciudades de otras Regiones no limitrofes (Regreso en el día).</label>
                </div>
                <div class="form-check-radio mb-2">
                    <input type="radio" id="clase7" name="distanciaSalida" value="7" class="radiobutton">
                    <label for="clase7" class="form-check-label">Fuera de la Región (EXCEPCIÓN) (Más de 24 horas de duración)</label>
                </div>
                <div class="form-check-radio mb-2">
                    <input type="radio" id="clase8" name="distanciaSalida" value="8" class="radiobutton">
                    <label for="clase8" class="form-check-label">Fuera de la Provincia de Buenos Aires.</label>
                </div>
                <div class="form-check-radio mb-2">
                    <input type="radio" id="clase9" name="distanciaSalida" value="9" class="radiobutton">
                    <label for="clase9" class="form-check-label">Fuera del País.</label>
                </div>
                <br>
                <div class="mb-5 d-none">
                    <label for="region" class="form-label">Región:</label>
                    <input type="number" class="form-control" id="region" name="region" placeholder="Ingrese la región" required pattern="[A-Za-z\s]+" value="18" readonly>
                </div>

                <div class="mb-5 d-none">
                    <label for="distrito" class="form-label">Distrito:</label>
                    <input type="text" class="form-control" id="distrito" name="distrito" placeholder="Ingrese el distrito" required pattern="[A-Za-z\s]+" value="La Costa" readonly>
                </div>

                <div class="mb-5 d-none">
                    <label for="institucionEducativa" class="form-label">Institución Educativa:</label>
                    <input type="text" class="form-control" id="institucionEducativa" name="institucionEducativa" placeholder="Ingrese la institución educativa" required pattern="[A-Za-z\s\.]+" value="E.E.S.T." readonly>
                </div>

                <div class="mb-5 d-none">
                    <label for="numero" class="form-label">N°:</label>
                    <input type="number" class="form-control" id="numero" name="numero" placeholder="Ingrese el número" required pattern="\d+" value="1" readonly>
                </div>

                <div class="mb-5 d-none">
                    <label for="domicilioInstitucion" class="form-label">Domicilio:</label>
                    <input type="text" class="form-control" id="domicilioInstitucion" name="domicilio" placeholder="Ingrese el domicilio" required value="Calle 104 y 124" readonly>
                </div>

                <div class="mb-5 d-none">
                    <label for="telefonoInstitucion" class="form-label">Teléfono:</label>
                    <input type="number" class="form-control" id="telefonoInstitucion" name="telefono" placeholder="Ingrese el teléfono" required pattern="\d{10}" value="2246420535" readonly>
                </div>

                <div class="mb-5">
                    <label for="denominacionProyecto" class="form-label">Denominación del Proyecto:</label>
                    <input type="text" class="form-control" id="denominacionProyecto" name="denominacionProyecto" placeholder="Ingrese la denominación del proyecto..." required>
                </div>

                <div class="mb-5">
                    <label for="localidadViaje" class="form-label">Localidad a Visitar:</label>
                    <input type="text" class="form-control" id="localidadViaje" name="localidadViaje" placeholder="Ingrese la localidad a visitar..." required>
                </div>

                <div class="mb-5">
                    <label for="lugarVisitar" class="form-label">Lugar a Visitar:</label>
                    <input type="text" class="form-control" id="lugarVisitar" name="lugarVisitar" placeholder="Ingrese el lugar a visitar..." required>
                </div>

                <div class="mb-5">
                    <label for="fechaSalida" class="form-label">Fecha de Salida:</label>
                    <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" required>
                </div>

                <div class="mb-5">
                    <label for="lugarSalida" class="form-label">Lugar de Salida:</label>
                    <input type="text" class="form-control" id="lugarSalida" name="lugarSalida" placeholder="Ingrese el lugar de salida..." required>
                </div>

                <div class="mb-5">
                    <label for="horaSalida" class="form-label">Hora de Salida:</label>
                    <input type="time" class="form-control" id="horaSalida" name="horaSalida" required>
                </div>

                <div class="mb-5">
                    <label for="fechaRegreso" class="form-label">Fecha de Regreso:</label>
                    <input type="date" class="form-control" id="fechaRegreso" name="fechaRegreso" required>
                </div>

                <div class="mb-5">
                    <label for="lugarRegreso" class="form-label">Lugar de Regreso:</label>
                    <input type="text" class="form-control" id="lugarRegreso" name="lugarRegreso" placeholder="Ingrese el lugar de regreso..." required>
                </div>

                <div class="mb-5">
                    <label for="horaRegreso" class="form-label">Hora de Regreso:</label>
                    <input type="time" class="form-control" id="horaRegreso" name="horaRegreso" required>
                </div>

                <div class="mb-5">
                    <label for="itinerario" class="form-label">Itinerario:</label>
                    <textarea class="form-control" id="itinerario" name="itinerario" rows="3" placeholder="Describa el itinerario..." required></textarea>
                </div>

                <div class="mb-5">
                    <label for="actividades" class="form-label">Actividades:</label>
                    <textarea class="form-control" id="actividades" name="actividades" rows="3" placeholder="Describa las actividades..." required></textarea>
                </div>

                <div class="mb-5">
                    <label for="dniEncargado" class="form-label">DNI del encargado:</label>
                    <input type="number" class="form-control" id="dniEncargado" name="dniEncargado" placeholder="Ingrese el DNI del encargado..." required pattern="\d{8,}" value="<?php echo $dniProfesor?>">
                </div>

                <div class="mb-5">
                    <label for="nombreEncargado" class="form-label">Nombre del encargado:</label>
                    <input type="text" class="form-control" id="nombreEncargado" name="nombreEncargado" placeholder="Ingrese el nombre del encargado..." required pattern="[A-Za-z\s]+" value="<?php $nombreFormateadoProfe = ucwords(strtolower($nombreCompletoProfesor)); echo $nombreFormateadoProfe;?>">
                </div>

                <div class="mb-5">
                    <label for="nombreHospedaje" id="nH" class="form-label">Nombre del hospedaje:</label>
                    <input type="text" class="form-control" id="nombreHospedaje" name="nombreHospedaje" placeholder="Ingrese el nombre del hospedaje..." required>
                </div>

                <div class="mb-5">
                    <label for="domicilioHospedaje" id="dH" class="form-label">Domicilio del hospedaje:</label>
                    <input type="text" class="form-control" id="domicilioHospedaje" name="domicilioHospedaje" placeholder="Ingrese el domicilio del hospedaje..." required>
                </div>

                <div class="mb-5">
                    <label for="telefonoHospedaje" id="tH" class="form-label">Teléfono del hospedaje:</label>
                    <input type="number" class="form-control" id="telefonoHospedaje" name="telefonoHospedaje" placeholder="Ingrese el teléfono del hospedaje..." required pattern="\d{11}">
                </div>

                <div class="mb-5">
                    <label for="localidadHospedaje" id="lH" class="form-label">Localidad del hospedaje:</label>
                    <input type="text" class="form-control" id="localidadHospedaje" name="localidadHospedaje" placeholder="Ingrese la localidad del hospedaje..." required>
                </div>

                <div class="mb-5">
                    <label for="gastosEstimativos" id="gE" class="form-label">Gastos Estimativos:</label>
                    <input type="text" class="form-control" id="gastosEstimativos" name="gastosEstimativos" placeholder="Ingrese los gastos estimativos o como solventarlos..." required>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-center">
                    <button type="button" class="btn btn-success" id="cargarAnexoIV">Cargar Anexo 4</button>
                </div>
            </form>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../../js/anexoIV.js"></script>
    </body>
</html>