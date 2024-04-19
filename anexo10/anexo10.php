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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <img src="../imagenes/logoBA.png" height="160">
            </div>
            <div class="col-md-6">
                <img src="../imagenes/logo.png" class="float-right" height="100">
            </div>
        </div>
        <!-- FALTA HACERLO RESPONSIVE AL 100% -->
        <div class="row justify-content-center text-right mx-0">
            <div class="col-6">
                <div class="text-right">
                    <p>Corresponde al Expediente N° 5802-1701421/17</p>
                </div>
            </div>
        </div>

        <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
            <div class="text-center">
                <b class="mb-4">ANEXO X</b>
                <br>
                <b>Planilla informativa para padres</b>
            </div>
        </div>

            <br>

            <div class="col-12 col-md-9">
                <div class="col-12 text-left">
                    Nombre del proyecto de salida
                </div>
                <div class="col-10 text-left">
                    <input type="text" id="nombreSalida" class="form-control-sm border-primary">
                </div>

                <div class="col-12 text-left">
                    Lugar, Día y hora de salida
                </div>
                <div class="col-2"></div>
                <div class="col-10 text-left">
                    <input type="text" id="LDHSalida" placeholder="Separar datos con ," class="form-control-sm border-primary">
                </div>

                <div class="col-12 text-left">
                    Lugar, Día y hora de regreso
                </div>
                <div class="col-2"></div>
                <div class="col-10 text-left">
                    <input type="text" id="LDHregreso" placeholder="Separar datos con ," class="form-control-sm border-primary">
                </div>

                <div class="col-12 text-left">
                    Lugares a visitar
                </div>
                <div class="col-2"></div>
                <div class="col-10 text-left">
                    <input type="text" id="lugarVisitar" class="form-control-sm border-primary">
                </div>

                <div class="col-12 text-left">
                    Lugares de estadia- domicilios y teléfonos
                </div>
                <div class="col-12 d-flex text-left mb-3">
                    <div class="col-6">
                        <b>Estadias:</b> 
                        <input type="text" id="estadia" class="form-control-sm border-primary">
                    </div>
                    <div class="col-6">
                        <b>Teléfono:</b>
                        <input type="text" id="telEstadia" class="form-control-sm border-primary">
                    </div>
                </div>
                <div class="col-12 d-flex text-left">
                    <div class="col-6">
                        <b>Domicilio:</b>
                        <input type="text" id="domEstadia" class="form-control-sm border-primary">
                    </div>
                    <div class="col-6">
                        <b>Localidad:</b>
                        <input type="text" id="locaEstadia" class="form-control-sm border-primary">
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
            <div class="d-flex justify-content-center mb-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <label for="empresa" class="mr-2">Empresa:</label>
                        <input type="text" id="empresa" class="form-control-sm border-primary">
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <label for="direccion" class="mr-2">Dirección:</label>
                        <input type="text" id="direccion" class="form-control-sm border-primary">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <label for="localidad" class="mr-2">Localidad:</label>
                        <input type="text" id="localidad" class="form-control-sm border-primary">
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <label for="telefono" class="mr-2">Teléfono:</label>
                        <input type="text" id="telefono" class="form-control-sm border-primary">
                    </div>
                </div>
            </div>

        <div class="row" style="padding: 0 200px 0 200px">
            <div class="col-9 text-left">
                Hospitales y centros asistenciales cercanos
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-4 text-left">
                <b>Hospital Dr. Óscar Arraiz</b>
            </div>
            <div class="col-4 text-left">
                Dirección:
                <b>Copello 311</b>
            </div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-4 text-left">
                Teléfono:
                <b>(02944-494170)</b>
            </div>
            <div class="col-4 text-left">
                Localidad:
                <b>Villa La Angostura</b>
            </div>
        </div>
        <br>
        <div class="row" style="padding: 0 200px 0 200px">
            <div class="col-9 text-left">
                Otros datos de interés:
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-4 text-left">
                <b>Comisaría de Villa La Angostura</b>
            </div>
            <div class="col-4 text-left">
                Dirección:
                <b>Av. Arrayanes N° 242</b>
            </div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-4 text-left">
                Teléfono:
                <b>0294 - 449-4121</b>
            </div>
            <div class="col-4 text-left">
                Localidad:
                <b>Villa La Angostura</b>
            </div>
        </div>
        <br>
        <div class="row" style="padding: 0 200px 0 200px">
            <div class="col-12 text-left">
                (La conformidad de recepción del presente por parte de los padres se encuentra en la planilla adjunta)
            </div>
        </div>
        <button type="button" id="boton_guardar" class="btn btn-info mt-3">Guardar</button>
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
