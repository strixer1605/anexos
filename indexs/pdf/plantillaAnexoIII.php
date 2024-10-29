<?php
    require ('fpdf/fpdf.php');
    include ('../../php/verificarSessionPDF.php');

    $dniAlumno = $_SESSION['dniAlumno'];

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
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $nombreCompleto = $fila['nombreCompleto'];
        $ano = $fila['ano'];
        $division = $fila['division'];
    } else {
        echo "No se encontraron resultados.";
    }

    // Crear PDF
    $pdf = new FPDF();
    
    // Establecer márgenes: izquierdo, superior y derecho a 20 mm
    $pdf->SetMargins(15, 15, 15);
    // Establecer margen inferior
    $pdf->SetAutoPageBreak(true, 20);
    
    $pdf->AddPage();

    // Encabezado
    $pdf->Image('../../imagenes/eest.png', 15, 8, 20);
    $pdf->Image('../../imagenes/logoprovincia.jpg', 107, 8, 90); // Logo

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 40, mb_convert_encoding('IF-2024-35029272-GDEBA-CGCYEDGCYE', 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
    
    $pdf->Ln(-10);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0, 10, mb_convert_encoding('ANEXO III', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10); 
    $pdf->MultiCell(0, 7, mb_convert_encoding('AUTORIZACIÓN GENERAL PARA ACTIVIDADES DURANTE EL CICLO LECTIVO', 'ISO-8859-1', 'UTF-8'), 0, 'C');
    $pdf->MultiCell(0, 7, mb_convert_encoding('SALIDA EDUCATIVA / REPRESENTACIÓN INSTITUCIONAL PARA ESTUDIANTES', 'ISO-8859-1', 'UTF-8'), 0, 'C');
    $pdf->MultiCell(0, 7, mb_convert_encoding('CON MENOS DE 18 AÑOS DE EDAD', 'ISO-8859-1', 'UTF-8'), 0, 'C');

    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);
    $textoCompleto = 'Por la presente autorizo a ' . ucwords(strtolower($nombreCompleto)). ", DNI: " . $dniAlumno . ", estudiante de " . $ano . "to año, sección " . $division . " a participar de las Salidas Educativas o de Representación Institucional que se lleven a cabo en el barrio o área geográfica inmediata o próxima al establecimiento educativo, sin  necesidad de utilizar un medio de transporte, en el marco de la normativa vigente.";

    $pdf->MultiCell(0, 8, mb_convert_encoding($textoCompleto, 'ISO-8859-1', 'UTF-8'), 0);
    
    $pdf->Ln(5);

    $pdf->MultiCell(0, 8, mb_convert_encoding('La presente autorización es válida para actividades académicas, deportivas, culturales o comunitarias que se realicen durante el actual ciclo lectivo.', 'ISO-8859-1', 'UTF-8'), 0);

    $fechaActual = date('d/m/y');
    $pdf->SetFont('Arial', '', 12);
    
    $pdf->Ln(5);

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

    $pdf->SetFont('Arial', '', 11);
    $textoAclaracion = 'Aclaración: El presente anexo se debe completar y firmar por única vez; tendrá validez para cada ocasión en la que se requiera durante el presente ciclo lectivo y será archivado en el Legajo de cada Estudiante.';
    $pdf->MultiCell(0, 8, mb_convert_encoding($textoAclaracion, 'ISO-8859-1', 'UTF-8'), 0,);
    
    $pdf->Ln(2);
    $pdf->MultiCell(0, 8, mb_convert_encoding('El mismo puede ser completado de forma digital, pero debe ser impreso y llevar la firma original del adulto responsable.', 'ISO-8859-1', 'UTF-8'), 0,);

    $pdf->Output('I', 'anexoIII.pdf');
?>
