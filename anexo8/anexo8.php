<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="../librerias/bootstrap.css">
    <script src="../librerias/jquery.js?v=1"></script>
    <script src="../librerias/boostrap.js"></script>
    <title>Anexo VIII</title>
</head>
<body>
    <center>
        <div class="row">
            <div class="col-5">
                <img src="../imagenes/logoBA.png" width="80px">
            </div>
            <div class="col-7">
                <img src="../imagenes/logo.png" width="150px">
            </div>
        </div>
    </center>
    
    <div class="row">
        <div class="col-12 float-right">
            <div class="float-right">
                Corresponde al Expediente N° 5802-1701421/17
            </div>
            <br>
            <center>
                <strong>ANEXO VIII PLAN DE ACTIVIDADES DE SALIDA EDUCATIVA</strong>
            </center>
        </div>
    </div>

    <br>
    
    <div class="row">
        <div class="table-responsive col-md-12">
            <table class="table">
                <tr>
                    <td>Institucion educativa</td>
                    <td>SALA / GRUPO / AÑO</td>
                    <td>DIVISION</td>
                    <td>ÁREA / MATERIA / ASIGNATURA / ESPACIO CURRICULAR</td>
                    <td>DOCENTE RESPONSABLE</td>
                </tr>
                <tr>
                    <td><textarea name="caja1" class="messi2 form-control" id="input1"></textarea></td>
                    <td><textarea name="caja1" class="messi1 form-control" id="input2"></textarea></td>
                    <td><textarea name="caja1" class="messi1 form-control" id="input3"></textarea></td>
                    <td><textarea name="caja1" class="messi1 form-control" id="input4"></textarea></td>
                    <td><textarea name="caja1" class="messi1 form-control" id="input5"></textarea></td>
                </tr>
            </table>
        </div>
    </div>

    <br>

    <div class="col-12">
        <center>Se adjunta copia del proyecto a foja/s 18 (hojas)</center>
    </div>

    <br>

    <div class="row justify-content-center">
        <table class="table">
            <tr>
                <td>OBJETIVO/S DE LA SALIDA</td>
                <td>FECHA DE LA SALIDA</td>
                <td>LUGAR/ES QUE SE VISITARÁ/N</td>
            </tr>
            <tr>
                <td><textarea name="caja6" class="form-control" id="input6"></textarea></td>
                <td><input type="date" name="caja7" class="form-control" id="input7"></td>
                <td><textarea name="caja1" class="messi1 form-control" id="input8"></textarea></td>
            </tr>
        </table>
    </div>

    <br>

    <div class="col-12">
        <strong>
            <center>ACTIVIDADES PREVIAS</center>
        </strong>
    </div>

    <br><br>

    <div class="row justify-content-center">
        <table class="table">
            <tr>
                <td>DESCRIPCIÓN</td>
                <td>RESPONSABLES</td>
                <td>OBSERVACIONES</td>
            </tr>
            <tr>
                <td><textarea name="caja1" class="messi1 form-control" id="input9"></textarea></td>
                <td><textarea name="caja1" class="messi1 form-control" id="input10"></textarea></td>
                <td><textarea name="caja1" class="messi1 form-control" id="input11"></textarea></td>
            </tr>
        </table>
    </div>

    <br>

    <div class="col-12">
        <strong>
            <center>ACTIVIDADES DURANTE EL DESARROLLO</center>
        </strong>
    </div>

    <br><br>

    <div class="row justify-content-center">
        <table class="table">
            <tr>
                <td>DESCRIPCIÓN</td>
                <td>RESPONSABLES</td>
                <td>OBSERVACIONES</td>
            </tr>
            <tr>
                <td><textarea name="caja1" class="messi1 form-control" id="input12"></textarea></td>
                <td><textarea name="caja1" class="messi1 form-control" id="input13"></textarea></td>
                <td><textarea name="caja1" class="messi1 form-control" id="input14"></textarea></td>
            </tr>
        </table>
    </div>

    <br><br><br>

    <strong>
        <center>EVALUACION</center>
    </strong>

    <br><br>

    <div class="row justify-content-center">
        <table class="table">
            <tr>
                <td>DESCRIPCIÓN</td>
                <td>RESPONSABLES</td>
                <td>OBSERVACIONES</td>
            </tr>
            <tr>
                <td><textarea name="caja1" class="messi1 form-control" id="input15"></textarea></td>
                <td><textarea name="caja1" class="messi1 form-control" id="input16"></textarea></td>
                <td><textarea name="caja1" class="messi1 form-control" id="input17"></textarea></td>
            </tr>
        </table>
    </div>

    <br>
    <p>1) El presente formulario deberá estar completo por duplicado (Uno para la Institución y otro para la instancia de Supervisión)</p>

    <center>
        <button id="guardar" class="btn btn-primary">Enviar</button><br>

        <br>
        <br>
        <br>
        <br>

        <div class="row">
            <div class="col-4 but">................................................</div>
            <div class="col-4 but">................................................</div>
            <div class="col-4 but">................................................</div>
        </div>
        <div class="row">
            <div class="col-4 but">Firma del Docente Responsable</div>
            <div class="col-4 but">Firma del Jefe de Departamento</div>
            <div class="col-4 but">Firma de Director/a del Establecimiento</div>
        </div>
    </center>

    <script>
        $(document).ready(function() {
            $('#guardar').click(function() {
                var data = {
                    in1: $('#input1').val(),
                    in2: $('#input2').val(),
                    in3: $('#input3').val(),
                    in4: $('#input4').val(),
                    in5: $('#input5').val(),
                    in6: $('#input6').val(),
                    in7: $('#input7').val(),
                    in8: $('#input8').val(),
                    in9: $('#input9').val(),
                    in10: $('#input10').val(),
                    in11: $('#input11').val(),
                    in12: $('#input12').val(),
                    in13: $('#input13').val(),
                    in14: $('#input14').val(),
                    in15: $('#input15').val(),
                    in16: $('#input16').val(),
                    in17: $('#input17').val()
                };

                var dataValid = true;

                for (var i = 1; i <= 17; i++) {
                    var inputId = '#input' + i;
                    var inputValue = $(inputId).val();

                    if (inputValue.length === 0) {
                        $(inputId).removeClass("border-primary td textarea cla").addClass("border-danger clas");
                        dataValid = false;
                    } else {
                        $(inputId).removeClass("border-danger clas").addClass("lol cla");
                    }
                }

                if (dataValid) {
                    $.post('datos.php', data, function(response) {
                        alert(response);
                    });

                    // Redirige a otra página después de un breve retraso (puedes ajustar el tiempo)
                    setTimeout(function() {
                        window.location.href = "../Anexo IX/anexoix.php";
                    }, 2000); // Redireccionar después de 2 segundos
                }
            });
        });
    </script>
</body>
</html>
