<?php
    require ('fpdf/fpdf.php');
    include ('../../php/verificarSessionPDF.php');

    $idSalida = $_SESSION['idSalida'];

    $sqlInfoAIV = "SELECT * FROM anexoiv WHERE idAnexoIV";
    $resultado = mysqli_query($conexion, $sqlInfoAIV);
    $fila = mysqli_fetch_assoc($resultado);

    $sqlIntegrantes = "SELECT * FROM anexov WHERE cargo != 5";
    $resultadoIntegrantes = mysqli_query($conexion, $sqlIntegrantes);

    $fechaSalida = date('d/m/Y', strtotime($fila['fechaSalida']));

    $pdf = new FPDF();
    $pdf->SetMargins(20, 20, 20);
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->AddPage();

    // Encabezado
    $pdf->Image('../../imagenes/eest.png', 20, 15, 20); // Logo
    $pdf->Image('../../imagenes/logoprovincia.jpg', 102, 15, 90); // Logo

    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(5);

    $pdf->Cell(0, 30, mb_convert_encoding('IF-2024-35029666-GDEBA-CGCYEDGCYE', 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0, 10, mb_convert_encoding('ANEXO V', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Ln(2);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, mb_convert_encoding('Planilla de estudiantes y acompañantes', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell(0, 10, mb_convert_encoding('Planilla de asistencia', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 5, mb_convert_encoding('(La presente deberá incorporarse al libro de Registro de Actas Institucionales, antes de producirse la salida).', 'ISO-8859-1', 'UTF-8'), 0);
    $pdf->Ln(5);
    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(45, 10, mb_convert_encoding('Institución Educativa:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(87, 10, mb_convert_encoding($fila['institucionEducativa'], 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(8, 10, mb_convert_encoding('N°:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['numeroInstitucion'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(18, 10, mb_convert_encoding('Distrito:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['distrito'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(32, 10, mb_convert_encoding('Lugar a visitar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(100, 10, mb_convert_encoding($fila['lugarVisita'], 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 10, mb_convert_encoding('Fecha:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(25, 10, $fechaSalida, 0, 0);

    $pdf->SetMargins(5, 15, 0);

    $pdf->Ln(15);
    $header = array('N°', 'Apellido y Nombre', 'DNI', 'Edad', 'Estudiante', 'Docente', 'No docente', 'Asistencia (P/A)');
    $widths = array(8, 73, 18, 12, 21, 16, 22, 30);

    $pdf->SetFont('Arial', 'B', 10);
    foreach ($header as $key => $column) {
        $pdf->Cell($widths[$key], 10, mb_convert_encoding($column, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    }
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $data = array();

    $counter = 1;
    while ($registro = mysqli_fetch_assoc($resultadoIntegrantes)) {
        switch($registro['cargo']){
            case 0:
                $alumnoX = "Indefinido";
                $docenteX = "Indefinido";
                $noDOcenteX = "Indefinido";
            break;
            case 2:
                $alumnoX = '';
                $docenteX = 'X';
                $noDOcenteX = '';
            break;
            case 3:
                $alumnoX = 'X';
                $docenteX = '';
                $noDOcenteX = '';
            break;
            case 4:
                $alumnoX = '';
                $docenteX = '';
                $noDOcenteX = 'X';
            break;
        }
        $data[] = array(
            $counter,
            ucwords(strtolower($registro['apellidoNombre'])),
            $registro['dni'],
            $registro['edad'],
            $alumnoX,
            $docenteX,
            $noDOcenteX,
            ''
        );
        $counter++;
    }

    foreach ($data as $row) {
        foreach ($row as $key => $column) {
            $pdf->Cell($widths[$key], 10, mb_convert_encoding($column, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        }
        $pdf->Ln();
    }

    $pdf->SetMargins(20, 20, 20);

    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding('Observaciones (para ser completado ante cualquier eventualidad):', 'ISO-8859-1', 'UTF-8'));

    $pdf->Ln(50);
    
    $pdf->Cell(0, 5, mb_convert_encoding('La presente planilla tendrá validez para toda tramitación oficial que se realice.', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(60);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(82, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Cell(82, 5, mb_convert_encoding('Lugar y fecha', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('Lugar y fecha', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Ln(2);

    $pdf->Cell(82, 5, mb_convert_encoding('Firma y alcaración de la Autoridad del Establecimiento', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('Firma del Inspector:', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell(82, 5, mb_convert_encoding('que completó este formulario:', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Ln(20);

    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding('El presente formulario deberá estar completo por duplicado (Uno para la Institución y otro para la instancia de Supervisión).', 'ISO-8859-1', 'UTF-8'));
    $pdf->MultiCell(0, 8, mb_convert_encoding('El presente formulario puede ser completado de forma digital y enviado al/la Inspector/a en este formato.', 'ISO-8859-1', 'UTF-8'));
    $pdf->MultiCell(0, 8, mb_convert_encoding('El mismo debe ser impreso y firmado para la Salida Educativa, registrando ese mismo día las asistencias o inasistencias, tanto de estudiantes como de docentes o acompañantes no docentes, así como cualquier modificación de último momento (docentes reemplazantes, etc.).', 'ISO-8859-1', 'UTF-8'));

    $pdf->Output('I', 'anexoV.pdf');
?>
