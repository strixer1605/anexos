<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];

    if(isset($idSalida)) {
        include '../../php/conexion.php';

        $sql = "SELECT * FROM `anexov` WHERE fkAnexoIV = $idSalida";
        $resultado = $conexion->query($sql);

        $sqlAnexoIV = "SELECT `institucionEducativa`, `numeroInstitucion`, `distrito`, `denominacionProyecto`, `lugarVisita`, `fechaSalida`, `fechaRegreso` FROM `anexoiv` WHERE idAnexoIV = $idSalida";
        $resultadoAnexoIV = $conexion->query($sqlAnexoIV);
        $filaAnexoIV = $resultadoAnexoIV->fetch_assoc();

        $fechaSalida = date("d/m/Y", strtotime($filaAnexoIV['fechaSalida']));
        $fechaRegreso = date("d/m/Y", strtotime($filaAnexoIV['fechaRegreso']));
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
            padding: 8px;
            text-align: left;
            text-align: center;
        }
        
        .table th {
            background-color: #f2f2f2;
            text-align: center;/
        }

        .table .nombre {
            text-align: start;
        }

        /* Evitar que las filas de la tabla se dividan entre páginas */
        .table tr {
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
        <div class="row d-flex">
            <div class="col-12 d-flex">
                <div style="padding-left: 40px;" class="col-6 d-flex justify-content-start">
                    <img src="../../imagenes/eest.webp" style="width: 100px;" alt="">
                </div>
                <div class="col-6 d-flex justify-content-end" style="align-items: center;">
                    <img src="../../imagenes/logoProvincia.jpg" alt="">
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end mt-5">
                <p>Corresponde al Expediente N° 5802-1701421/17</p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <p class="m-0 p-0 fw-bold">ANEXO V</p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <p class="m-0 p-0 fw-bold">PLANILLA DE ALUMNOS Y ACOMPAÑANTES</p>
            </div>
            <div style="padding-left: 30px;" class="col-12 d-flex justify-content-star">
                <p class="m-0 p-0">(La presente deberá incorporarse al libro de Registro de Actas Institucionales, antes de 
                    producirse la salida). </p>
            </div>
            <row class="d-flex justify-content-center">
                <div class="col-12 mb-4" style="border: 1px solid black; padding: 20px 25px 25px 20px; width: 95%;">
                    <div class="col-12 d-flex">
                        <div class="col-6 mb-2">
                            <span class="fw-bold">INSTITUCION EDUCATIVA:</span><span><?php
                                echo $filaAnexoIV['institucionEducativa'];
                            ?>
                            </span>
                        </div>
                        <div class="col-6 mb-2 d-flex justify-content-center">
                            <span class="fw-bold">N°</span><span><?php
                                echo $filaAnexoIV['numeroInstitucion'];
                            ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <span class="fw-bold">DISTRITO:</span><span><?php
                            echo $filaAnexoIV['distrito'];
                        ?>
                        </span>
                    </div>
                    <div class="col-12 mb-2">
                        <span class="fw-bold">LUGAR A VISITAR:</span><span><?php
                            echo $filaAnexoIV['lugarVisita'];
                        ?>
                        </span>
                    </div>
                    <div class="col-12">
                        <span class="fw-bold">FECHA:</span><span><?php
                            echo $fechaSalida .' al '. $fechaRegreso;
                        ?>
                        </span>
                    </div>
                </div>
            </row>
            <div class="col-12">
                <table  class="table">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Apellido y Nombre</th>
                            <th scope="col">Documento</th>
                            <th scope="col">Alumno</th>
                            <th scope="col">Edad</th>
                            <th scope="col">Docente</th>
                            <th scope="col">No Docente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($resultado) {
                                $indice = 1;
                                while ($fila = $resultado->fetch_assoc()) {
                                    $alumno = "";
                                    $profesor = "";
                                    $NoProfesor = "";
                                    switch($fila['cargo']) {
                                        case 2: 
                                            $profesor = "X";
                                            break;
                                        case 3:
                                            $alumno = "X";
                                            break;
                                        case 4:
                                            $NoProfesor = "X";
                                            break;
                                    }
                                    echo '
                                    <tr>
                                    <th scope="row">'.$indice.'</th>
                                    <td class="nombre">'.$fila['apellidoNombre'].'</td>
                                    <td>'.$fila['dni'].'</td>
                                    <td>'.$alumno.'</td>
                                    <td>'.$fila['edad'].'</td>
                                    <td>'.$profesor.'</td>
                                    <td>'.$NoProfesor.'</td>
                                    </tr>
                                    ';
                                    $indice++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <span>La presente planilla tendrá validez para toda tramitación oficial que se realice.</span>
            </div>
            <div style="height: 300px;" class="col-12 mt-5 pt-5 d-flex">
                <div class="col-6 mt-5 pt-5">
                    <div class="col-12 d-flex justify-content-center">
                        <span class="fw-bold">Lugar y Fecha</span>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <span class="fw-bold">Firma de Autoridad del Establecimiento</span>
                    </div>
                </div>
                <div class="col-6 mt-5 pt-5">
                    <div class="col-12 d-flex justify-content-center">
                        <span class="fw-bold">Lugar y Fecha</span>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <span class="fw-bold">FIrma del Inspector</span>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <span>
                    1)  El presente formulario deberá estar completo por duplicado (Uno para la Institución y otro para la instancia de Supervisión) 
                </span>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("btnCrearPdf").addEventListener("click", function() {
            var element = document.getElementById('plantilla');
            html2pdf()
                .set({
                    margin: [0.2, 1, 0.2, 1],
                    filename: 'anexoV.pdf',
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