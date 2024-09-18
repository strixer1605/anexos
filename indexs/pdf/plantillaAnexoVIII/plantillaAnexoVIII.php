<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];

    if(isset($idSalida)) {
        include '../../../php/conexion.php';

        function formatearCampoConExplode($campo, $delimitador = ',') {
            if (!empty($campo)) {
                return explode($delimitador, $campo);
            }
            return [];
        }

        function procesarResultados($conexion, $idSalida) {
            $sql = "SELECT objetivo, lugaresVisitar, descripcionPrevias, responsablesPrevias, descripcionDurante, responsablesDurante, descripcionEvaluacion, responsablesEvaluacion FROM `anexoviii` WHERE fkAnexoIV = $idSalida";
            $resultado = $conexion->query($sql);
            $fila = $resultado->fetch_assoc();
        
            if ($fila) {
                // Procesar cada campo específico que necesita explode
                $fila['objetivo'] = formatearCampoConExplode($fila['objetivo']);
                $fila['lugaresVisitar'] = formatearCampoConExplode($fila['lugaresVisitar']);
                $fila['descripcionPrevias'] = formatearCampoConExplode($fila['descripcionPrevias']);
                $fila['responsablesPrevias'] = formatearCampoConExplode($fila['responsablesPrevias']);
                $fila['descripcionDurante'] = formatearCampoConExplode($fila['descripcionDurante']);
                $fila['responsablesDurante'] = formatearCampoConExplode($fila['responsablesDurante']);
                $fila['descripcionEvaluacion'] = formatearCampoConExplode($fila['descripcionEvaluacion']);
                $fila['responsablesEvaluacion'] = formatearCampoConExplode($fila['responsablesEvaluacion']);
                return $fila;
            } else {
                return null;
            }
        }

        $sql = "SELECT * FROM `anexoviii` WHERE fkAnexoIV = $idSalida";
        $resultado = $conexion->query($sql);
        $fila = $resultado->fetch_assoc();

        // Usar la función para procesar los resultados
        $resultados = procesarResultados($conexion, $idSalida);

        $sqlAnexoIV = "SELECT `institucionEducativa`, `numeroInstitucion`, `lugarVisita`, `fechaSalida` FROM `anexoiv` WHERE idAnexoIV = $idSalida";
        $resultadoAnexoIV = $conexion->query($sqlAnexoIV);
        $filaAnexoIV = $resultadoAnexoIV->fetch_assoc();

        $fechaSalida = date("d/m/Y", strtotime($filaAnexoIV['fechaSalida']));
    } else {
        echo "no hay nada";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Document</title>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            border: 1px solid black;
            /* padding: 8px; */
            text-align: center;
            vertical-align: middle;
        }
        
        .table th {
            background-color: #f2f2f2;
            text-align: center;
            /* width: 100px; */
        }
        /* Evitar que las filas de la tabla se dividan entre páginas */
        .table tr {
            page-break-inside: avoid;
        }

        table {
            page-break-inside: avoid;
        }

        /* Evitar saltos de página dentro de divs */
        .container, .row, .d-flex {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <button type="button" class="btn btn-primary" id="btnCrearPdf">Crear PDF</button>

    <div id="plantilla" class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 d-flex">
                <div style="padding-left: 40px;" class="col-6 d-flex justify-content-start">
                    <img src="../../../imagenes/eest.webp" style="width: 100px;" alt="">
                </div>
                <div class="col-6 d-flex justify-content-end" style="align-items: center;">
                    <img src="../../../imagenes/logoProvincia.jpg" alt="">
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end mt-5">
                <p>Corresponde al Expediente N° 5802-1701421/17</p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <p class="m-0 p-0 fw-bold">ANEXO VIII</p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <p class="fw-medium m-0 p-0">PLAN DE ACTIVIDADES DE SALIDA EDUCATIVA</p>
            </div>
            
            <!-- Cuerpo PDF -->
            
            <div class="col-12">
                <table class="table">
                    <tr>
                        <th style="width: 50px;" scope="col">INSTITUCION EDUCATIVA</th>
                        <th style="width: 50px;" scope="col">SALA / GRUPO/AÑO</th>
                        <th style="width: 50px;" scope="col">DIVISIÓN</th>
                        <th style="width: 50px;" scope="col">ÁREA/ MATERIA/ ASIGNATURA/ ESPACIO CURRICULAR</th>
                        <th style="width: 50px;" scope="col">DOCENTE RESPONSABLE</th>
                    </tr>
                    <tbody>
                        <td><span><?php echo $fila['institucion'] ?></span></span></td>
                        <td><?php 
                            echo $fila['año'];
                        ?></td>
                        <td><?php 
                            echo $fila['division'];
                        ?></td>
                        <td><?php 
                            echo $fila['area'];
                        ?></td>
                        <td><?php 
                            echo $fila['docente'];
                        ?></td>
                    </tbody>
                </table>
            </div>
            
            <center><p>Se adjunta copia del proyeco a foja/s 18 (hojas)</p></center>
            <div class="col-12">
                <table class="table">
                    <tr>
                        <th scope="col">OBJETIVO/S DE LA SALIDA</th>
                        <th scope="col">FECHA DE LA SALIDA</th>
                        <th scope="col">LUGAR/ES QUE SE VISITARÁ/N</th>
                    </tr>
                    <tbody>
                        <td>
                        <?php
                            foreach ($resultados['objetivo'] as $objetivo) {
                                echo "• " . trim($objetivo) . "<br><br>";
                            }
                        ?>
                            </td>
                        <td>
                            <?php
                                echo date("d/m/Y", strtotime($fila['fechaSalida'])); 
                            ?>
                        </td>
                        <td>
                            <?php
                                foreach($resultados['lugaresVisitar'] as $lugar) {
                                    echo "• " . trim($lugar) . "<br><br>";
                                }
                            ?>
                        </td>
                    </tbody>
                </table>
            </div>

            <center><p class="fw-bold">ACTIVIDADES PREVIAS</p></center>
            <div class="col-12">
                <table class="table">
                    <tr>
                        <th scope="col">DESCRIPCIÓN</th>
                        <th scope="col">RESPONSABLES</th>
                        <th scope="col">OBSERVACIONES</th>
                    </tr>
                    <tbody>
                        <td>
                            <?php
                                foreach ($resultados['descripcionPrevias'] as $descripcionPrevias) {
                                    echo "• " . trim($descripcionPrevias) . "<br><br>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                foreach ($resultados['responsablesPrevias'] as $responsablesPrevias) {
                                    echo "• " . trim($responsablesPrevias) . "<br>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $fila['observacionesPrevias'];
                            ?>
                        </td>
                    </tbody>
                </table>
            </div>

            <center><p class="fw-bold">ACTIVIDADES DURANTE EL DESARROLLO</p></center>
            <div class="col-12">
                <table class="table">
                    <tr>
                        <th scope="col">DESCRIPCIÓN</th>
                        <th scope="col">RESPONSABLES</th>
                        <th scope="col">OBSERVACIONES</th>
                    </tr>
                    <tbody>
                        <td>
                            <?php
                                foreach ($resultados['descripcionDurante'] as $descripcionDurante) {
                                    echo "• " . trim($descripcionDurante) . "<br><br>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                foreach ($resultados['responsablesDurante'] as $responsablesDurante) {
                                    echo "• " . trim($responsablesDurante) . "<br>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $fila['observacionesPrevias'];
                            ?>
                        </td>
                    </tbody>
                </table>
            </div>


            <center><p class="fw-bold">EVALUACIÓN</p></center>
            <div class="col-12">
                <table class="table">
                    <tr>
                        <th scope="col">DESCRIPCIÓN</th>
                        <th scope="col">RESPONSABLES</th>
                        <th scope="col">OBSERVACIONES</th>
                    </tr>
                    <tbody>
                    <td>
                            <?php
                                foreach ($resultados['descripcionEvaluacion'] as $descripcionEvaluacion) {
                                    echo "• " . trim($descripcionEvaluacion) . "<br><br>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                foreach ($resultados['responsablesEvaluacion'] as $responsablesEvaluacion) {
                                    echo "• " . trim($responsablesEvaluacion) . "<br>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $fila['observacionesPrevias'];
                            ?>
                        </td>
                    </tbody>
                </table>
            </div>
            <center><p>1) El presente formulario deberá estar completo por duplicado (Uno para la Institución y otro para la instancia de Supervisión)</p></center>
            <div class="row">
                <div class="col-4 fw-bold">
                    <div class="col-12 d-flex justify-content-center">…………………………………</div>
                    <div class="col-12 d-flex justify-content-center">Firma del Docente</div>
                    <div class="col-12 d-flex justify-content-center">Responsable</div>
                </div>
                <div class="col-4 fw-bold">
                    <div class="col-12 d-flex justify-content-center">…………………………………</div>
                    <div class="col-12 d-flex justify-content-center">Firma del jefe de</div>
                    <div class="col-12 d-flex justify-content-center">Departamento</div>
                    <div class="col-12 d-flex justify-content-center fw-normal fst-italic">(si correspondiera)</div>
                </div>
                <div class="col-4 fw-bold">
                    <div class="col-12 d-flex justify-content-center">…………………………………</div>
                    <div class="col-12 d-flex justify-content-center">Firma del Director/a del</div>
                    <div class="col-12 d-flex justify-content-center">del</div>
                    <div class="col-12 d-flex justify-content-center">Establecimiento</div>
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
                    filename: 'anexoVIII.pdf',
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
</body>
</html>