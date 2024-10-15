<?php
    include '../../php/verificarSessionDirector.php';

    include '../../php/conexion.php';
    $idSalida = $_GET['idSalida'];
    $sql = "SELECT `tipoSolicitud`, `fechaSalida`, `localidadViaje` FROM anexoiv WHERE idAnexoIV = $idSalida";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);

    $fechaSalida = new DateTime($fila['fechaSalida']);
    $fechaFormateada = $fechaSalida->format('d/m/Y'); 

    $nombreCompleto = $_SESSION['nombreDir'] . ' '  . $_SESSION['apellidoDir'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Anexo XI</title>
    <style>
        /* Evitar saltos de página dentro de divs */
        .container, .row, .d-flex {
            page-break-inside: avoid;
        }

        .margenDato{
            margin: 0px 0px 0px 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-primary" style="margin-top: 5px;" id="btnCrearPdf">Crear PDF</button>

            </div>
            <div class="col-6">
                <nav class="navbar navbar-custom">
                    <div class="container-fluid d-flex align-items-center">
                        <a onclick="window.history.back();" class="btn btn-warning ms-auto" style="color: white;">Atrás</a>
                    </div>
                </nav>
            </div>
        </div>
    </div>

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
                <p class="m-0 p-0 fw-bold">ANEXO XI</p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <p class="m-0 p-0 fw-bold">DIPREGEP</p>
            </div>
            <div class="col-12 mb-4 d-flex justify-content-center">
                <p style="text-align: center;" class="fw-bold m-0 p-0">PLANILLA DE DECLARACIÓN JURADA DE COMUNICACIÓN ESCRITA DE LA 
                REALIZACIÓN DE SALIDAS EDUCATIVAS / DE REPRESENTACIÓN INSTITUCIONAL</p>
            </div>
            
            <!-- Cuerpo PDF -->
            <div class="col-12">
                <div class="col-12 mb-2">
                    <span>NOMBRE DEL ESTABLECIMIENTO:</span> <span>Escuela de Educación Secudaria Técnica N°1 "Raúl Scalabrini Ortiz"</span>
                </div>
                <div class="col-12 d-flex mb-2">
                    <div class="col-6">
                        <span>DIPREGEP N°:</span> <span></span>
                    </div>
                    <div class="col-6">
                        <span>CUE:</span> <span></span>
                    </div>
                </div>
                <div class="col-12 d-flex mb-2">
                    <div class="col-6">
                        <span>DOMICILIO:</span>  <span> Calle 104 y 124. Santa teresita</span>
                    </div>
                    <div class="col-6">
                        <span>DISTRITO:</span>  <span>La Costa</span>                        
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <span>DIRECTOR DEL ESTABLECIMIENTO:</span>  <span><?php echo $nombreCompleto ?></span>
                </div>
                <div class="col-12 mb-2">
                    <span>REPRESENTANTE LEGAL:</span>  <span></span>
                </div>
                <div class="col-12 mb-2">
                    <span>ENTIDAD PROPIETARIA:</span>  <span></span>
                </div>
                <?php 
                    if ($fila['tipoSolicitud'] == 1) {
                        echo '
                            <div class="col-12 mb-4">
                                <span>FECHA Y LUGAR DE REALIZACIÓN DE LA <span style="text-decoration: line-through;">SALIDA EDUCATIVA</span> /
                                SALIDA DE REPRESENTACIÓN INSTITUCIONAL:</span>  <span>'.$fechaFormateada. ' - '.$fila['localidadViaje'].'</span>
                            </div>
                        ';
                    } else {
                        echo '
                            <div class="col-12 mb-4">
                                <span>FECHA Y LUGAR DE REALIZACIÓN DE LA SALIDA EDUCATIVA /
                                <span style="text-decoration: line-through;">SALIDA DE REPRESENTACIÓN INSTITUCIONAL</span>:</span>  <span>'.$fechaFormateada. ' - '.$fila['localidadViaje'].'</span>
                            </div>
                        ';
                    }
                ?>
            </div>
            <div class="col-12 mb-5">
                <p>
                En nuestro carácter de Representante Legal y Propietario/a del establecimiento educativo de referencia declaramos bajo juramento haber dado cumplimiento a los requerimientos del Anexo III de la presente referidos a: transporte, lugar de realización de la Salida Educativa y Salida de representación Institucional, autorizaciones de los padres o responsables de los menores, planillas de salud, cumplimiento de la relación docente/alumno e información a los padres de la Salida Educativa / Salida de Representación Institucional que realizará la institución educativa en el marco de su Proyecto Institucional, poniendo a disposición de la autoridad educativa que lo requiera los Anexos IV, V, VI, VII, VIII, IX, X, XI y XIII completos, como así también el libro de Actas Institucionales.
                </p>
            </div>
            <div class="col-12 d-flex mb-5 mt-3">
                <div class="col-6 d-flex justify-content-center">
                    <span>FIRMA Y SELLO</span>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <span>FIRMA Y SELLO</span>
                </div>
            </div>
            <div class="col-12 text-end mt-5">
                <span>IF-2017-01706868-GDEBA-CGCYEDGCYE</span>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("btnCrearPdf").addEventListener("click", function() {
            var element = document.getElementById('plantilla');
            html2pdf()
                .set({
                    margin: [0.2, 0.2, 0.2, 0.2],
                    filename: 'anexoXI.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 1
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