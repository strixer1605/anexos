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
            <form id="formularioSalidas" class="formulario">
                <label>Tipo de Salida:</label><br>
                <div class="form-check">
                    <input type="radio" id="representacion" name="tipoSalida" value="Salida de Representación Institucional" class="form-check-input" required>
                    <label for="representacion" class="form-check-label">Salida de Representación Institucional</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="educativa" name="tipoSalida" value="Salida Educativa" class="form-check-input" required>
                    <label for="educativa" class="form-check-label">Salida Educativa</label>
                </div>

                <div class="mb-5">
                    <label for="region" class="form-label">Región:</label>
                    <input type="text" class="form-control" id="region" name="region" placeholder="Ingrese la región" required pattern="[A-Za-z\s]+">
                </div>
    
                <div class="mb-5">
                    <label for="distrito" class="form-label">Distrito:</label>
                    <input type="text" class="form-control" id="distrito" name="distrito" placeholder="Ingrese el distrito" required pattern="[A-Za-z\s]+">
                </div>
    
                <div class="mb-5">
                    <label for="institucionEducativa" class="form-label">Institución Educativa:</label>
                    <input type="text" class="form-control" id="institucionEducativa" name="institucionEducativa" placeholder="Ingrese la institución educativa" required pattern="[A-Za-z\s]+">
                </div>
    
                <div class="mb-5">
                    <label for="numero" class="form-label">N°:</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Ingrese el número" required pattern="\d+">
                </div>
    
                <div class="mb-5">
                    <label for="domicilioInstitucion" class="form-label">Domicilio:</label>
                    <input type="text" class="form-control" id="domicilioInstitucion" name="domicilio" placeholder="Ingrese el domicilio" required>
                </div>
    
                <div class="mb-5">
                    <label for="telefonoInstitucion" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" id="telefonoInstitucion" name="telefono" placeholder="Ingrese el teléfono" required pattern="\d{10}">
                </div>
    
                <div class="mb-5">
                    <label for="denominacionProyecto" class="form-label">Denominación del Proyecto:</label>
                    <input type="text" class="form-control" id="denominacionProyecto" name="denominacionProyecto" placeholder="Ingrese la denominación del proyecto" required>
                </div>
    
                <div class="mb-5">
                    <label for="lugarVisitar" class="form-label">Lugar a Visitar:</label>
                    <input type="text" class="form-control" id="lugarVisitar" name="lugarVisitar" placeholder="Ingrese el lugar a visitar" required>
                </div>
    
                <div class="mb-5">
                    <label for="fechaSalida" class="form-label">Fecha de Salida:</label>
                    <input type="date" class="form-control" id="fechaSalida" name="fechaSalida" required>
                </div>
    
                <div class="mb-5">
                    <label for="lugarSalida" class="form-label">Lugar de Salida:</label>
                    <input type="text" class="form-control" id="lugarSalida" name="lugarSalida" placeholder="Ingrese el lugar de salida" required>
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
                    <input type="text" class="form-control" id="lugarRegreso" name="lugarRegreso" placeholder="Ingrese el lugar de regreso" required>
                </div>
    
                <div class="mb-5">
                    <label for="horaRegreso" class="form-label">Hora de Regreso:</label>
                    <input type="time" class="form-control" id="horaRegreso" name="horaRegreso" required>
                </div>
    
                <div class="mb-5">
                    <label for="itinerario" class="form-label">Itinerario:</label>
                    <textarea class="form-control" id="itinerario" name="itinerario" rows="3" placeholder="Describa el itinerario" required></textarea>
                </div>
    
                <div class="mb-5">
                    <label for="actividades" class="form-label">Actividades:</label>
                    <textarea class="form-control" id="actividades" name="actividades" rows="3" placeholder="Describa las actividades" required></textarea>
                </div>
    
                <div class="mb-5">
                    <label for="objetivos" class="form-label">Objetivos:</label>
                    <textarea class="form-control" id="objetivos" name="objetivos" rows="3" placeholder="Describa los objetivos" required></textarea>
                </div>
    
                <div class="mb-5">
                    <label for="cobertura" class="form-label">Cobertura:</label>
                    <textarea class="form-control" id="cobertura" name="cobertura" rows="3" placeholder="Describa la cobertura" required></textarea>
                </div>
    
                <div class="mb-5">
                    <label for="resultados" class="form-label">Resultados:</label>
                    <textarea class="form-control" id="resultados" name="resultados" rows="3" placeholder="Describa los resultados esperados" required></textarea>
                </div>
    
                <div class="mb-5">
                    <label for="directivos" class="form-label">Directivos y Docentes Responsables:</label>
                    <textarea class="form-control" id="directivos" name="directivos" rows="3" placeholder="Ingrese los nombres de los directivos y docentes responsables" required></textarea>
                </div>
    
                <div class="mb-5">
                    <label for="observaciones" class="form-label">Observaciones:</label>
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Ingrese observaciones" required></textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success">Cargar</button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById("formularioSalidas").addEventListener("submit", function(event) {
                var telefono = document.getElementById("telefonoInstitucion").value;
                var telefonoPattern = /^\d{10}$/;

                if (!telefonoPattern.test(telefono)) {
                    alert("El número de teléfono debe contener exactamente 10 dígitos.");
                    event.preventDefault(); // Evita el envío del formulario
                }

                var numero = document.getElementById("numero").value;
                var numeroPattern = /^\d+$/;

                if (!numeroPattern.test(numero)) {
                    alert("El campo 'N°' solo debe contener números.");
                    event.preventDefault(); // Evita el envío del formulario
                }
            });
        </script>
    </body>
</html>
