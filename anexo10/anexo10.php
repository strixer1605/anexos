<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../librerias/bootstrap.css">
    <script src="../librerias/jquery.js?v=1"></script>
    <script src="../librerias/bootstrap.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Anexo 10</title>
</head>
<body>
    <!-- PONERLE BIEN EL ID A LOS CAMPOS REPETIDOS DE DIRE,TEL Y LOCALIDAD -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-md-6">
                <img src="../imagenes/logoBA.png" height="160">
            </div>
            <div class="col-6 col-md-6">
                <img src="../imagenes/logo.png" class="float-right" height="100">
            </div>
        </div>
        
        <div class="row justify-content-end">
            <div class="col-6">
                <div class="float-right">
                    <p>Corresponde al Expediente N° 5802-1701421/17</p>
                </div>
            </div>
        </div>
        <!-- aca iba un container-fluid por si se rompe -->
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="text-center">
                <b class="mb-4">ANEXO X</b>
                <br>
                <b>Planilla informativa para padres</b>
            </div>
        </div>

            <br>

            <div class="col-12 m-0 p-0">
            <div>
    <div class="col-12 text-left mb-3">
        Nombre del proyecto de salida
    </div>

    <div class="col-10 text-left mb-3">
        <input type="text" id="nombreSalida" placeholder="Nombre de salida" class="form-control-sm border-primary">
    </div>

    <div class="col-12 text-left mb-3">
        Lugar, Día y hora de salida
    </div>
    
    <div class="row m-0 p-0 mb-3">
        <div class="col-12 col-md-4 mb-3">
            <input type="text" id="lugarSalida" placeholder="Lugar a viajar" class="form-control-sm border-primary">
        </div>
        <div class="col-12 col-md-4 mb-3">
            <input type="text" id="diaSalida" placeholder="dia a viajar" class="form-control-sm border-primary">
        </div>
        <div class="col-12 col-md-4 mb-3">
            <input type="text" id="horaSalida" placeholder="hora a viajar" class="form-control-sm border-primary">
        </div>
    </div>

    <div class="col-12 text-left mb-3">
        Lugar, Día y hora de regreso
    </div>
    <div class="row m-0 p-0 mb-3">
        <div class="col-12 col-md-4 mb-3">
            <input type="text" id="lugarRegreso" placeholder="Lugar a regresar" class="form-control-sm border-primary">
        </div>
        <div class="col-12 col-md-4 mb-3">
            <input type="text" id="diaRegreso" placeholder="dia a regresar" class="form-control-sm border-primary">
        </div>
        <div class="col-12 col-md-4 mb-3">
            <input type="text" id="horaRegreso" placeholder="hora a regresar" class="form-control-sm border-primary">
        </div>
    </div>

    <div class="col-12 text-left mb-3">
        Lugares a visitar
    </div>
    <div class="form-floating m-3">
        <textarea class="form-control" placeholder="Lugares a visitar" id="lugaresVisitar"></textarea>
    </div>
