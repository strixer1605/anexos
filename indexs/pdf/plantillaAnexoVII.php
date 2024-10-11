<?php
    include '../../php/verificarSessionPDF.php';
        
    $idSalida = $_SESSION['idSalida'];
    $dniAlumno = $_SESSION['dniAlumno'];
    $dniPadre = $_SESSION['dniPadre'];

    $sql = "
        SELECT 
        CONCAT(a.apellido, ' ', a.nombre) AS nombreCompleto, -- Concatenar apellido y nombre del alumno
        CONCAT(p.apellido, ' ', p.nombre) AS nombreCompletoPadre, -- Concatenar apellido y nombre del padre o tutor
        CONCAT(av.domicilio, ' N° ', av.altura) AS direccionCompleta, -- Concatenar domicilio y altura en formato requerido
        ax.localidadViaje, -- Traer el campo localidadViaje de anexoiv
        av.*, -- Traer todos los campos de la tabla anexovi
        t.telefono, -- Traer el teléfono del padre o tutor
        avii.* -- Traer todos los campos de la tabla anexovii
    FROM 
        alumnos a
    JOIN 
        padresTutores p ON p.dni = $dniPadre -- Relacionar con padresTutores usando dniPadre
    JOIN 
        anexovi av ON av.dniAlumno = a.dni -- Relacionar con anexovi usando dniAlumno
        AND av.dniPadre = $dniPadre -- Filtrar por dni del padre
        AND av.fkAnexoIV = $idSalida -- Filtrar por id de la salida
    JOIN 
        anexoiv ax ON ax.idAnexoIV = av.fkAnexoIV -- Relacionar con anexoiv usando fkAnexoIV para obtener localidadViaje
    JOIN 
        telefono t ON t.dni = $dniPadre -- Relacionar con tabla telefono usando dni del padre
    JOIN 
        anexovii avii ON avii.dniAlumno = a.dni -- Relacionar con anexovii usando dniAlumno
        AND avii.fkAnexoIV = $idSalida -- Filtrar por id de la salida
    WHERE 
        a.dni = $dniAlumno";
    $resultado = $conexion->query($sql);
    $fila = $resultado->fetch_assoc();

    $fechaActual = date('d/m/Y');        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=$idSalida.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Document</title>
    <style>
        ol {
            list-style-type: lower-alpha; /* Cambia el estilo de la lista a letras minúsculas */
        }
    </style>
