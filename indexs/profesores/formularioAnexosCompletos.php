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
                <div class="tab-pane fade show active" id="anexo5" role="tabpanel" aria-labelledby="anexo8-tab">
                    <h2>Anexo 5</h2>
                    <br>
                    <form id="formAnexo5" class="formulario" action="../../php/insertAnexoV.php" method="POST">
                        <label for="dni_search" class="form-label">DNI:</label>
                        <div class="mb-5" style="display: flex; align-items: center;">
                            <div class="col-4 d-flex">
                                <input type="number" class="form-control" id="dniSearch" name="dniSearch" required pattern="\d{8}" placeholder="Insertar por DNI..." style="width: 91%; margin-right:10px;">
                                
                            </div>
                            <div class="col-4">
                                <select name="coincidenciaPersona" id="coincidenciaPersona">
                
                            </select>
                            </div>
                            <div class="col-4">
                                <button type="button" id="agregarPersona" class="btn btn-success">
                                    Cargar
                                </button>
                            </div>
                        </div>
                        <label for="cursos" class="form-label">Cursos:</label>
                        <div class="mb-5" style="display: flex; align-items: center;">
                            <select id="cursos" name="cursos" class="form-control" required placeholder="Insertar por curso..." style="width: 91%; margin-right:10px;">
                                <?php include ('../../php/traerGrupos.php'); ?>
                            </select>
                            <button type="button" class="btn btn-success" id="cargarGrupo">
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
                                    <th scope="col">Apellido y Nombre</th>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Alumno</th>
                                    <th scope="col">Edad</th>
                                    <th scope="col">Docente</th>
                                    <th scope="col">No Docente</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="tablaParticipantes">
                                
                            </tbody>
                        </table>
                    </form>
                </div>
                
                <!-- Anexo 8 -->
                <div class="tab-pane fade" id="anexo8" role="tabpanel" aria-labelledby="anexo8-tab">
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
                    <button type="submit" class="btn btn-success">Cargar Anexo 8</button>
                </div>

                <!-- Anexo 9 -->
                <div class="tab-pane fade" id="anexo9" role="tabpanel" aria-labelledby="anexo9-tab">
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
                    <button type="submit" class="btn btn-success">Cargar Anexo 9</button>
                </div>

                <!-- Anexo 10 -->
                <div class="tab-pane fade" id="anexo10" role="tabpanel" aria-labelledby="anexo10-tab">
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
                    <button type="submit" class="btn btn-success">Cargar Anexo 10</button>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <form id="formTodosAnexos" action="../../php/insertTodosAnexos.php" method="POST">
                    <input type="hidden" name="allAnexos" value="true">
                    <button type="submit" class="btn btn-primary">Cargar Todos los Anexos</button>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="../../js/enviarFormularios.js"></script>
        <script src="../../js/cargarPersonasAnexoV.js"></script>
        <script>
            $(document).ready(function(){
                cargarTablaPasajeros();
                $('#dniSearch, #agregarPersona').on('keydown', function(event){
                    if (event.which === 13) {
                        event.preventDefault();
                        $("#agregarPersona").click();  
                    }
                })
                $("#dniSearch").keyup(function(event) {
                    var dniPersona = $("#dniSearch").val();
                    $.ajax({
                        type: 'POST',
                        url: '../../php/buscarPersona.php',
                        data: {dniPersona: dniPersona},
                        success:function(response){
                            // console.log(response);
                            
                            var select = document.getElementById('coincidenciaPersona');
                            select.innerHTML = '';

                            //parsear la respuesta JSON
                            const personas = JSON.parse(response);

                            if (personas.error) {
                                console.log(personas.error);
                                return;
                                
                            }
                            //iterar sobre cada persona y agregarla al seelect
                            const cargarPersona = function(persona) {
                                var option = document.createElement('option');
                                option.value = persona.dni; //asigna el valor al value
                                option.textContent = `${persona.nombre} ${persona.apellido}`; //asigna el valor del texto
                                option.setAttribute('data-cargo', persona.cargo);
                                option.setAttribute('data-fechan', persona.fechan);
                                select.appendChild(option);
                            }
                            //recorre el array personas y llama a la función que agrega personas al select
                            for (let i = 0; i < personas.length; i++){
                                cargarPersona(personas[i]);

                            }
                        },
                        error:function(response) {
                            console.log(response);
                            
                        }
                    })
                    
                })
                $("#agregarPersona").click(function(){
                    const select = document.getElementById('coincidenciaPersona');
                    const selectedOption = select.options[select.selectedIndex]; // Corregido: 'options' en lugar de 'option'

                    const dni = selectedOption.value;
                    const nombreApellido = selectedOption.textContent;
                    const cargo = selectedOption.getAttribute('data-cargo');
                    const fechan = selectedOption.getAttribute('data-fechan');
                    const idAnexoIV = <?php echo json_encode($idSalida); ?>;
                    
                    $.ajax({
                        type: 'POST',
                        url: '../../php/agregarPersonaAnexoV.php',
                        data: {
                            dni,
                            nombreApellido,
                            cargo,
                            fechan,
                            idAnexoIV
                        },
                        success:function(response) {
                            // console.log(response);
                            cargarTablaPasajeros();
                            // const datos = JSON.parse(response);
                            // console.log(datos);
                            
                            
                        },
                        error:function(response) {
                            console.log(response);
                            
                        }
                    })
                    console.log(dni, nombreApellido, cargo);
                    
                })

                function cargarTablaPasajeros() {
                    $.ajax({
                        method: 'GET',
                        url: '../../php/traerPersonasAnexoV.php',
                        success: function(response) {
                            const pasajeros = JSON.parse(response);
                            let tablaHTML = '';
                            let indice = 0;
                            pasajeros.forEach(function(pasajero) {
                                let alumno = '';
                                let docente = '';
                                let noDocente = '';
                                console.log(pasajero.cargo);
                                
                                indice += 1;
                                switch(parseInt(pasajero.cargo)) {
                                    case 2: docente = 'X';
                                            break;
                                    case 3: alumno = 'X';
                                            break;
                                    case 4: noDocente = 'X';
                                            break;
                                }
                                console.log(alumno);
                                tablaHTML +=`<tr>
                                                <td>${indice}</td>
                                                <td>${pasajero.apellidoNombre}</td>
                                                <td>${pasajero.dni}</td>
                                                <td>${alumno}</td>
                                                <td>${pasajero.edad}</td>
                                                <td>${docente}</td>
                                                <td>${noDocente}</td>
                                                <td>
                                                    <a href="modMantenimientoCurso.php?" class="modificar btn btn-success btn-sm">
                                                        Seguimiento
                                                    </a>
                                                </td>
                                                <td>
                                                    <button class="eliminar" ">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </td>
                                            </tr>`;
                            });

                            $('#tablaParticipantes').html(tablaHTML);

                        },
                        error: function() {
                            alert ("Ha ocurrido un error al obtener los pasajeros")
                        }
                    })
                }
            })
        </script>
    </body>
</html>
