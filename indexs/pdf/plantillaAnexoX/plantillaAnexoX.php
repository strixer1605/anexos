<?php
    $nombres = "SALVADO, Martin Raúl
    ARMANDOLA, Enrique Hugo
    ROBASTI, Soledad Fernanda";
    $telefonos = "(02257) 15502537
    (02257) 15545439
    (02246) 15505697";
    
    // Dividir las cadenas en arrays
    $nombres_array = explode("\n", $nombres);
    $telefonos_array = explode("\n", $telefonos);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Anexo X</title>
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
    <button type="button" class="btn btn-primary" id="btnCrearPdf">Crear PDF</button>

    <div id="plantilla" class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 d-flex">
                <div style="padding-left: 40px;" class="col-6 d-flex justify-content-start">
                    <img src="logoEscuela.png" style="width: 100px;" alt="">
                </div>
                <div class="col-6 d-flex justify-content-end" style="align-items: center;">
                    <img src="logoProvincia.jpg" alt="">
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end mt-5">
                <p>Corresponde al Expediente N° 5802-1701421/17</p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <p class="m-0 p-0 fw-bold">ANEXO X</p>
            </div>
            <div class="col-12 mb-4 d-flex justify-content-center">
                <p class="fw-bold m-0 p-0">PLANILLA INFORMATIVA PARA ALUMNOS</p>
            </div>
            
            <!-- Cuerpo PDF -->
            <!-- Datos salida -->
             <div class="col-12 mb-3">
                 <div class="col-12">
                     <div class="col-12">
                         <span>Nombre del Proyecto de salida</span>
                     </div>
                     <div class="col-12">
                         <p class="fw-bold margenDato">Ahora es Tiempo de Sumar XIV - El Regreso</p>
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="col-12">
                         <span>Lugar, Día y hora de salida</span>
                     </div>
                     <div class="col-12">
                         <p class="fw-bold margenDato">EEST N°1, 23/10/2022, 09:00hs.</p>
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="col-12">
                         <span>Lugar, Día y hora de regreso</span>
                     </div>
                     <div class="col-12">
                         <p class="fw-bold margenDato">EEST N°1, 03/11/2022, 15:00hs.</p>
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="col-12">
                         <span>Lugares a visitar</span>
                     </div>
                     <div class="col-12">
                         <p class="fw-bold margenDato">Villa La Angostura. San Carlos de Bariloche</p>
                     </div>
                 </div>
             </div>

            <!-- Datos estadia -->
            <div class="col-12 mb-3">
                <div class="col-12">
                    <span>Lugares de estadía-domicilios y teléfonos</span>
                </div>
                <div class="col-12 d-flex">
                    <div class="col-6">
                        <span class="fw-bold">Hostel:</span> <span>La Angostura</span>
                    </div>
                    <div class="col-6">
                        <span class="fw-bold">Teléfono:</span> <span>0294 449-4834</span>
                    </div>
                </div>
                <div class="col-12 d-flex">
                    <div class="col-6">
                        <span class="fw-bold">Domicilio:</span> <span>Calle Barbagelata N°147</span>
                    </div>
                    <div class="col-6">
                        <span class="fw-bold">Localidad:</span> <span>Villa La Angostura</span>
                    </div>
                </div>
            </div>
            
            <!-- Datos acompañantes -->
            <div class="col-12 mb-3">
                <div class="col-12">
                    <span>Nombre y teléfonos de los acompañantes</span>
                </div>
                <div class="col-12 d-flex margenDato">
                    <div class="col-6 fw-bold">
                    <?php
                        foreach ($nombres_array as $nombre) {
                            echo htmlspecialchars($nombre) . "<br>"; // Muestra cada nombre en una nueva línea
                        }
                    ?>
                    </div>
                    <div class="col-6 fw-bold">
                    <?php
                        foreach ($telefonos_array as $telefono) {
                            echo htmlspecialchars($telefono) . "<br>"; // Muestra cada teléfono en una nueva línea
                        }
                    ?>
                    </div>
                </div>
            </div>
            
            <!-- Datos  empresa/s contratadas -->
            <div class="col-12 mb-3">
                <div class="col-12">
                    <span>Empresa y/o empresas contratadas, nombre, dirección y teléfonos</span>
                </div>
                <div class="col-12 margenDato">

                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <span>Empresa:</span> <span></span>
                        </div>
                        <div class="col-6">
                            <span>Dirección:</span> <span></span>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <span>Teléfono:</span> <span></span>
                        </div>
                        <div class="col-6">
                            <span>Localidad:</span> <span></span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Datos  hospitales/centros -->
            <div class="col-12 mb-3">
                <div class="col-12">
                    <span>Hospitales y Centros asistenciales cercanos</span>
                </div>
                <div class="col-12 margenDato">

                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <span class="fw-bold">Hospital Dr. Óscar Arraiz</span>
                        </div>
                        <div class="col-6">
                            <span>Dirección:</span> <span class="fw-bold">Copello 311</span>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <span>Teléfono:</span> <span class="fw-bold">02944 - 49170</span>
                        </div>
                        <div class="col-6">
                            <span>Localidad:</span> <span class="fw-bold">Villa La Angostura</span>
                        </div>
                    </div>
                </div>
            </div>
           
           
            <!-- Otros datos de interes -->
            <div class="col-12 mb-3">
                <div class="col-12">
                    <span>Otros datos de interés:</span>
                </div>
                <div class="col-12 margenDato">

                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <span class="fw-bold">Comisaria de Villa La Angostura</span>
                        </div>
                        <div class="col-6">
                            <span>Dirección:</span> <span class="fw-bold">Av. Arrayanes N° 242</span>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <span>Teléfono:</span> <span class="fw-bold">0249 - 449-4121</span>
                        </div>
                        <div class="col-6">
                            <span>Localidad:</span> <span class="fw-bold">Villa La Angostura</span>
                        </div>
                    </div>
                </div>
            </div>
            <p>(La conformidad de recepción del presente por parte de los padres se encuentra en la planilla adjunta</p>
        </div>
    </div>
    <script>
        document.getElementById("btnCrearPdf").addEventListener("click", function() {
            var element = document.getElementById('plantilla');
            html2pdf()
                .set({
                    margin: 0.3,
                    filename: 'anexoX.pdf',
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