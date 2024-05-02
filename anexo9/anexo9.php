<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../librerias/jquery.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../librerias/bootstrap.css">
    <script src="../librerias/boostrap.js"></script>
    <link rel="stylesheet" href="estilo.css">
    <title>Anexo IX</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 col-md-3">
                <img src="../imagenes/logoBA.png" width="60" height="110">
            </div>
            <!-- <div class="col-4">
                <img src="../imagenes/tiempoSumar.png" width="10" height="110" class="col-md-12 mx-auto">
            </div> -->
            <div class="col-6 col-md-3">
                <img src="../imagenes/logo.png" width="110" height="110" class="float-right">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <p class="float-right">Corresponde al Expediente N° 5802-1701421/17</p>
            </div>
        </div>

        <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
            <div class="text-center">
                <b class="mb-4">ANEXO IX</b>
                <br>
                <b>Planilla Informe de Transporte a Contratar</b>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-6">
                <p><b>Nombre de la persona o razón social de la empresa: <input type="text" id="Nombre_de_la_persona_o_razon_social_de_la_empresa" class="form-control-sm border-primary" required></b></p>
                <p><b>Domicilio del propietario o la empresa: <input type="text" id="Domicilio_del_propietario_o_la_empresa" class="form-control-sm border-primary" required></b></p>
                <p><b>Teléfono del propietario o la empresa: <input type="text" id="Telefono_del_propietario_o_la_empresa" class="form-control-sm border-primary" required></b></p>
                <p><b>Domicilio del gerente o responsable: <input type="text" id="Domicilio_del_gerente_o_responsable" class="form-control-sm border-primary" required></b></p>
                <p><b>Teléfono: <input type="number" id="Telefono" class="form-control-sm border-primary" required></b></p>
                <p><b>Teléfono móvil: <input type="number" id="Telefono_movil" class="form-control-sm border-primary" required></b></p>
                <p><b>Titularidad del vehículo: <input type="text" id="Titularidad_del_vehiculo" class="form-control-sm border-primary" required></b></p>
                <br>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-6">
                <p><b>Compañía aseguradora: <input type="text" id="Compania_aseguradora" class="form-control-sm border-primary" required></b></p>
                <p><b>Número de póliza: <input type="text" id="Numero_de_poliza" class="form-control-sm border-primary" required></b></p>
                <p><b>Tipo de seguro: <input type="text" id="Tipo_de_seguro" class="form-control-sm border-primary" required></b></p>
                <br>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-6">
                <p><b>Nombre del conductor: <input type="text" id="Nombre_del_conductor1" class="form-control-sm border-primary" required></b></p>
                <p><b>DNI conductor: <input type="text" id="DNI_conductor1" class="form-control-sm border-primary" required></b></p>
                <br>
                <p>Nº de carnet de conducir y vigencia:</p>
                <p><b>Licencia N: <input type="text" id="Licencia_N1" class="form-control-sm border-primary" required></b></p>
                <p><b>Vigencia: <input type="text" id="Vigencia1" class="form-control-sm border-primary" required></b></p>
                <br>
                <p><b>Nombre del conductor: <input type="text" id="Nombre_del_conductor2" class="form-control-sm border-primary" required></b></p>
                <p><b>DNI del conductor: <input type="text" id="DNI_del_conductor2" class="form-control-sm border-primary" required></b></p>
                <br>
                <p>Nº de carnet de conducir y vigencia:</p>
                <p><b>Licencia N: <input type="text" id="Licencia_N2" class="form-control-sm border-primary" required></b></p>
                <p><b>Vigencia: <input type="text" id="Vigencia2" class="form-control-sm border-primary" required></b></p>
                <button type="button" id="boton_guardar" class="btn btn-info mt-3">Guardar</button>
                <br>
                <br>
            </div>
        </div>

    </div> <!-- Cierre del contenedor container -->

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
                    Nombre_de_la_persona_o_razon_social_de_la_empresa: $('#Nombre_de_la_persona_o_razon_social_de_la_empresa').val(),
                    Domicilio_del_propietario_o_la_empresa: $('#Domicilio_del_propietario_o_la_empresa').val(),
                    Telefono_del_propietario_o_la_empresa: $('#Telefono_del_propietario_o_la_empresa').val(),
                    Domicilio_del_gerente_o_responsable: $('#Domicilio_del_gerente_o_responsable').val(),
                    Telefono: $('#Telefono').val(),
                    Telefono_movil: $('#Telefono_movil').val(),
                    Titularidad_del_vehiculo: $('#Titularidad_del_vehiculo').val(),
                    Compania_aseguradora: $('#Compania_aseguradora').val(),
                    Numero_de_poliza: $('#Numero_de_poliza').val(),
                    Tipo_de_seguro: $('#Tipo_de_seguro').val(),
                    Nombre_del_conductor1: $('#Nombre_del_conductor1').val(),
                    DNI_conductor1: $('#DNI_conductor1').val(),
                    Licencia_N1: $('#Licencia_N1').val(),
                    Vigencia1: $('#Vigencia1').val(),
                    Nombre_del_conductor2: $('#Nombre_del_conductor2').val(),
                    DNI_del_conductor2: $('#DNI_del_conductor2').val(),
                    Licencia_N2: $('#Licencia_N2').val(),
                    Vigencia2: $('#Vigencia2').val()
                }, function(data) {
                    alert(data);
                    // Redirige a otra página después de un breve retraso
                    setTimeout(function() {
                        window.location.href = "../anexo10/anexo10.php";
                    }, 2000); // Redirecciona después de 2 segundos
                });
            }
        });
    });
    </script>

</body>
</html>
