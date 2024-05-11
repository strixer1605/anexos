<?php
    session_start();
    if (empty($_SESSION['dni']) || empty($_SESSION['nombre_profesor']) || empty($_SESSION['apellido_profesor'])) {
        header('Location: ../index.php');
        exit;
    }

    $dni_encargado = $_SESSION['dni'];
    $nombre = $_SESSION['nombre_profesor'];
    $apellido = $_SESSION['apellido_profesor'];
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Anexo VIII</title>
        <link rel="stylesheet" href="../librerias/bootstrap.css">
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <div class="container">
            <br>
            <a href="../indexs/profesores/salidasMenu.php" class="btn btn-danger" style="color: white;">< Atrás</a>
            <br><br>
            <header>
                <div class="row">
                    <div class="col-5">
                        <img src="../imagenes/logoBA.png" width="80px">
                    </div>
                    <div class="col-7">
                        <img src="../imagenes/logo.png" width="150px">
                    </div>
                </div>
            </header>

            <main>
                <div class="row">
                    <div class="col-12">
                        <div class="float-right">
                            Corresponde al Expediente N° 5802-1701421/17
                        </div>
                        <br>
                        <center>
                            <br>
                            <strong>ANEXO VIII PLAN DE ACTIVIDADES DE SALIDA EDUCATIVA</strong>
                        </center>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Institución educativa</td>
                                    <td>SALA / GRUPO / AÑO</td>
                                    <td>DIVISION</td>
                                    <td>ÁREA / MATERIA / ASIGNATURA / ESPACIO CURRICULAR</td>
                                    <td>DOCENTE RESPONSABLE</td>
                                </tr>
                                <tr>
                                    <td><textarea name="caja1" class="form-control">EEST Nº1</textarea></td>
                                    <td><textarea name="caja2" class="form-control"></textarea></td>
                                    <td><textarea name="caja3" class="form-control"></textarea></td>
                                    <td><textarea name="caja4" class="form-control"></textarea></td>
                                    <td><textarea name="caja5" class="form-control"><?php echo $nombre, " ", $apellido;?></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>OBJETIVO/S DE LA SALIDA</td>
                                    <td>FECHA DE LA SALIDA</td>
                                    <td>LUGAR/ES QUE SE VISITARÁ/N</td>
                                </tr>
                                <tr>
                                    <td><textarea name="caja6" class="form-control"></textarea></td>
                                    <?php include('datosAnexo8.php');?>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <br>
                        <strong>
                            <center>ACTIVIDADES PREVIAS</center>
                        </strong>
                        <br>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>DESCRIPCIÓN</td>
                                    <td>RESPONSABLES</td>
                                    <td>OBSERVACIONES</td>
                                </tr>
                                <tr>
                                    <td><textarea name="caja9" class="form-control"></textarea></td>
                                    <td><textarea name="caja10" class="form-control"></textarea></td>
                                    <td><textarea name="caja11" class="form-control"></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <strong>
                            <br>
                            <center>ACTIVIDADES DURANTE EL DESARROLLO</center>
                        </strong>
                        <br>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>DESCRIPCIÓN</td>
                                    <td>RESPONSABLES</td>
                                    <td>OBSERVACIONES</td>
                                </tr>
                                <tr>
                                    <td><textarea name="caja12" class="form-control"></textarea></td>
                                    <td><textarea name="caja13" class="form-control"></textarea></td>
                                    <td><textarea name="caja14" class="form-control"></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <br>
                        <strong>
                            <center>EVALUACION</center>
                        </strong>
                        <br>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>DESCRIPCIÓN</td>
                                    <td>RESPONSABLES</td>
                                    <td>OBSERVACIONES</td>
                                </tr>
                                <tr>
                                    <td><textarea name="caja15" class="form-control"></textarea></td>
                                    <td><textarea name="caja16" class="form-control"></textarea></td>
                                    <td><textarea name="caja17" class="form-control"></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <footer>
                <center>
                    <br>
                    <button id="guardar" class="btn btn-primary">Enviar</button>
                    <br><br><br>
                </center>
            </footer>
        </div>

        <!-- Scripts -->
        <script src="../librerias/jquery.js"></script>
        <script src="../librerias/boostrap.js"></script>
        <script>
            $(document).ready(function() {
                $('#guardar').click(function() {
                    var inputs = $('.form-control');
                    var dataValid = true;

                    inputs.each(function() {
                        if ($(this).val().length === 0) {
                            $(this).addClass("border-danger");
                            dataValid = false;
                        } else {
                            $(this).removeClass("border-danger");
                        }
                    });

                    if (dataValid) {
                        // Procesamiento de datos y redirección
                        var data = {
                            in1: $('textarea[name="caja1"]').val(),
                            in2: $('textarea[name="caja2"]').val(),
                            in3: $('textarea[name="caja3"]').val(),
                            in4: $('textarea[name="caja4"]').val(),
                            in5: $('textarea[name="caja5"]').val(),
                            in6: $('textarea[name="caja6"]').val(),
                            in7: $('input[name="caja7"]').val(),
                            in8: $('textarea[name="caja8"]').val(),
                            in9: $('textarea[name="caja9"]').val(),
                            in10: $('textarea[name="caja10"]').val(),
                            in11: $('textarea[name="caja11"]').val(),
                            in12: $('textarea[name="caja12"]').val(),
                            in13: $('textarea[name="caja13"]').val(),
                            in14: $('textarea[name="caja14"]').val(),
                            in15: $('textarea[name="caja15"]').val(),
                            in16: $('textarea[name="caja16"]').val(),
                            in17: $('textarea[name="caja17"]').val()
                        };

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
