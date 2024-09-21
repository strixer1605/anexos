<?php
    session_start();
    if(!$_SESSION['dniProfesor']) {
        header('Location: ../../../index.php');
    } else {
        $idSalida = $_SESSION['idSalida'];
        include '../../../php/conexion.php';
        $sql = "
            SELECT 
            -- Datos de la tabla anexoiv
            aiv.denominacionProyecto,
            CONCAT(aiv.lugarSalida, ', ', aiv.fechaSalida, ', ', aiv.horaSalida) AS salida,
            CONCAT(aiv.lugarRegreso, ', ', aiv.fechaRegreso, ', ', aiv.horaRegreso) AS regreso,
            aiv.lugarVisita,
            aiv.nombreHospedaje,
            aiv.domicilioHospedaje,
            aiv.telefonoHospedaje,
            aiv.localidadHospedaje,
            aiv.apellidoNombreEncargado,
            
            -- Concatenar los nombres con salto de línea
            GROUP_CONCAT(av.apellidoNombre SEPARATOR ',\n') AS nombresConcatenados,
            
            -- Concatenar los DNI con salto de línea si también quieres separarlos
            GROUP_CONCAT(av.dni SEPARATOR ',\n') AS dniConcatenados,
            
            -- Datos de la tabla anexoix
            aix.razonSocial,
            aix.domicilioTransporte,
            aix.telefonoTransporte,
            
            -- Datos de la tabla anexox
            ax.localidadEmpresa,
            ax.hospitales,
            ax.hospitalesTelefono,
            ax.hospitalesDireccion,
            ax.hospitalesLocalidad,
            ax.datosInteresNombre,
            ax.datosInteresTelefono,
            ax.datosInteresDireccion,
            ax.datosInteresLocalidad

        FROM anexoiv aiv
        -- Unimos con la tabla anexov
        LEFT JOIN anexov av ON av.fkAnexoIV = aiv.idAnexoIV AND av.cargo = 2
        -- Unimos con la tabla anexoix
        LEFT JOIN anexoix aix ON aix.fkAnexoIV = aiv.idAnexoIV
        -- Unimos con la tabla anexox
        LEFT JOIN anexox ax ON ax.fkAnexoIV = aiv.idAnexoIV

        -- Condición para que el fkAnexoIV coincida con el idSalida almacenado en la sesión
        WHERE aiv.idAnexoIV = $idSalida
        GROUP BY aiv.idAnexoIV;
        ";
        
        // Mostrar los nombres separados
        // foreach ($nombres_array as $nombre) {
        //     echo $nombre . "<br>";
        // }

    
        // Ejecutar la consulta
        $result = $conexion->query($sql);
        $fila = $result->fetch_assoc();
        

        //poner en columna los nombres de docentes a cargo
        $nombres = $fila['nombresConcatenados'];
        $nombres_array = explode("\n", $nombres);
        
        // Formatear las fechas
        function formatearFecha($fecha, $hora) {
            $fechaFormato = date('d/m/Y', strtotime($fecha));
            return $fechaFormato . ', ' . $hora;
        }

        // Dar formato a la fecha de salida y regreso
        if ($fila) {
            // Separar la fecha y la hora de los campos
            list($lugarSalida, $fechaSalida, $horaSalida) = explode(', ', $fila['salida']);
            list($lugarRegreso, $fechaRegreso, $horaRegreso) = explode(', ', $fila['regreso']);

            // Formatear las fechas
            $fila['salida'] = $lugarSalida . ', ' . formatearFecha($fechaSalida, $horaSalida);
            $fila['regreso'] = $lugarRegreso . ', ' . formatearFecha($fechaRegreso, $horaRegreso);

        } else {
            echo "No se encontraron resultados.";
        }
    }

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
                         <p class="fw-bold margenDato"><?php echo $fila['denominacionProyecto'] ?></p>
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="col-12">
                         <span>Lugar, Día y hora de salida</span>
                     </div>
                     <div class="col-12">
                         <p class="fw-bold margenDato"><?php echo $fila['salida'] ?></p>
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="col-12">
                         <span>Lugar, Día y hora de regreso</span>
                     </div>
                     <div class="col-12">
                         <p class="fw-bold margenDato"><?php echo $fila['regreso'] ?></p>
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="col-12">
                         <span>Lugares a visitar</span>
                     </div>
                     <div class="col-12">
                         <p class="fw-bold margenDato"><?php echo $fila['lugarVisita'] ?></p>
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
                        <span class="fw-bold">Hostel:</span> <span><?php echo $fila['nombreHospedaje'] ?></span>
                    </div>
                    <div class="col-6">
                        <span class="fw-bold">Teléfono:</span> <span><?php echo $fila['telefonoHospedaje'] ?></span>
                    </div>
                </div>
                <div class="col-12 d-flex">
                    <div class="col-6">
                        <span class="fw-bold">Domicilio:</span> <span><?php echo $fila['domicilioHospedaje'] ?></span>
                    </div>
                    <div class="col-6">
                        <span class="fw-bold">Localidad:</span> <span><?php echo $fila['localidadHospedaje'] ?></span>
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
                                echo $nombre . "<br>";
                            }
                    ?>
                    </div>
                    <div class="col-6 fw-bold">
                    <?php
                        // foreach ($telefonos_array as $telefono) {
                        //     echo htmlspecialchars($telefono) . "<br>"; // Muestra cada teléfono en una nueva línea
                        // }
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
                            <span>Empresa:</span> <span><?php echo $fila['razonSocial'] ?></span>
                        </div>
                        <div class="col-6">
                            <span>Dirección:</span> <span><?php echo $fila['domicilioTransporte'] ?></span>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <span>Teléfono:</span> <span><?php echo $fila['telefonoTransporte'] ?></span>
                        </div>
                        <div class="col-6">
                            <span>Localidad:</span> <span><?php echo $fila['localidadEmpresa'] ?></span>
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
                            <span class="fw-bold"><?php echo $fila['hospitales'] ?></span>
                        </div>
                        <div class="col-6">
                            <span>Dirección:</span> <span class="fw-bold"><?php echo $fila['hospitalesDireccion'] ?></span>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <span>Teléfono:</span> <span class="fw-bold"><?php echo $fila['hospitalesTelefono'] ?></span>
                        </div>
                        <div class="col-6">
                            <span>Localidad:</span> <span class="fw-bold"><?php echo $fila['hospitalesLocalidad'] ?></span>
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
                            <span class="fw-bold"><?php echo $fila['datosInteresNombre']?></span>
                        </div>
                        <div class="col-6">
                            <span>Dirección:</span> <span class="fw-bold"><?php echo $fila['datosInteresDireccion']?></span>
                        </div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <span>Teléfono:</span> <span class="fw-bold"><?php echo $fila['datosInteresTelefono']?></span>
                        </div>
                        <div class="col-6">
                            <span>Localidad:</span> <span class="fw-bold"><?php echo $fila['datosInteresLocalidad']?></span>
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