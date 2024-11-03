<?php
    require ('fpdf/fpdf.php');
    include ('../../php/verificarSessionPDF.php');

    $dniAlumno = $_SESSION['dniAlumno'];
    $idSalida = $_SESSION['idSalida'];

    $sqlAnexoIV = "SELECT * FROM anexoiv WHERE idAnexoIV = $idSalida";
    $sqlPlanilla = "SELECT * FROM planillainfoanexo WHERE fkAnexoIV = $idSalida";
    
    $resultadoPlantilla = mysqli_query($conexion, $sqlPlanilla);
    $filasPlantilla = mysqli_fetch_assoc($resultadoPlantilla);

    // $sqlAnexoPadre = "SELECT * FROM alumnos WHERE dni = $dniAlumno";

    $sql = "SELECT 
            CONCAT(a.nombre, ' ', a.apellido) AS nombreCompleto,
            c.ano,
            c.division
        FROM 
            alumnos a
        INNER JOIN 
            asignacionesalumnos aa ON a.dni = aa.dni_alumnos
        INNER JOIN 
            cursosciclolectivo cl ON cl.id = aa.id_cursosciclolectivo
        INNER JOIN 
            cursos c ON c.id = cl.id_cursos
        WHERE 
            a.dni = ?
            AND cl.estado = 'H'
        ORDER BY 
            aa.id_cursosciclolectivo DESC
        LIMIT 1;";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $dniAlumno);
    $stmt->execute();
    $resultadoAlumno = $stmt->get_result();

    $resultadoAnexoIV = mysqli_query($conexion, $sqlAnexoIV);
    $filaAnexoIV = mysqli_fetch_assoc($resultadoAnexoIV);

    if ($fila = $resultadoAlumno->fetch_assoc()) {
        $nombreCompleto = $fila['nombreCompleto'];
        $nombre = ucwords(strtolower($nombreCompleto));
        $ano = $fila['ano'];
        $division = $fila['division'];
    } else {
        echo "No se encontraron resultados.";
    }

    setlocale(LC_TIME, 'es_ES.UTF-8');
    $fechaSalidaObj = DateTime::createFromFormat('Y-m-d', $filaAnexoIV['fechaSalida']);

    $fechaSalida = $fechaSalidaObj->format('d/m/y');
    $horaSalida = DateTime::createFromFormat('H:i:s', $filaAnexoIV['horaSalida'])->format('H:i');
    $salida = $filaAnexoIV['lugarSalida'] . ', ' . $fechaSalida . ', ' . $horaSalida;

    $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
    $formatter->setPattern('MMMM');  

    $diaSalida = $fechaSalidaObj->format('d');
    $mesSalida = ucfirst($formatter->format($fechaSalidaObj));

    $fechaRegreso = DateTime::createFromFormat('Y-m-d', $filaAnexoIV['fechaRegreso'])->format('d/m/y');
    $horaRegreso = DateTime::createFromFormat('H:i:s', $filaAnexoIV['horaRegreso'])->format('H:i');
    $regreso = $filaAnexoIV['lugarRegreso'] . ', ' . $fechaRegreso . ', ' . $horaRegreso;

    $pdf = new FPDF();
    
    $pdf->SetMargins(25, 25, 25, 25);
    // Establecer margen inferior
    $pdf->SetAutoPageBreak(true, 20);
    
    $pdf->AddPage();

    // Encabezado
    $pdf->Image('../../imagenes/eest.png', 15, 8, 20);
    $pdf->Image('../../imagenes/logoprovincia.jpg', 107, 8, 90); // Logo

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 40, mb_convert_encoding('IF-2024-35030478-GDEBA-CGCYEDG', 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
    
    $pdf->Ln(-10);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0, 10, mb_convert_encoding('ANEXO VI', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 11); 
    $pdf->MultiCell(0, 7, mb_convert_encoding('PLANILLA INFORMATIVA Y AUTORIZACIÓN', 'ISO-8859-1', 'UTF-8'), 0, 'C');
    
    $pdf->Ln(5);
    $pdf->MultiCell(0, 7, mb_convert_encoding('SALIDA EDUCATIVA / REPRESENTACIÓN INSTITUCIONAL', 'ISO-8859-1', 'UTF-8'), 0, 'C');
    $pdf->MultiCell(0, 7, mb_convert_encoding('(Estudiantes con menos de 18 años de edad)', 'ISO-8859-1', 'UTF-8'), 0, 'C');

    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->MultiCell(0, 7, mb_convert_encoding('1- PLANILLA INFORMATIVA PARA PADRES, MADRES, TUTORES O RESPONSABLES (completa la Escuela):', 'ISO-8859-1', 'UTF-8'), 0,);

    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(66, 10, mb_convert_encoding('Nombre del Proyecto de la Salida:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 10, mb_convert_encoding($filaAnexoIV['denominacionProyecto'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(53, 10, mb_convert_encoding('Lugar, día y hora de salida:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 10, mb_convert_encoding($salida, 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(56, 10, mb_convert_encoding('Lugar, día y hora de regreso:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 10, mb_convert_encoding($regreso, 'ISO-8859-1', 'UTF-8'), 0, 1);

    // $pdf->SetFont('Arial', '', 12);
    // $pdf->Cell(34, 10, mb_convert_encoding('Lugares de estadía (domicilios y teléfonos):', 'ISO-8859-1', 'UTF-8'), 0, 0);
    // $pdf->SetFont('Arial', '', 11);
    // $pdf->Cell(0, 10, mb_convert_encoding($hospedaje, 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    // $pdf->SetFont('Arial', '', 12);
    // $pdf->Cell(34, 10, mb_convert_encoding('Nombres y teléfonos de los acompañantes:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    // $pdf->SetFont('Arial', '', 11);
    // $pdf->Cell(0, 10, mb_convert_encoding($filaAnexoIV['regionVisita'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Empresa y/o empresas contratadas (nombre, dirección teléfonos): ', 'ISO-8859-1', 'UTF-8'), 0, 1 );
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding($filasPlantilla['empresas'], 'ISO-8859-1', 'UTF-8'), 0);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Otros datos de la Infraestructura disponible:', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding($filasPlantilla['datosInfraestructura'], 'ISO-8859-1', 'UTF-8'), 0);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Hospitales y centros asistenciales cercanos (direcciones y teléfonos):', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding($filasPlantilla['hospitalesCercanos'], 'ISO-8859-1', 'UTF-8'), 0);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Otros datos de interés:', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding($filasPlantilla['datosInteres'], 'ISO-8859-1', 'UTF-8'), 0);

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(34, 10, mb_convert_encoding('2- AUTORIZACIÓN (completa el madre/padre, tutor o responsable):', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', '', 12);
    $textoCompleto = "Por la presente autorizo a mi hijo/a " . ucwords(strtolower($nombreCompleto)). ", DNI: ". $dniAlumno . ", que concurre al Establecimiento Educativo ".$filaAnexoIV['institucionEducativa']." N°".$filaAnexoIV['numeroInstitucion']." del Distrito ".$filaAnexoIV['distrito']." a participar de la Salida Educativa / Salida de Representación Institucional a realizarse en la localidad de ".$filaAnexoIV['localidadVisita']." el/los dia/s ".$diaSalida." del mes de ".$mesSalida." del presente ciclo lectivo.";
    $pdf->MultiCell(0, 8, mb_convert_encoding($textoCompleto, 'ISO-8859-1', 'UTF-8'), 0);

    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding('3- SALUD (completa el padre/madre, tutor o responsable):', 'ISO-8859-1', 'UTF-8'), 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding('Dejo aquí constancia de cualquier indicación necesaria deba conocer el personal docente a cargo y personal médico:', 'ISO-8859-1', 'UTF-8'), 0);
    
    $pdf->Ln(10);
    
    $pdf->Cell(55, 30, mb_convert_encoding('Tiene Obra Social/Prepaga', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(10, 30, mb_convert_encoding('Sí', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(10, 30, mb_convert_encoding('No', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');

    $pdf->Cell(70, 15, 'Nombre de la Obra Social/Prepaga', 1, 0, 'C');
    $pdf->Cell(20, 15, '', 1, 1, 'L');  // Espacio para nombre
    $pdf->Cell(75, 15, mb_convert_encoding('', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(70, 15, 'N° Socio', 1, 0, 'C');
    $pdf->Cell(20, 15, '', 1, 1, 'L');  // Espacio para número de socio

    $pdf->Ln(10);

    $pdf->MultiCell(0, 8, mb_convert_encoding('Dejo constancia de que he sido informado de las características particulares de dicha salida, como así también de las/los responsables de las actividades a desarrollar, medios de transporte a utilizar y lugares donde se realizarán dichas actividades.', 'ISO-8859-1', 'UTF-8'), 0);
    $pdf->MultiCell(0, 8, mb_convert_encoding('Autorizo a las/los responsables de la salida a disponer cambios con relación a la planificación de las actividades en aspectos acotados, que resulten necesarios, a su solo criterio y sin aviso previo, sobre lo cual me deberán informar y fundamentar al regreso.', 'ISO-8859-1', 'UTF-8'), 0);
    $pdf->MultiCell(0, 8, mb_convert_encoding('Autorizo, en caso de necesidad y urgencia, a hacer atender al estudiante por profesionales médicos y a que se adopten las prescripciones que ellos indiquen, sobre lo cual requiero inmediato aviso.', 'ISO-8859-1', 'UTF-8'), 0);
    $pdf->MultiCell(0, 8, mb_convert_encoding('Los docentes a cargo del cuidado y vigilancia activa de las/los estudiantes con menos de 18 años de edad no serán responsables de los objetos u otros elementos de valor que los mismos puedan llevar.', 'ISO-8859-1', 'UTF-8'), 0);

    $pdf->Ln(5);

    $pdf->Cell(34, 10, mb_convert_encoding('Teléfonos de contacto en caso de urgencia: (Consignar varios)', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 5, mb_convert_encoding('Firma, aclaración y DNI (madre, padre o adulto responsable):', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(40);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Cell(95, 5, mb_convert_encoding('Firma', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('Aclaración', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Ln(15);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Cell(95, 5, mb_convert_encoding('DNI', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('Vinculo', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    
    $pdf->Ln(15); 

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell('0', 10, mb_convert_encoding('Fecha: ....../....../..........', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->Ln(5); 

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 5, mb_convert_encoding('Aclaración:', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 11);
    $textoAclaracion = 'El punto 1 debe ser completado por la Escuela antes de enviar este anexo a las familias. El presente anexo debe ser firmado por el adulto responsable y debe ser devuelto a la escuela (en papel, con firma original). Al momento de realizar la Salida Educativa el/la docente responsable debe portar el anexo VI de las y los estudiantes.';
    $pdf->MultiCell(0, 8, mb_convert_encoding($textoAclaracion, 'ISO-8859-1', 'UTF-8'), 0,);

    $pdf->Output('I', 'anexoVI.pdf');
?>