</head>
<body>
    <button type="button" class="btn btn-primary" id="btnCrearPdf">Crear PDF</button>

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
                <p class="m-0 p-0 fw-bold">ANEXO VII</p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <p class="fw-medium m-0 p-0">PLANILLA DE SALUD PARA SALIDA EDUCATIVA/SALIDA DE REPRESENTACION INSTITUCIONAL</p>
            </div>
            <div class="row d-flex justify-content-center">    
                <div class="col-12 fw-medium">
                    <p class="m-0 p-0">Fecha: <?php echo $fechaActual ?></p>
                    <p class="m-0 p-0">Apellido y Nombres Alumno: <?php echo $fila['nombreCompleto'] ?></p>
                    <p class="m-0 p-0">Apellido y Nombre del Padre, Madre, Tutor o Representante  Legal: <?php echo $fila['nombreCompletoPadre'] ?></p>
                    <span>Dirección: <?php echo $fila['direccionCompleta'] ?></span>
                    <span>Teléfono: <?php echo $fila['telefono'] ?></span>
                    <p class="m-0 p-0">Lugar a Viajar: <?php echo $fila['localidadViaje'] ?></p>
                </div>
            </div>


            <div style="width: 1120px; margin-left: 20px;" class="row">
                <div class="col-12 fw-medium">
                    <span>1. ¿Es alérgico?</span> 
                    <?php 
                        if ($fila['alergico'] == 1) {
                            echo '
                            <span style="border: 1px solid black;">SI</span>
                            - 
                            <span style="border: 1px solid black; text-decoration: line-through;">NO</span>
                            ';
                        } else {
                            echo '
                            <span style="border: 1px solid black; text-decoration: line-through;">SI</span>
                            - 
                            <span style="border: 1px solid black;">NO</span>
                            
                            ';
                        }
                    ?>
                    <span>(tachar lo que no corresponda).</span>
                    <p>En caso de respuesta positiva ¿a que? <br>
                    <?php echo htmlspecialchars($fila['tipoAlergia']) ?>
                    </p>
                </div>
                <div class="col-12 fw-medium">
                    <span>2. ¿Ha sufrio en los último 30 días?</span> 
                    <span>(marcar con una X)</span>
                    <?php
                    // Definir un array asociativo con los campos y las etiquetas
                    $condiciones = [
                        'sufrioA' => 'Procesos Inflamatorios',
                        'sufrioB' => 'Fracturas o esguinces',
                        'sufrioC' => 'Enfermedades infecto-contagiosas'
                    ];

                    echo '<ol>';
                    
                    // Recorrer el array de condiciones
                    foreach ($condiciones as $campo => $etiqueta) {
                        echo '<li>' . $etiqueta . ' ' . ($fila[$campo] == 1 ? '(X)' : '()') . '</li>';
                    }

                    // Mostrar el texto plano para la opción "Otras"
                    echo '<li>Otras: ' . htmlspecialchars($fila['otroMalestar']) . '</li>';
                    
                    echo '</ol>';
                ?>

                </div>
                <div class="col-12 fw-medium">
                    <span>3. ¿Está tomando alguna medicación?</span>
                    
                    <?php 
                        if ($fila['medicacion'] == 1) {
                            echo '
                            <span style="border: 1px solid black;">SI</span>
                            - 
                            <span style="border: 1px solid black; text-decoration: line-through;">NO</span>
                            ';
                        } else {
                            echo '
                            <span style="border: 1px solid black; text-decoration: line-through;">SI</span>
                            - 
                            <span style="border: 1px solid black;">NO</span>
                            
                            ';
                        }
                    ?>
                    <span>(tachar lo que no corresponda).</span>
                    <p>En caso de respuesta positiva: ¿Cuál? <br>
                    <?php echo htmlspecialchars($fila['tipoMedicacion']) ?></p>
                </div>
                <div class="col-12 fw-medium">
                    <span>4. Deje constancia de cualquier indicación que estime necesario deba conocer el personal médico y docente a cargo: <?php echo htmlspecialchars($fila['observaciones']) ?></span>
                </div>
                <div class="col-12 fw-medium">
                    <span>5. ¿Tiene Obra Social?</span>
                    <?php 
                        if ($fila['obraSocial'] == 1) {
                            echo '
                            <span style="border: 1px solid black;">SI</span>
                            - 
                            <span style="border: 1px solid black; text-decoration: line-through;">NO</span>
                            ';
                        } else {
                            echo '
                            <span style="border: 1px solid black; text-decoration: line-through;">SI</span>
                            - 
                            <span style="border: 1px solid black;">NO</span>
                            
                            ';
                        }
                    ?>
                    <span>(tachar lo que no corresponda).</span>
                    <span>En caso de respuesta positiva deberá acompañar la presente planilla con carnet o copia del carnet.</span>
                </div>
            </div>


            <div class="row">
                <?php
                    // Array con los nombres de los meses en español
                    $mesesEspañol = [
                        1 => 'enero',
                        2 => 'febrero',
                        3 => 'marzo',
                        4 => 'abril',
                        5 => 'mayo',
                        6 => 'junio',
                        7 => 'julio',
                        8 => 'agosto',
                        9 => 'septiembre',
                        10 => 'octubre',
                        11 => 'noviembre',
                        12 => 'diciembre'
                    ];

                    // Obtener la fecha actual
                    $fechaActualDia = date('d'); // Día actual
                    $mesActual = date('n'); // Mes actual en número (1 a 12)
                    $nombreMes = $mesesEspañol[$mesActual]; // Nombre del mes en español
                ?>

                <div class="col-12 fw-medium">
                    <p>Dejo constancia de haber cumplimentado la planilla de salud de mi hijo/a <?php echo $fila['nombreCompleto']; ?>, en <?php echo $fila['localidad']; ?>, a los <?php echo $fechaActualDia; ?> días del mes de <?php echo $nombreMes; ?> autorizando por la presente a actuar en caso de emergencia, según lo dispongan profesionales médicos.
                        La presente se realiza bajo forma de declaración jurada con relación a los datos consignados arriba.</p>
                </div>

                <div class="col-12 mt-1 d-flex">
                    <div class="col-6 mt-1 pt-1">
                        <div class="col-12 d-flex justify-content-center">
                            <span class="fw-bold">Firma Padre, Madre, Tutor o</span>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <span class="fw-bold">Representante Legal</span>
                        </div>
                    </div>
                    <div class="col-6 mt-1 pt-1">
                        <div class="col-12 d-flex justify-content-center">
                            <span class="fw-bold">Aclaración de firma</span>
                        </div>
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
                    filename: 'anexoVI.pdf',
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