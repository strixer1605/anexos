<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $region = $_POST['region'];
    $distrito = $_POST['distrito'];
    $institucionEducativa = $_POST['institucionEducativa'];
    $numero = $_POST['numero'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $denominacionProyecto = $_POST['denominacionProyecto'];
    $lugarVisitar = $_POST['lugarVisitar'];
    $fechaSalida = $_POST['fechaSalida'];
    $timestampSalida = strtotime($fechaSalida);
    $fechaFormateadaSalida = date('d/m/Y', $timestampSalida);
    $lugarSalida = $_POST['lugarSalida'];
    $horaSalida = $_POST['horaSalida'];
    $fechaRegreso = $_POST['fechaRegreso'];
    $timestampRegreso = strtotime($fechaRegreso);
    $fechaFormateadaRegreso = date('d/m/Y', $timestampRegreso);
    $lugarRegreso = $_POST['lugarRegreso'];
    $horaRegreso = $_POST['horaRegreso'];
    $itinerario = $_POST['itinerario'];
    $actividades = $_POST['actividades'];
    $docentes = $_POST['docentes'];
    $docentesFormateado = nl2br($docentes);
    $cargos = $_POST['cargos'];
    $cargosFormateados = nl2br($cargos);
    $cantidadAlumnos = $_POST['cantidadAlumnos'];
    $cantidadDocentes = $_POST['cantidadDocentes'];
    $cantidadNoDocentes = $_POST['cantidadNoDocentes'];
    $totalPersonas = $_POST['totalPersonas'];
    $hospedaje = $_POST['hospedaje'];
    $telefonoHospedaje = $_POST['telefonoHospedaje'];
    $domicilioHospedaje = $_POST['domicilioHospedaje'];
    $localidadHospedaje = $_POST['localidadHospedaje'];
    $gastosEstimativos = $_POST['gastosEstimativos'];
    $tipoSalida = $_POST['tipoSalida'];
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario y Generación de PDF</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <button type="button" class="btn btn-primary" id="btnCrearPdf">Crear PDF</button>

    <!-- Plantilla oculta para el PDF -->
    <div id="plantilla" class="container">
        <div class="row d-flex">
            <div class="col-12 d-flex">
                <div class="col-6 d-flex justify-content-center ">
                    <img src="logoEscuela.png" style="width: 100px; margin-right: 60px;" alt="">
                </div>
                <div style="align-items: center;" class="col-6 d-flex justify-content-end ">
                    <img src="logoProvincia.jpg" alt="">
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end mt-5">
                <p>Corresponde al Expediente N° 5802-1701421/17</p>
            </div>
            <div class="col-12 d-flex justify-content-center ">
                <p class="m-0 p-0 fw-bold">ANEXO IV</p>
            </div>
            <div class="col-12 d-flex justify-content-center ">
                <p class="m-0 p-0">Solicitud para la realización de:</p>
            </div>
            <div class="col-12 d-flex justify-content-center ">
                <?php
                if ($tipoSalida === "Salida Educativa") {
                    echo '
                    <p class="m-0 p-0"><span style="text-decoration: line-through;">Salida Educativa</span> / Salida de Representación Institucional</p>
                    ';
                } else {
                    echo '
                    <p class="m-0 p-0">Salida Educativa / <span style="text-decoration: line-through;">Salida de Representación Institucional</span></p>
                    ';
                }
                ?>
            </div>
            <div style="padding-left: 30px; padding-right: 30px;" class="col-12">
                <div style="border: 2px solid black; padding-left: 30px; padding-top: 20px;" class="row mb-5">
                    <div class="col-12">
                        <div id="regionData" class="fw-bold">
                            Región:
                            <span class="fw-normal" id="regionData"><?php echo $region ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="dataDistrito" class="fw-bold">
                            Distrito:
                            <span class="fw-normal"><?php echo $distrito ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div id="dataInstitucion" class="fw-bold">
                                Institucion Educativa:
                                <span class="fw-normal"> <?php echo $institucionEducativa ?></span>
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-center">
                            <div id="dataNumero" class="fw-bold">
                                N°
                                <span class="fw-normal"> <?php echo $numero ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div id="dataDomicilio" class="fw-bold">
                                Domicilio:
                                <span class="fw-normal"><?php echo $domicilio ?></span>
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-center">
                            <div id="dataTelefono" class="fw-bold">
                                Teléfono:
                                <span class="fw-normal"><?php echo $telefono ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="dataDenominacion" class="fw-bold">
                            Denominación del Proyecto:
                            <span class="fw-normal"><?php echo $denominacionProyecto ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="dataLugar" class="fw-bold">
                            Lugar a visitar:
                            <span class="fw-normal"> <?php echo $lugarVisitar ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        SALIDA
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p id="dataFechaSalida" class="fw-bold">Fecha:
                                <span class="fw-normal"> <?php echo $fechaFormateadaSalida ?></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p id="dataLugarSalida" class="fw-bold">Lugar:
                                <span class="fw-normal"> <?php echo $lugarSalida ?></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p id="dataHoraSalida" class="fw-bold">Hora:
                                <span class="fw-normal"> <?php echo $horaSalida ?> </span>Aprox
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <p>REGRESO</p>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p class="fw-bold">Fecha:
                                <span class="fw-normal"> <?php echo $fechaFormateadaRegreso ?></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="fw-bold">Lugar:
                                <span class="fw-normal"> <?php echo $lugarRegreso ?></span>
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="fw-bold">Hora:
                                <span class="fw-normal"> <?php echo $horaRegreso ?> </span>Aprox
                            </p>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="fw-bold">
                            Itinerario:
                            <span class="fw-normal"> <?php echo $itinerario ?></span>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="fw-bold">
                            Actividades:
                            <span class="fw-normal"> <?php echo $actividades ?></span>
                        </div>
                    </div>
                </div>
                <div style="border: 2px solid black; padding-left: 30px; padding-top: 20px;" class="row mt-3">
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="fw-bold">
                                Datos del/los docentes/s a cargo Apellido y nombre:
                                <br>
                                <span class="fw-normal"><?php echo $docentesFormateado ?></span>
                            </div>
                        </div>
                        <div class="col-4 d-flex justify-content-center">
                            <div class="fw-bold">
                                <br>
                                Cargo
                                <br>
                                <span class="fw-normal"><?php echo $cargosFormateados ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="fw-bold">
                            Cantidad de alumnos:
                            <span class="fw-normal"> <?php echo $cantidadAlumnos ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="fw-bold">
                            Cantidad de docentes acompañantes:
                            <span class="fw-normal"> <?php echo $cantidadDocentes ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="fw-bold">
                            Cantidad de no docentes:
                            <span class="fw-normal"> <?php echo $cantidadNoDocentes ?></span>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="fw-bold">
                            Total de personas:
                            <span class="fw-normal"> <?php echo $totalPersonas ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="fw-bold">Deberán alojarse en:</p>
                    </div>
                    <div class="col-12">
                        <div class="fw-bold">
                            Nombre del hotel, camping, etc:
                            <span class="fw-normal"> <?php echo $hospedaje ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="fw-bold">
                            Teléfono:
                            <span class="fw-normal"> <?php echo $telefonoHospedaje ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="fw-bold">
                            Domicilio:
                            <span class="fw-normal"> <?php echo $domicilioHospedaje ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="fw-bold">
                            Localidad:
                            <span class="fw-normal"> <?php echo $localidadHospedaje ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="fw-bold">Gastos estimativos de la excursión:
                            <span class="fw-normal"> <?php echo $gastosEstimativos ?></span>
                        </p>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 mb-5 mt-5 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <div>......................................................................</div>
                                <div>Lugar y fecha Firma de Autoridad del Establecimiento</div>
                            </div>
                        </div>
                        <div class="col-6 mb-5 mt-5 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <div>......................................................................</div>
                                <div>Lugar y fecha Firma del Inspector (si correspondiere)</div>
                            </div>
                        </div>
                        <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <div>......................................................................</div>
                                <div>Lugar y fecha Firma del Inspector Jefe Distrital (si correspondiere)</div>
                            </div>
                        </div>
                        <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <div>......................................................................</div>
                                <div>Lugar y fecha Firma del Inspector Jefe Regional (si correspondiere)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        1) El presente formulario deberá estar completo por duplicado (Uno para
                        la institución otro la para la instancia de Supervisión)
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("btnCrearPdf").addEventListener("click", function() {
            var element = document.getElementById('plantilla');
            html2pdf()
                .set({
                    margin: 1,
                    filename: 'documento.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 3,
                        letterRendering: true,
                    },
                    jsPDF: {
                        unit: "in",
                        format: "a4",
                        orientation: 'portrait'
                    }
                })
                .from(element)
                .save();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzN1tKtxD8gKMQirbRiJb0P1zVAVwXlzh/4N7B6+z1p+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-oMRHiZB0S1XwFlaUJfqRfaUW7pT4KFp/1mrO2YdV71aU/UOl7+KtrMk5R0N2KJ0g" crossorigin="anonymous"></script>
</body>

</html>