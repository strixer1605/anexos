<?php
    include '../../php/verificarSessionPDF.php';

    $idSalida = $_SESSION['idSalida'];
    $sql = "SELECT * FROM anexoix WHERE fkAnexoIV = $idSalida";
    $resultado = mysqli_query($conexion, $sql);
    $fila = $resultado->fetch_assoc();

    //formatear fecha vigencia
    $vigencia1 = $fila['vigencia1'];
    $timestampVigencia1 = strtotime($vigencia1);
    $fechaFormateadaVigencia1 = date('d/m/Y', $timestampVigencia1);
    
    $vigencia2 = $fila['vigencia2'];
    $timestampVigencia2 = strtotime($vigencia2);
    $fechaFormateadaVigencia2 = date('d/m/Y', $timestampVigencia2);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Anexo IX</title>
    <style>
        /* Evitar saltos de página dentro de divs */
        .container, .row, .d-flex {
            page-break-inside: avoid;
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
                <p class="m-0 p-0 fw-bold">ANEXO IX</p>
            </div>
            <div class="col-12 mb-4 d-flex justify-content-center">
                <p class="fw-bold m-0 p-0">PLANILLA INFORME DE TRANSPORTE A CONTRATAR</p>
            </div>
            
            <!-- Cuerpo PDF -->
            <!-- Datos empresa de transporte -->
            <div class="col-12 mb-2">
                <span class="fw-bold">Nombre de la persona o razón social de la empresa:</span> <span><?php echo $fila['razonSocial'] ?></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-bold">Domicilio del propietario o la empresa:</span> <span><?php echo $fila['domicilioTransporte'] ?></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-bold">Teléfono del propietario o la empresa:</span> <span><?php echo $fila['telefonoTransporte'] ?></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-bold">Domicilio del gerente o responsable:</span> <span><?php echo $fila['domicilioResponsable'] ?></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-bold">Teléfono:</span> <span><?php echo $fila['telefono'] ?></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-bold">Teléfono móvil:</span> <span><?php echo $fila['telefonoMovil'] ?></span>
            </div>
            <div class="col-12 mb-5">
                <span class="fw-bold">Titularidad del vehículo:</span> <span><?php echo $fila['titularidadVehiculo'] ?></span>
            </div>


            <!-- Datos empresa aseguradora -->

            <div class="col-12 mb-2">
                <span class="fw-bold">Compañia aseguradora:</span> <span class="fw-bold"><?php echo $fila['companiaAseguradora'] ?></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-bold">Número de póliza:</span> <span><?php echo $fila['numeroPoliza'] ?></span>
            </div>
            <div class="col-12 mb-5">
                <span class="fw-bold">Tipo de seguro:</span> <span><?php echo $fila['tipoSeguro'] ?></span>
            </div>


            <!-- Datos conductor N°1 -->
            
            <div class="col-12 mb-2">
                <span class="fw-bold">Nombre del Conductor:</span> <span><?php echo $fila['nombreConductor1'] ?></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-bold">DNI del conductor:</span> <span><?php echo $fila['dniConductor1'] ?></span>
            </div>
            <div class="col-12 mb-3">
                <div class="col-12 mb-1">
                    <span>N° de carnet de conducir y vigencia:</span>
                </div>
                <div class="col-12">
                    <span style="margin: 0px 0px 0px 30px;" class="fw-bold">Licencia N°:</span><span><?php echo $fila['numeroLicencia1'] ?></span>
                </div>
                <div class="col-12">
                    <span style="margin: 0px 0px 0px 30px;" class="fw-bold">Vigencia:</span><span><?php echo date('d/m/Y', strtotime($fila['vigencia1'])) ?></span>
                </div>
            </div>
            

            <!-- Datos conductor N°2 -->
            
            <div class="col-12 mb-2">
                <span class="fw-bold">Nombre del Conductor: </span> <span><?php echo $fila['nombreConductor2'] ?></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-bold">DNI del conductor: </span> <span><?php echo $fila['dniConductor2'] ?></span>
            </div>
            <div class="col-12 mb-2">
                <div class="col-12 mb-1">
                    <span>N° de carnet de conducir y vigencia:</span>
                </div>
                <div class="col-12">
                    <span style="margin: 0px 0px 0px 30px;" class="fw-bold">Licencia N°: </span><span><?php echo $fila['numeroLicencia2'] ?></span>
                </div>
                <div class="col-12">
                    <span style="margin: 0px 0px 0px 30px;" class="fw-bold">Vigencia: </span><span><?php echo date('d/m/Y', strtotime($fila['vigencia2'])) ?></span>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.getElementById("btnCrearPdf").addEventListener("click", function() {
            var element = document.getElementById('plantilla');
            html2pdf()
                .set({
                    margin: [0.2, 0.2, 0.2, 0.2],
                    filename: 'anexoIX.pdf',
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