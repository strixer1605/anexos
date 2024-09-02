<?php
    session_start();
    if (!isset($_SESSION['dni_profesor'])) {
        header('Location: ../index.php');
        exit;
    }
    include('../../php/conexion.php');
    
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

    $dniProfesor = $_SESSION['dni_profesor'];
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
            <h2>Cargar Anexo 4</h2>
            <br>
            <form id="formularioSalidas" class="formulario" action="../../php/insertAnexoIV.php" method="post">
                
                <label>Tipo de Salida:</label><br>
                <div class="form-check">
                    <input type="radio" id="representacion" name="tipoSalida" value="1" class="form-check-input" required>
                    <label for="representacion" class="form-check-label">Salida de Representación Institucional</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="educativa" name="tipoSalida" value="2" class="form-check-input" required>
                    <label for="educativa" class="form-check-label">Salida Educativa</label>
                </div>

                <div class="mb-5">
                    <label for="region" class="form-label">Región:</label>
                    <input type="number" class="form-control" id="region" name="region" placeholder="Ingrese la región" required pattern="[A-Za-z\s]+" value="18">
                </div>

                <div class="mb-5">
                    <label for="distrito" class="form-label">Distrito:</label>
                    <input type="text" class="form-control" id="distrito" name="distrito" placeholder="Ingrese el distrito" required pattern="[A-Za-z\s]+" value="La Costa">
                </div>

                <div class="mb-5">
                    <label for="institucionEducativa" class="form-label">Institución Educativa:</label>
                    <input type="text" class="form-control" id="institucionEducativa" name="institucionEducativa" placeholder="Ingrese la institución educativa" required pattern="[A-Za-z\s]+" value="E.E.S.T.">
                </div>

                <div class="mb-5">
                    <label for="numero" class="form-label">N°:</label>
                    <input type="number" class="form-control" id="numero" name="numero" placeholder="Ingrese el número" required pattern="\d+" value="1">
                </div>

                <div class="mb-5">
                    <label for="domicilioInstitucion" class="form-label">Domicilio:</label>
                    <input type="text" class="form-control" id="domicilioInstitucion" name="domicilio" placeholder="Ingrese el domicilio" required value="Calle 104 y 124">
                </div>

                <div class="mb-5">
                    <label for="telefonoInstitucion" class="form-label">Teléfono:</label>
                    <input type="number" class="form-control" id="telefonoInstitucion" name="telefono" placeholder="Ingrese el teléfono" required pattern="\d{11}" value="02246420535">
                </div>

                <div class="mb-5">
                    <label for="denominacionProyecto" class="form-label">Denominación del Proyecto:</label>
                    <input type="text" class="form-control" id="denominacionProyecto" name="denominacionProyecto" placeholder="Ingrese la denominación del proyecto..." required>
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
                    <label for="cantAlumnos" class="form-label">Cantidad de alumnos:</label>
                    <input type="number" class="form-control" id="cantAlumnos" name="cantAlumnos" placeholder="Ingrese la cantidad de alumnos..." required min="0">
                </div>

                <div class="mb-5">
                    <label for="cantDocentes" class="form-label">Cantidad de docentes:</label>
                    <input type="number" class="form-control" id="cantDocentes" name="cantDocentes" placeholder="Ingrese la cantidad de docentes..." required min="0">
                </div>

                <div class="mb-5">
                    <label for="cantNoDocentes" class="form-label">Cantidad de acompañantes:</label>
                    <input type="number" class="form-control" id="cantNoDocentes" name="cantNoDocentes" placeholder="Ingrese la cantidad de acompañantes..." required min="0">
                </div>

                <div class="mb-5">
                    <label for="totalPersonas" class="form-label">Cantidad total de personas:</label>
                    <input type="number" class="form-control" id="totalPersonas" name="totalPersonas" placeholder="Ingrese la cantidad de personas..." required min="0">
                </div>

                <div class="mb-5">
                    <label for="nombreHospedaje" class="form-label">Nombre del hospedaje:</label>
                    <input type="text" class="form-control" id="nombreHospedaje" name="nombreHospedaje" placeholder="Ingrese el nombre del hospedaje..." required>
                </div>

                <div class="mb-5">
                    <label for="domicilioHospedaje" class="form-label">Domicilio del hospedaje:</label>
                    <input type="text" class="form-control" id="domicilioHospedaje" name="domicilioHospedaje" placeholder="Ingrese el domicilio del hospedaje..." required>
                </div>

                <div class="mb-5">
                    <label for="telefonoHospedaje" class="form-label">Teléfono del hospedaje:</label>
                    <input type="number" class="form-control" id="telefonoHospedaje" name="telefonoHospedaje" placeholder="Ingrese el teléfono del hospedaje..." required pattern="\d{11}">
                </div>

                <div class="mb-5">
                    <label for="localidadHospedaje" class="form-label">Localidad del hospedaje:</label>
                    <input type="text" class="form-control" id="localidadHospedaje" name="localidadHospedaje" placeholder="Ingrese la localidad del hospedaje..." required>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success" id="cargar">Cargar</button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById("formularioSalidas").addEventListener("submit", function(event) {

                var inputs = document.querySelectorAll("input[required], textarea[required]");
                for (var input of inputs) {
                    if (input.value.trim() === "") {
                        alert("Por favor, complete todos los campos obligatorios.");
                        event.preventDefault(); // Evita el envío del formulario
                        return;
                    }
                }
                
                var telefono = document.getElementById("telefonoInstitucion").value;
                var telefonoPattern = /^\d{10}$/;
                if (!telefonoPattern.test(telefono)) {
                    alert("El número de teléfono debe contener exactamente 10 dígitos.");
                    event.preventDefault();
                    return;
                }

                var numero = document.getElementById("numero").value;
                var numeroPattern = /^\d+$/;
                if (!numeroPattern.test(numero)) {
                    alert("El campo 'N°' solo debe contener números.");
                    event.preventDefault();
                    return;
                }

                if (!confirm("¿Está seguro de que desea enviar el formulario con estos datos?")) {
                    event.preventDefault();
                }
            });

            document.getElementById("fechaSalida").addEventListener("change", validarFechas);
            document.getElementById("horaSalida").addEventListener("change", validarFechas);
            document.getElementById("fechaRegreso").addEventListener("change", validarFechas);
            document.getElementById("horaRegreso").addEventListener("change", validarFechas);

            function validarFechas() {
                var fechaSalida = document.getElementById("fechaSalida").value;
                var horaSalida = document.getElementById("horaSalida").value;
                var fechaRegreso = document.getElementById("fechaRegreso").value;
                var horaRegreso = document.getElementById("horaRegreso").value;

                var fechaHoraActual = new Date();
                var fechaHoraSalida = new Date(fechaSalida + "T" + horaSalida);
                var fechaHoraRegreso = new Date(fechaRegreso + "T" + horaRegreso);

                // Validar que la fecha y hora de salida no estén en el pasado
                if (fechaHoraSalida < fechaHoraActual) {
                    alert("La fecha y hora de salida no pueden ser en el pasado.");
                    document.getElementById("fechaSalida").value = "";
                    document.getElementById("horaSalida").value = "";
                    return;
                }

                // Validar que la fecha de salida no sea más de un año en el futuro
                var unAnoEnMilisegundos = 365 * 24 * 60 * 60 * 1000; // Un año en milisegundos
                if (fechaHoraSalida - fechaHoraActual > unAnoEnMilisegundos) {
                    alert("La fecha de salida no puede ser más de un año en el futuro.");
                    document.getElementById("fechaSalida").value = "";
                    document.getElementById("horaSalida").value = "";
                    return;
                }

                // Validar que la fecha de regreso sea posterior a la fecha de salida
                if (fechaHoraRegreso <= fechaHoraSalida) {
                    alert("La fecha y hora de regreso deben ser posteriores a la fecha y hora de salida.");
                    document.getElementById("fechaRegreso").value = "";
                    document.getElementById("horaRegreso").value = "";
                    return;
                }

                calcularDiferencia();
            }

            function calcularDiferencia() {
                var fechaSalida = document.getElementById("fechaSalida").value;
                var horaSalida = document.getElementById("horaSalida").value;
                var fechaRegreso = document.getElementById("fechaRegreso").value;
                var horaRegreso = document.getElementById("horaRegreso").value;

                if (fechaSalida && horaSalida && fechaRegreso && horaRegreso) {
                    var fechaHoraSalida = new Date(fechaSalida + "T" + horaSalida);
                    var fechaHoraRegreso = new Date(fechaRegreso + "T" + horaRegreso);

                    var diferenciaMs = fechaHoraRegreso - fechaHoraSalida;
                    var diferenciaHoras = diferenciaMs / (1000 * 60 * 60);

                    if (diferenciaHoras >= 0) {
                        document.getElementById("diferenciaHoras").value = diferenciaHoras.toFixed(2) + " horas";
                        if (diferenciaHoras < 24){
                            ocultarInputs();
                        }
                    } else {
                        document.getElementById("diferenciaHoras").value = "La fecha y hora de regreso debe ser posterior a la de salida";
                    }
                }
            }
            
            // function ocultarInputs() {
            //     var fechaSalida = document.getElementById("fechaSalida").innerHTML;
            // }
        </script>
    </body>
</html>
