<?php
    session_start();
    if (!$_SESSION['dniProfesor']){
        header('Location: ../../index.php');
    } else {
        include '../../php/conexion.php';
        $idSalida = $_SESSION['idSalida'];

        $sql = "SELECT 
            -- Datos de la tabla anexoiv
            aiv.*,

            -- Concatenar los apellidoNombre con salto de línea y una coma para separar
            GROUP_CONCAT(av.apellidoNombre SEPARATOR ',\n') AS nombresConcatenados

            FROM anexoiv aiv
            -- Unimos con la tabla anexov (donde cargo = 2)
            LEFT JOIN anexov av ON av.fkAnexoIV = aiv.idAnexoIV AND av.cargo = 2

            -- Condición para que el fkAnexoIV coincida con $idSalida
            WHERE aiv.idAnexoIV = $idSalida
            GROUP BY aiv.idAnexoIV;
            ";
            
        $resultado = mysqli_query($conexion, $sql);
        $fila = mysqli_fetch_assoc($resultado);

        $nombresConcatenados = $fila['nombresConcatenados'];

        // Dividir los nombres en un array
        $nombresArray = explode("\n", $nombresConcatenados);

        // Crear un array de cargos con 'profesor' para cada nombre
        $cargos = array_fill(0, count($nombresArray), 'profesor');


        //formatear fechas de regreso y salida de YY-MM-DD A DD-MM-YY
        $fechaSalida = $fila['fechaSalida'];
        $timestampSalida = strtotime($fechaSalida);
        $fechaFormateadaSalida = date('d/m/Y', $timestampSalida);

        $fechaRegreso = $fila['fechaRegreso'];
        $timestampRegreso = strtotime($fechaRegreso);
        $fechaFormateadaRegreso = date('d/m/Y', $timestampRegreso);

        $sqlContarPersonas = "SELECT cargo, COUNT(*) as cantidad 
        FROM anexov 
        WHERE fkAnexoIV = $idSalida 
        GROUP BY cargo";

        $resultadoContar = mysqli_query($conexion, $sqlContarPersonas);

        $cantidadAlumnos = 0;
        $cantidadDocentes = 0;
        $cantidadAcompañantes = 0;

        while ($row = mysqli_fetch_assoc($resultadoContar)) {
            switch ($row['cargo']) {
            case 2: // Docente
            $cantidadDocentes = $row['cantidad'];
            break;
            case 3: // Alumno
            $cantidadAlumnos = $row['cantidad'];
            break;
            case 4: // Acompañante
            $cantidadAcompañantes = $row['cantidad'];
            break;
            }
        }
    }
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
                        <img src="../../imagenes/eest.webp" style="width: 100px; margin-right: 60px;" alt="">
                    </div>
                    <div style="align-items: center;" class="col-6 d-flex justify-content-end ">
                        <img src="../../imagenes/logoProvincia.jpg" alt="">
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
                    if ($fila['tipoSolicitud'] == 1) {
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
                                <span class="fw-normal" id="regionData"><?php echo $fila['region'] ?></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="dataDistrito" class="fw-bold">
                                Distrito:
                                <span class="fw-normal"><?php echo $fila['distrito'] ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div id="dataInstitucion" class="fw-bold">
                                    Institucion Educativa:
                                    <span class="fw-normal"> <?php echo $fila['institucionEducativa'] ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="dataNumero" class="fw-bold">
                                    N°
                                    <span class="fw-normal"> <?php echo $fila['numeroInstitucion'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div id="dataDomicilio" class="fw-bold">
                                    Domicilio:
                                    <span class="fw-normal"><?php echo $fila['domicilioInstitucion'] ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="dataTelefono" class="fw-bold">
                                    Teléfono:
                                    <span class="fw-normal"><?php echo $fila['telefonoInstitucion'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="dataDenominacion" class="fw-bold">
                                Denominación del Proyecto:
                                <span class="fw-normal"><?php echo $fila['denominacionProyecto'] ?></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="dataLugar" class="fw-bold">
                                Lugar a visitar:
                                <span class="fw-normal"> <?php echo $fila['lugarVisita'] ?></span>
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
                                    <span class="fw-normal"> <?php echo $fila['lugarSalida'] ?></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p id="dataHoraSalida" class="fw-bold">Hora:
                                    <span class="fw-normal"> <?php echo $fila['horaSalida'] ?> </span>Aprox
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
                                    <span class="fw-normal"> <?php echo $fila['lugarRegreso'] ?></span>
                                </p>
                            </div>
                            <div class="col-4">
                                <p class="fw-bold">Hora:
                                    <span class="fw-normal"> <?php echo $fila['horaRegreso'] ?> </span>Aprox
                                </p>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="fw-bold" style="width: 500px;">
                                Itinerario:
                                <span class="fw-normal text-break"> <?php echo $fila['itinerario'] ?></span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="fw-bold" style="width: 500px;">
                                Actividades:
                                <span class="fw-normal text-break"> <?php echo $fila['actividades'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div style="border: 2px solid black; padding-left: 30px; padding-top: 20px;" class="row mt-3">
                        <div class="row mb-3">
                            <div class="col-8">
                                <div class="fw-bold">
                                    Datos del/los docentes/s a cargo Apellido y nombre:
                                    <br>
                                    <span class="fw-normal"><?php 
                                        foreach ($nombresArray as $nombre) {
                                            echo $nombre . "<br>";
                                        }
                                    ?></span>
                                </div>
                            </div>
                            <div class="col-4 d-flex justify-content-center">
                                <div class="fw-bold">
                                    <br>
                                    Cargo
                                    <br>
                                    <span class="fw-normal"><?php 
                                        foreach ($cargos as $cargo) {
                                            echo $cargo . "<br>";
                                        }
                                    ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="fw-bold">
                                Cantidad de Alumnos:
                                <span class="fw-normal"> <?php echo $cantidadAlumnos?></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="fw-bold">
                                Cantidad de Docentes Acompañantes:
                                <span class="fw-normal"> <?php echo $cantidadDocentes?></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="fw-bold">
                                Cantidad de No Docentes:
                                <span class="fw-normal"> <?php echo $cantidadAcompañantes?></span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="fw-bold">
                                Total de personas:
                                <span class="fw-normal"> <?php $totalPersonas = $cantidadAcompañantes + $cantidadDocentes + $cantidadAlumnos; echo $totalPersonas ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="fw-bold">
                                    Hospedaje:
                                    <span class="fw-normal"> <?php echo $fila['nombreHospedaje'] ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold">
                                    Teléfono:
                                    <span class="fw-normal"> <?php if ($fila['telefonoHospedaje'] == 0){echo "-";} ?></span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="fw-bold">
                                    Domicilio:
                                    <span class="fw-normal"> <?php echo $fila['domicilioHospedaje'] ?></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold">
                                    Localidad:
                                    <span class="fw-normal"> <?php echo $fila['localidadHospedaje'] ?></span>
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <p class="fw-bold" style="width: 500px;">Gastos estimativos de la excursión:
                                <span class="fw-normal text-break"> <?php echo "$", $fila['gastosEstimativos'] ?></span>
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
                        margin: [0.2, 1, 0.2, 1],
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