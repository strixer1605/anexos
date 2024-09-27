<?php
    session_start();

    
    if (isset($_SESSION['dniPadre'])) {
        include '../../php/conexion.php';
        
        $idSalida = $_SESSION['idSalida'];
        $dniHijo = $_SESSION['dniHijo'];
        $dniPadre = $_SESSION['dniPadre'];

        $sql = "
                SELECT 
                CONCAT(a.apellido, ' ', a.nombre) AS nombreCompleto, -- Concatenar apellido y nombre
                ax.distrito,
                CONCAT(ax.institucionEducativa, ' ', ax.numeroInstitucion) AS institucion, -- Concatenar institucionEducativa y numeroInstitucion
                ax.denominacionProyecto,
                ax.localidadViaje,
                DATE_FORMAT(ax.fechaSalida, '%d') AS diaSalida, -- Obtener el día de fechaSalida
                DATE_FORMAT(ax.fechaSalida, '%M') AS mesSalida, -- Obtener el mes de fechaSalida
                DATE_FORMAT(ax.fechaRegreso, '%d') AS diaRegreso, -- Obtener solo el día de fechaRegreso
                DATE_FORMAT(ax.fechaRegreso, '%M') AS mesRegreso, -- Obtener el mes de fechaRegreso
                av.domicilio,
                av.altura,
                av.localidad,
                t.telefono
            FROM 
                anexoiv ax
            JOIN 
                anexovi av ON ax.idAnexoIV = av.fkAnexoIV -- Cambiar a fkAnexoIV para hacer el JOIN correcto
            JOIN 
                alumnos a ON a.dni = av.dniAlumno -- Cambiar a av.dni para hacer el JOIN correcto
            JOIN 
                telefono t ON t.dni = 18892329
            WHERE 
                ax.idAnexoIV = 1
            AND 
                av.dniAlumno = 47950839
        ";
    
        $resultado = $conexion->query($sql);
        $fila = $resultado->fetch_assoc();

        $fechaActual = date('d/m/Y');

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
                <p class="m-0 p-0 fw-bold">ANEXO VI</p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <p class="m-0 p-0">AUTORIZACION SALIDA EDUCATIVA/SALIDA DE REPRESENTACION INSTITUCIONAL</p>
            </div>
            <div class="row d-flex justify-content-center mt-5">    
                <div class="col-10">
                    <p>
                        Por la presente autorizo a mi hijo/a <?php echo $fila['nombreCompleto'] ?> DNI Nº<?php echo $dniHijo ?>, domiciliado en la <?php echo $fila['domicilio'] ?>N°<?php echo $fila['altura'] ?> de la localidad de <?php echo $fila['localidad'] ?>, T.E.<?php echo $fila['telefono'] ?> que concurre a la <?php echo $fila['institucion'] ?> del distrito <?php echo $fila['distrito'] ?>, a participar de la Salida Educativa <?php echo $fila['denominacionProyecto'] ?>. , a realizarse en la localidade de <?php echo $fila['localidadViaje'] ?> partiendo el día <?php echo $fila['diaSalida'] ?> del mes de <?php echo $fila['mesSalida'] ?> y regresando el <?php echo $fila['diaRegreso'] ?> de <?php echo $fila['mesRegreso'] ?> del presente ciclo lectivo.
                        Dejo constancia de que he sido informado de las características particulares de dicha salida, como así también de los responsables de las actividades a desarrollar, medios de transporte a utilizar y donde se realizaran dichas actividades.
                        Autorizo a los responsables de la salida a disponer cambios con relación  la planificación de las actividades en aspectos acotados, que resulten necesarios, a su solo criterio y sin aviso previo, sobre lo cual me deberán informar y fundamentar al regreso.
                        Autorizo en caso de necesidad y urgencia, a hacer atender al alumno por profesionales médicos y a que se adopten las prescripciones que ellos indiquen, sobre el cual requiero inmediato aviso.
                        Los docentes a cargo del cuidado y vigilancia activa de los menores no serán responsables de los objetos u otros elementos de valor que los mismos puedan llevar.
                    </p>
                    <p>
                        Lugar: <?php echo $fila['localidad'] ?>
                    </p>
                    <p>
                        Fecha: <?php echo $fechaActual; ?>
                    </p>
                    <p>
                        Firma y aclaración del Padre, Madre, Tutor o Representante Legal
                    </p>
                    <p>
                        DNI:<?php echo $dniPadre ?>
                    </p>
                    <p>
                        Teléfono de Urgencia (consignar varios): Cuando los alumnos que participen sean mayores de edad (18 años), resulta suficiente la autorización firmada por los mismos alumnos
                    </p>
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