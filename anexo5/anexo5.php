<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href=" estilo.css">
    <link rel="stylesheet" href="../librerias/bootstrap.css">
    <script src="../librerias/jquery.js"></script>
    <script src="../librerias/boostrap.js"></script>
    <title>Anexo V</title>
    <meta charset="utf-8">
</head>

<body style="margin: 0; padding: 0;" >
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
                    <h6>Corresponde al Expediente N° 5802-1701421/17</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h4>ANEXO VASDFASDFASDFADSFADSFASDFASDF</h4>
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
                    <p><b>LUGAR A VISITAR:</b><input type="text" class="form-control" name="lugar" placeholder="Lugar de visita"
                            required></p>
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
                    <input type="radio" class="form-control" name="cargo" value="alumno" id="alumno">
                    <center>
                        Alumno
                    </center>
                </div>
                <div class="col">
                    <input type="radio" class="form-control" name="cargo" value="docente" id="docente">
                    <center>
                        Docente
                    </center>
                </div>
                <div class="col">
                    <input type="radio" class="form-control" name="cargo" value="no_docente" id="no_docente">
                    <center>
                        No es docente
                    </center>
                </div>
                <center>
                    <button type="button" class="btn btn-info mt-3" id="miID">Enviar</button>
                </center>
            </div>
        </form>
    
        <div class="container">
            <?php
            include('select_users.php');
            ?>
        </div>
    
        <br><br><br><br>
        <p>
        <center>
            <a class="link" href="../anexo8/anexo.php">Ir al anexo</a>
        </center>
    
            <h5>La presente planilla tendrá validez para toda tramitación oficial que se realice.</h5>
        </p>
        <br><br>
        <p>
            <h5>1) El presente formulario deberá estar completo por duplicado (Uno para la Institución y otro para la
                instancia de Supervisión)</h5>
        </p>
        <input type="file"></input>
        <input type="file"></input>
        </center>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#miID').click(function () {
            let apellido_y_nombre = $('#nom_ape').val();
            let documento = $('#doc').val();
            let edad = $('#edad').val();
            let cargo = $('input[name="cargo"]:checked').val();
            console.log(apellido_y_nombre, documento, edad, cargo);
            let inputValido = true;

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
                    nom_ape: apellido_y_nombre,
                    doc: documento,
                    edad: edad,
                    cargo: cargo,
                },
                function (data) {
                    alert(data);
                    // Actualizar la página después de agregar un nuevo dato
                    location.reload();
                });
            }
        });
    });
</script>

