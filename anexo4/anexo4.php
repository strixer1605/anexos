<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Título de tu página</title>
        <link rel="stylesheet" href="../librerias/bootstrap.css">
        <link rel="stylesheet" href="estilo.css">   
        <script>
            function ajustarEstilos() {
                var anchoVentana = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                if (anchoVentana <= 730) {
                    document.getElementById('lugar1').classList.remove('form-control-sm');
                    document.getElementById('fecha1').classList.remove('form-control-sm');
                    document.getElementById('lugar2').classList.remove('form-control-sm');
                    document.getElementById('fecha2').classList.remove('form-control-sm');
                } else {
                    document.getElementById('lugar1').classList.add('form-control-sm');
                    document.getElementById('fecha1').classList.add('form-control-sm');
                    document.getElementById('lugar2').classList.add('form-control-sm');
                    document.getElementById('fecha2').classList.add('form-control-sm');
                }
            }

            window.onload = ajustarEstilos;
            window.onresize = ajustarEstilos;
        </script>
    </head>
    <body>
        <div class="d-flex justify-content-center">
            <div class="row mx-0 p-0">
                <div class="col-md-8 mx-auto">
                    <div class="row">
                        <div class="col col-sm-6">
                            <img src="../imagenes/logoBA.png" class="img-fluid" alt="Logo BA" width="50">
                        </div>
                        <div class="col col-sm-6">
                            <img src="../imagenes/logo.png" class="float-right img-fluid" alt="Logo" width="99">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                            <h6>Corresponde al Expediente N° 5802-1701421/17</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>ANEXO IV</h4>
                            <h6>Solicitud para la realización de:</h6>
                            <h6> Salida Educativa / <del> Salida de Representación Institucional</del></h6>
                            <br>
                        </div>
                    </div>
                </div>
                <br>

                <div class="borde col-10">
                    <div class="row m-0 p-0">
                        <div class="col-sm-12 text-left">
                            <br>
                            <h6>Nombre del Proyecto : <input type="text" id="nombre_del_proyecto" class="form-control-sm border-primary" required></h6>
                        </div>
                        <div class="col-sm-12 text-left">
                            <h5>Región:</h5>
                        </div>
                        <div class="col-sm-12 text-left">
                            <h5>Distrito: La Costa</h5>
                        </div>
                        <div class="col-sm-12 text-left">
                            <h5>Institución Educativa: ESCUELA TECNICA Nº1 - RAUL SCALABRINI ORTIZ</h5>
                        </div>
                        <div class="col-sm-12 text-left">
                            <h5>Domicilio: C. 104 1700-1798, Santa Teresita, Provincia de Buenos Aires  Teléfono: 02246 42-3529 </h5>
                            <br>
                        </div>
                        <div class="col-sm-12 text-left">
                            <h6>Denominación del Proyecto: <input type="text" id="denominacion_proyecto" class="form-control-sm border-primary" required> - El Regreso</h6>
                        </div>
                        <div class="col-sm-12 text-left">
                            <h6>Lugar a visitar: <input type="text" id="lugar_a_visitar" class="form-control-sm border-primary" required></h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-left">
                            <h6>SALIDA</h6>
                        </div>
                        <div class="col-12 col-md-4 ">
                            <label for="lugar1" class="etiqueta">Lugar:</label>
                            <input type="text" id="lugar1" class="form-control-sm border-primary mb-3" required placeholder="Lugar">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="col-auto col-md-12 etiqueta">Fecha:</label>
                            <input type="date" id="fecha1" class="col-9 col-md-12 form-control-sm border-primary mb-3" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="col-auto col-md-12 etiqueta">Hora:</label>
                            <input type="time" id="hora1" class="col-9 col-md-12 form-control-sm border-primary mb-3" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-left">
                            <h6>REGRESO</h6>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="lugar2" class="etiqueta">Lugar:</label>
                            <input type="text" id="lugar2" class="form-control-sm border-primary mb-3" required placeholder="Lugar">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="col-auto col-md-12 etiqueta">Fecha:</label>
                            <input type="date" id="fecha2" class="col-9 col-md-12 form-control-sm border-primary mb-3" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="col-auto col-md-12 etiqueta">Hora:</label>
                            <input type="time" id="hora2" class="col-9 col-md-12 form-control-sm border-primary mb-3" required>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <h6>Itinerario: <input type="text" id="itinerario" class="form-control-sm border-primary" required></h6>
                        </div>
                    </div>
                    <br>
                    
                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <h6>Actividades: <input type="text" id="actividades" class="form-control-sm border-primary" required></h6>
                        </div>
                    </div>

                    <br><br>
                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <h6>Datos de la/las personas a cargo</h6>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <button id="boton" class="btn btn-primary" onclick="toggleMostrarOcultar();">Mostrar Campos</button>
                        </div>
                    </div>
                    <br>
                    <div id="img" style="display: none;">
                        <div class="row">
                            <div class="col-sm-12 text-left">
                                <h6>Apellido y Nombre: <input type="text" id="apellido_y_nombre" class="form-control-sm border-primary" required></h6>
                            </div>
                            <div class="col-sm-12 text-left">
                                <h6>Cargo: <?php include('selectCargos.php');?></h6>
                            </div>
                            <div class="col-sm-12 text-left">
                                <h6>Cantidad de alumnos: <input type="number" id="cantidad_de_alumnos" class="form-control-sm border-primary" required></h6>
                            </div>
                            <div class="col-sm-12 text-left">
                                <h6>Cantidad de docentes acompañantes: <input type="number" id="cantidad_de_docentes_acompañantes" class="form-control-sm border-primary" required></h6>
                            </div>
                            <div class="col-sm-12 text-left">
                                <h6>Cantidad de no docentes acompañantes: <input type="number" id="cantidad_de_no_docentes_acompañantes" class="form-control-sm border-primary" required></h6>
                            </div>
                            <div class="col-sm-12 text-left">
                                <h6>Total de personas: <input type="number" id="total_de_personas" class="form-control-sm border-primary" required></h6>
                            </div>
                            <div class="col-sm-12 text-left">
                                <p>(Sólo para salidas de más de 24 horas)</p>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <h6>Hospedaje: <input type="text" id="hospedaje" class="form-control-sm border-primary" required> Domicilio: <input type="text" id="domicilio_del_hospedaje" class="form-control-sm border-primary" required></h6>
                        </div>
                        <div class="col-sm-12 text-left">
                            <h6>Teléfono: <input type="number" id="telefono_del_hospedaje" class="form-control-sm border-primary" required> Localidad: <input type="text" id="localidad_del_hospedaje" class="form-control-sm border-primary" required></h6>
                        </div>
                    </div>

                    <br><br>
                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <h6>Gastos estimativos de la actividad y modo de solventarlos</h6>
                        </div>
                        <div class="col-sm-12 text-left">
                            <p>Los gastos son solventados por los padres de los alumnos realizando distintos tipos de eventos para tal fin.</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="button" id="boton_guardar" class="btn btn-info mt-3">Guardar</button>
                        </div>
                    </div>
                
                    <br><br><br><br><br><br>
                    <div class="row">
                        <div class="col-sm-7">
                            <h6>.......................................</h6>
                            <p>Lugar y fecha</p>
                            <p>Firma de Autoridad del Establecimiento</p><br><br><br><br><br><br><br><br>
                            <h6>......................................</h6>
                            <p>Lugar y fecha</p>
                            <p>firma del Inspector Jefe Distrital</p>
                            <p>(Si correspondiere)</p>
                        </div>
                        <div class="col-sm-5">
                            <h6>.......................................</h6>
                            <p>Lugar y fecha</p>
                            <p>Firma del Inspector</p>
                            <p>(Si correspondiere)</p><br><br><br><br><br><br>
                            <h6>........................................</h6>
                            <p>Lugar y fecha</p>
                            <p>Firma del Inspector Jefe Regional</p>
                            <p>(Si correspondiere)</p>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>1) El presente formulario deberá estar completo por duplicado </h6> 
                            <h6> (Uno para la institución y otro para la instancia de supervisión)</h6>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../librerias/jquery.js"></script>
        <script src="../librerias/boostrap.js"></script>
        <script>
            function toggleMostrarOcultar() {
                var elemento = document.getElementById('img');
                if (elemento.style.display === 'none') {
                    elemento.style.display = 'block';
                } else {
                    elemento.style.display = 'none';
                }
            }
            $(document).ready(function () {
                $('#boton_guardar').click(function () {
                    let camposCompletos = true;
                    $('input').each(function () {
                        if ($(this).val().length === 0) {
                            $(this).removeClass('border-primary');
                            $(this).removeClass('input');
                            $(this).addClass('border-danger');
                            $(this).addClass('false');
                            camposCompletos = false;
                        } else {
                            $(this).removeClass('border-primary');
                            $(this).removeClass('input');
                            $(this).removeClass('border-danger');
                            $(this).removeClass('false');
                            $(this).addClass('border-success');
                            $(this).addClass('true');
                        }
                    });
                    if (camposCompletos) {
                        let nombre_del_proyecto = $('#nombre_del_proyecto').val();
                        let denominacion_proyecto = $('#denominacion_proyecto').val();
                        let lugar_a_visitar = $('#lugar_a_visitar').val();
                        let apellido_y_nombre = $('#apellido_y_nombre').val();
                        let cargo = $('#cargo').val();
                        let fecha1 = $('#fecha1').val();
                        let lugar1 = $('#lugar1').val();
                        let fecha2 = $('#fecha2').val();
                        let lugar2 = $('#lugar2').val();
                        let itinerario = $('#itinerario').val();
                        let actividades = $('#actividades').val();
                        let cantidad_de_alumnos = $('#cantidad_de_alumnos').val();
                        let cantidad_de_docentes_acompañantes = $('#cantidad_de_docentes_acompañantes').val();
                        let cantidad_de_no_docentes_acompañantes = $('#cantidad_de_no_docentes_acompañantes').val();
                        let total_de_personas = $('#total_de_personas').val();
                        let hospedaje = $('#hospedaje').val();
                        let domicilio_del_hospedaje = $('#domicilio_del_hospedaje').val();
                        let telefono_del_hospedaje = $('#telefono_del_hospedaje').val();
                        let localidad_del_hospedaje = $('#localidad_del_hospedaje').val();
                        console.log(nombre_del_proyecto, denominacion_proyecto,
                            lugar_a_visitar, apellido_y_nombre, cargo, fecha1, lugar1, fecha2, lugar2, itinerario, actividades, cantidad_de_alumnos, cantidad_de_docentes_acompañantes,
                            cantidad_de_no_docentes_acompañantes,
                            total_de_personas, hospedaje, domicilio_del_hospedaje, telefono_del_hospedaje, localidad_del_hospedaje);
                        $.post('datosSalida.php', {
                            nombre_del_proyecto: nombre_del_proyecto,
                            denominacion_proyecto: denominacion_proyecto,
                            lugar_a_visitar: lugar_a_visitar,
                            apellido_y_nombre: apellido_y_nombre,
                            cargo: cargo,
                            fecha1: fecha1,
                            lugar1: lugar1,
                            fecha2: fecha2,
                            lugar2: lugar2,
                            itinerario: itinerario,
                            actividades: actividades,
                            cantidad_de_alumnos: cantidad_de_alumnos,
                            cantidad_de_docentes_acompañantes: cantidad_de_docentes_acompañantes,
                            cantidad_de_no_docentes_acompañantes: cantidad_de_no_docentes_acompañantes,
                            total_de_personas: total_de_personas,
                            hospedaje: hospedaje,
                            domicilio_del_hospedaje: domicilio_del_hospedaje,
                            telefono_del_hospedaje: telefono_del_hospedaje,
                            localidad_del_hospedaje: localidad_del_hospedaje,
                        }, function (data) {
                            alert(data);
                        });
                    }
                });
            });
        </script>
    </body>
</html>
