<?php
    session_start();
    if (empty($_SESSION['dni']) || empty($_SESSION['nombre_profesor']) || empty($_SESSION['apellido_profesor'])) {
        header('Location: ../index.php');
        exit;
    }

    $dni_encargado = $_SESSION['dni'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="../librerias/bootstrap.css">
    <script src="../librerias/jquery.js"></script>
    <script src="../librerias/boostrap.js"></script>
    <title>Anexo V</title>
    <meta charset="utf-8">
</head>

<body style="margin: 0; padding: 0;" >
    <script>
        var dni_encargado = '<?php echo $dni_encargado; ?>';
    </script>
    <style>
        .link {
            display: inline-block;
            padding: 10px 20px;
            background-color: green;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .link:hover {
            background-color: #2374b5;
        }
    </style>
    <div class="d-flex justify-content-center">
        <div id="container">
            <div class="col-md-8 mx-auto">
                <br>
                <a href="../indexs/profesores/salidasMenu.php" class="btn btn-danger" style="color: white;">&lt; Atrás</a>
                <br><br>
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
                        <h4>ANEXO V</h4>
                        <h6>PLANILLA DE ALUMNOS Y ACOMPAÑANTES</h6>
                        <h6>(La presente deberá incorporarse al libro de Registro de Actas Institucionales, antes de
                            producirse la salida).</h6>
                        </div>
                    </div>
                </div>

                <p>
                    <div class="row">
                        <div class="col">
                            <div class="abru">
                                <div class="row">
                                    <div class="col">
                                        <p><b>INSTITUCIÓN EDUCATIVA:</b> E.E.S.T. </p>
                                    </div>
                                    <div class="col">
                                        <b>N°</b>1
                                    </div>
                                </div>
                                <p><b>DISTRITO:</b> La Costa</p>
                                <p><b>LUGAR A VISITAR:</b>
                                    <?php include('selectSalidas.php') ?>
                                </p>
                                <p><b>FECHA:</b><input type="date" class="form-control" name="fecha" required></p>
                            </div>
                        </div>
                    </div>
                </p>
                        
                <form class="mt-3" action="insert_user.php" method="post">
                    <div class="abru">
                        <h3><center>Agregar persona</center></h3>
                        <div class="col">
                            <input type="text" class="form-control" id="nom_ape" placeholder="Apellido y nombre" required>
                        </div><br>
                        <div class="col">
                            <input type="text" class="form-control" id="doc" placeholder="Documento" required>
                        </div><br>
                        <div class="col">
                            <input type="text" class="form-control" id="edad" placeholder="Edad" required>
                        </div><br>
                        <div class="col">
                            <?php include('selectCargos.php');?>
                        </div><br>
                        <center>
                            <button type="button" class="btn btn-info mt-3" id="miID">Enviar</button>
                        </center>
                    </div>
                </form>
                        
                <div class="container">
                    <br><br>
                    <?php include('select_users.php'); ?>
                </div>
                <br>    
                <br>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#miID').click(function () {
                let fkanexo4 = $('#salida').val();
                let apellido_y_nombre = $('#nom_ape').val();
                let documento = $('#doc').val();
                let edad = $('#edad').val();
                let cargo = $('#cargo').val();
                console.log(apellido_y_nombre, documento, edad, cargo);
                let inputValido = true;

                if ($('#salida').val().length === 0) {
                    $('#salida').addClass("border border-danger");
                    inputValido = false;
                } else {
                    $('#salida').removeClass("border border-danger");
                    $('#salida').addClass("border border-success");
                }
                
                if ($('#nom_ape').val().length === 0) {
                    $('#nom_ape').addClass("border border-danger");
                    inputValido = false;
                } else {
                    $('#nom_ape').removeClass("border border-danger");
                    $('#nom_ape').addClass("border border-success");
                }

                if ($('#doc').val().length === 0) {
                    $('#doc').addClass("border border-danger");
                    inputValido = false;
                } else {
                    $('#doc').removeClass("border border-danger");
                    $('#doc').addClass("border border-success");
                }

                if ($('#edad').val().length === 0) {
                    $('#edad').addClass("border border-danger");
                    inputValido = false;
                } else {
                    $('#edad').removeClass("border border-danger");
                    $('#edad').addClass("border border-success");
                }

                if (!cargo) {
                    $('#alumno, #docente, #no_docente').addClass("border border-danger");
                    inputValido = false;
                } else {
                    $('#alumno, #docente, #no_docente').removeClass("border border-danger");
                    $('#alumno, #docente, #no_docente').addClass("border border-success");
                }

                if (inputValido) {
                    $.post('insert_user.php', {
                        salida: fkanexo4,
                        nom_ape: apellido_y_nombre,
                        doc: documento,
                        edad: edad,
                        cargo: cargo,
                    },
                    function (data) {
                        alert(data);
                        location.reload();
                    });
                }
            });
        });
    </script>
</body>
</html>