</div>

                <div class="row m-0 p-0">
                    <div class="col-12 text-left">
                        Lugares de estadia- domicilios y teléfonos
                    </div>
                </div>
                <div class="row m-1">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-3">
                                <b>Estadia:</b> 
                            </div>
                            <div class="col-9">
                                <input type="text" id="estadia" class="form-control-sm border-primary">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <b>Domicilio:</b> 
                            </div>
                            <div class="col-9">
                                <input type="text" id="domicilio" class="form-control-sm border-primary">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-3">
                                <b>Telefono:</b> 
                            </div>
                            <div class="col-9">
                                <input type="text" id="telefono" class="form-control-sm border-primary">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <b>Localidad:</b> 
                            </div>
                            <div class="col-9">
                                <input type="text" id="localidad" class="form-control-sm border-primary">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 text-left">
                    Nombres y teléfonos de los acompañantes
                </div>
                <div class="col-12 d-flex">
                    <textarea class="form-control col-5" id="exampleFormControlTextarea1" rows="3" placeholder="Nombres"></textarea>
                    <textarea class="form-control col-5 ml-auto" id="exampleFormControlTextarea1" rows="3" placeholder="Teléfonos"></textarea>
                </div>

                <div class="col-2"></div>
                <div class="col-12 text-left">
                    Empresa y/o empresas contratadas, nombre, dirección y teléfonos
                </div>
            </div>
            <br>
            <div class="row m-0 p-0">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="empresa" class="mr-2">Empresa:</label>
                        </div>
                        <div class="col-9">
                            <input type="text" id="empresa" class="form-control-sm border-primary">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="localidad" class="mr-2">Localidad:</label>
                        </div>
                        <div class="col-9">
                            <input type="text" id="localidad" class="form-control-sm border-primary">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="direccion" class="mr-2">Dirección:</label>
                        </div>
                        <div class="col-9">
                            <input type="text" id="direccion" class="form-control-sm border-primary">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="telefono" class="mr-2">Teléfono:</label>
                        </div>
                        <div class="col-9">
                            <input type="text" id="telefono" class="form-control-sm border-primary">
                        </div>
                    </div>
                </div>
            </div>

            

        <div class="row m-0 p-0">
            <div class="col-9 text-left">
                Hospitales y centros asistenciales cercanos
            </div>
        </div>
        <br>
        <div class="row m-1">
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-3">
                        <b>Hospital:</b> 
                    </div>
                    <div class="col-9">
                        <input type="text" id="hospital" class="form-control-sm border-primary">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <b>Teléfono:</b> 
                    </div>
                    <div class="col-9">
                        <input type="text" id="telefono" class="form-control-sm border-primary">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-3">
                        <b>Dirección:</b> 
                    </div>
                    <div class="col-9">
                        <input type="text" id="direccion" class="form-control-sm border-primary">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <b>Localidad:</b> 
                    </div>
                    <div class="col-9">
                        <input type="text" id="localidad" class="form-control-sm border-primary">
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row p-0 m-0">
            <div class="col-9 text-left">
                Otros datos de interés:
            </div>
        </div>
        <br>
        <div class="row m-1">
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-3">
                        <b>Lugares de interes:</b> 
                    </div>
                    <div class="col-9">
                        <input type="text" id="lugarInteres" class="form-control-sm border-primary">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <b>Teléfono:</b> 
                    </div>
                    <div class="col-9">
                        <input type="text" id="telefono" class="form-control-sm border-primary">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-3">
                        <b>Dirección:</b> 
                    </div>
                    <div class="col-9">
                        <input type="text" id="direccion" class="form-control-sm border-primary">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <b>Localidad:</b> 
                    </div>
                    <div class="col-9">
                        <input type="text" id="localidad" class="form-control-sm border-primary">
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row p-0 m-0">
            <div class="col-12 text-left">
                (La conformidad de recepción del presente por parte de los padres se encuentra en la planilla adjunta)
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <button type="button" id="boton_guardar" class="btn btn-info mt-3">Guardar</button>
        </div>
    </div>
</body>
</html>

<script>
    
    $(document).ready(function(){
        $('#boton_guardar').click(function(){
            let camposCompletos = true;
            $('input').each(function() {
                if ($(this).val().length === 0) {
                    $(this).removeClass('border-primary');
                    $(this).addClass('border-danger');
                    camposCompletos = false;
                } else {
                    $(this).removeClass('border-danger');
                    $(this).addClass('border-success');
                }
            });
            if (camposCompletos) {
                $.post('insert_user.php', {
                    empresa: $('#empresa').val(),
                    direccion: $('#direccion').val(),
                    localidad: $('#localidad').val(),
                    telefono: $('#telefono').val()
                }, function(data) {
                    alert(data);
                    // Redirige a otra página después de un breve retraso
                    setTimeout(function() {
                        window.location.href = "../anexo transporte/transporte.php";
                    }, 2000); // Redirecciona después de 2 segundos
                });
            }
        });
    });

</script>
