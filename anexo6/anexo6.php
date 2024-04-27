<html>
    <head>
        <tittle></tittle>
        <link rel="stylesheet" href="../librerias/bootstrap.css">
        <script src="../librerias/jquery.js?v=1" ></script>
        <script src="../librerias/boostrap.js" ></script>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <center>
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col-4">
                    <img src="../imagenes/logoBA.png" width="20%">
                </div>
                <div class="col-4">
                    <img src="../imagenes/logo.png" width="25%">
                </div>  
                <div class="col-2">
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                </div>
                <div class="col-7">
                    <h6>Corresponde al Expediente N° 5802-1701421/17</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                </div>
                <div class="col-6">
                    <h4><b>ANEXO VI</b></h4>
                    <h5>AUTORIZACION SALIDA EDUCATIVA/<del>SALIDA DE REPRESENTACION INSTITUCIONAL</del></h5> 
                </div>
                <div class="col-4">
                </div>
            </div>
        </center>
        <div class="row">
            <div class="col-3">
            </div>
            <div class="col-6">
                <p>Por la presente autorizo a mi hijo/a. <input type="text" id="no_ap" class="form-control-sm border-primary">
                DNI Nº <input type="number" id="dni" class="form-control-sm border-primary"> domiciliado en la. <input type="text" id="calle" class="form-control-sm border-primary"> 
                N°. <input type="number" id="num" class="form-control-sm border-primary"> de la localidad de. <input type="text" id="local" class="form-control-sm border-primary"> T.E. 
                <input type="number" id="tele" class="form-control-sm border-primary"> que concurre a la <b>Escuela de Educación Secundaria Técnica Nº1</B> del distrito <b>La
                Costa</b>, a participar de la Salida Educativa <b><?php include('selectAnexo6.php');?></b>, a
                realizarse en las localidades de // a realizarse entre los días // y el // del presente ciclo lectivo.</p>
                <p>Dejo constancia de que he sido informado de las características
                particulares de dicha salida, como así también de los responsables de las
                actividades a desarrollar, medios de transporte a utilizar y donde se realizaran
                dichas actividades.</p>
                <p>Autorizo a los responsables de la salida a disponer cambios con relación
                la planificación de las actividades en aspectos acotados, que resulten
                necesarios, a su solo criterio y sin aviso previo, sobre lo cual me deberán
                informar y fundamentar al regreso.</p>
                <p>Autorizo en caso de necesidad y urgencia, a hacer atender al alumno por
                profesionales médicos y a que se adopten las prescripciones que ellos
                indiquen, sobre el cual requiero inmediato aviso.</p>
                <p>Los docentes a cargo del cuidado y vigilancia activa de los menores no
                serán responsables de los objetos u otros elementos de valor que los mismos
                puedan llevar.
                </p>
            </div>  
        </div>      
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                Lugar: <input type="text" id="lugar" class="col-9 col-md-6 form-control-sm border-primary"></br>
                Fecha: <input type="date" id="fecha" class="col-9 col-md-6 form-control-sm border-primary"></br>
                Firma y aclaración del Padre, Madre, Tutor o Representante Legal: ............................</br>
                DNI: <input type="number" id="dnipa" class="col-9 col-md-6 form-control-sm border-primary">
            </div>
        </div>
        </br>
        <div class="row">
            <div class="col-3">
            </div>
            <div class="col-5">
                <p>-¿Confirma que los datos son veridicos?____<input type="checkbox" class="form-check-input"></p>
            </div>
            <div class="col-1">
                <input type="button"  id="enviar" value="enviar">
                <br>
                <br>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#enviar').click(function () {
                    let nombreyapellido = $('#no_ap').val();
                    let DNI = $('#dni').val();
                    let calle = $('#calle').val();
                    let num = $('#num').val();
                    let localidad = $('#local').val();
                    let telefono = $('#tele').val();
                    let lugar = $('#lugar').val();
                    let fecha = $('#fecha').val();
                    let DNIpa = $('#dnipa').val();
                    console.log(nombreyapellido, DNI, num, calle, localidad, telefono, lugar, fecha, DNIpa);
                    let inputValido = true;

                    if ($('#no_ap').val().length === 0) {
                        $('#no_ap').addClass("border border-danger");
                        inputValido = false;
                    } else {
                        $('#no_ap').removeClass("border border-danger");
                        $('#no_ap').addClass("border border-success");
                    }

                    if ($('#dni').val().length === 0) {
                        $('#dni').addClass("border border-danger");
                        inputValido = false;
                    } else {
                        $('#dni').removeClass("border border-danger");
                        $('#dni').addClass("border border-success");
                    }

                    if ($('#calle').val().length === 0) {
                        $('#calle').addClass("border border-danger");
                        inputValido = false;
                    } else {
                        $('#calle').removeClass("border border-danger");
                        $('#calle').addClass("border border-success");
                    }

                    if ($('#num').val().length === 0) {
                        $('#num').addClass("border border-danger");
                        inputValido = false;
                    } else {
                        $('#num').removeClass("border border-danger");
                        $('#num').addClass("border border-success");
                    }

                    if ($('#local').val().length === 0) {
                        $('#local').addClass("border border-danger");
                        inputValido = false;
                    } else {
                        $('#local').removeClass("border border-danger");
                        $('#local').addClass("border border-success");
                    }

                    if ($('#tele').val().length === 0) {
                        $('#tele').addClass("border border-danger");
                        inputValido = false;
                    } else {
                        $('#tele').removeClass("border border-danger");
                        $('#tele').addClass("border border-success");
                    }

                    if ($('#lugar').val().length === 0) {
                        $('#lugar').addClass("border border-danger");
                        inputValido = false;
                    } else {
                        $('#lugar').removeClass("border border-danger");
                        $('#lugar').addClass("border border-success");
                    }

                    if ($('#fecha').val().length === 0) {
                        $('#fecha').addClass("border border-danger");
                        inputValido = false;
                    } else {
                        $('#fecha').removeClass("border border-danger");
                        $('#fecha').addClass("border border-success");
                    }

                    if ($('#dnipa').val().length === 0) {
                        $('#dnipa').addClass("border border-danger");
                        inputValido = false;
                    } else {
                        $('#dnipa').removeClass("border border-danger");
                        $('#dnipa').addClass("border border-success");
                    }

                    if (inputValido) {
                        $.post('insertAnexo6.php', {
                            no_ap: nombreyapellido,
                            dni: DNI,
                            calle: calle,
                            num: num,
                            local: localidad,
                            tele: telefono,
                            lugar: lugar,
                            fecha: fecha,
                            dnipa: DNIpa,
                        },
                        function(data) {
                            alert(data);
                        // Redirige a otra página después de un breve retraso (puedes ajustar el tiempo)
                        setTimeout(function() {
                            window.location.href = "index-VII.php";
                        }, 2000); // Redireccionar después de 2 segundos
                        });
                    }
                });
            });
        </script>
    </body>
</html>