<?php
    require 'fpdf/fpdf.php'; // Asegúrate de que esta ruta sea correcta
    include '../../php/verificarSessionPDF.php';

    $idSalida = $_SESSION['idSalida'];

    // Consulta para obtener los datos
    $sql = "SELECT 
            aiv.*, 
            GROUP_CONCAT(av.apellidoNombre SEPARATOR ',\n') AS nombresConcatenados 
            FROM anexoiv aiv 
            LEFT JOIN anexov av ON av.fkAnexoIV = aiv.idAnexoIV AND av.cargo = 2 
            WHERE aiv.idAnexoIV = $idSalida 
            GROUP BY aiv.idAnexoIV";

    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);

    $nombresConcatenados = $fila['nombresConcatenados'];
    $nombresArray = explode("\n", $nombresConcatenados);
    $cargos = array_fill(0, count($nombresArray), 'Profesor');

    // Formatear fechas de regreso y salida de YY-MM-DD a DD-MM-YY
    $fechaSalida = date('d/m/Y', strtotime($fila['fechaSalida']));
    $fechaRegreso = date('d/m/Y', strtotime($fila['fechaRegreso']));

    // Contar cantidad de personas
    $sqlContarPersonas = "SELECT cargo, COUNT(*) as cantidad FROM anexov WHERE fkAnexoIV = $idSalida GROUP BY cargo";
    $resultadoContar = mysqli_query($conexion, $sqlContarPersonas);

    $cantidadAlumnos = 0;
    $cantidadDocentes = 0;
    $cantidadAcompañantes = 0;

    while ($row = mysqli_fetch_assoc($resultadoContar)) {
        switch ($row['cargo']) {
            case 2: $cantidadDocentes = $row['cantidad']; break;
            case 3: $cantidadAlumnos = $row['cantidad']; break;
            case 4: $cantidadAcompañantes = $row['cantidad']; break;
        }
    }

    $totalPersonas = $cantidadAlumnos + $cantidadDocentes + $cantidadAcompañantes;

    // Crear PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Encabezado
    $pdf->Image('../../imagenes/eest.png', 8, 8, 20); // Logo
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'ANEXO IV', 0, 1, 'C');

    // Subtítulo
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Solicitud para la realizacion de:', 0, 1, 'C');

    // Tipo de solicitud
    if ($fila['tipoSolicitud'] == 1) {
        $pdf->Cell(0, 10, 'Salida Educativa / Salida de Representacion Institucional', 0, 1, 'C');
    } else {
        $pdf->Cell(0, 10, 'Salida Educativa / Salida de Representacion Institucional', 0, 1, 'C');
    }

    // Información principal
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Region:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fila['region'], 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Distrito:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fila['distrito'], 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Institucion Educativa:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fila['institucionEducativa'], 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Numero:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fila['numeroInstitucion'], 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Domicilio:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fila['domicilioInstitucion'], 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Telefono:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fila['telefonoInstitucion'], 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(50, 10, 'Denominacion del Proyecto:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fila['denominacionProyecto'], 0, 1);

    // Lugar y fechas de salida y regreso
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Lugar a Visitar:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fila['lugarVisita'], 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Fecha de Salida:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fechaSalida, 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Lugar de Salida:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fila['lugarSalida'], 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Fecha de Regreso:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $fechaRegreso, 0, 1);

    // Información adicional
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Docentes a Cargo:', 0, 1);
    foreach ($nombresArray as $index => $nombre) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(60, 10, "$nombre - {$cargos[$index]}", 0, 1);
    }

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Cantidad de Alumnos:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $cantidadAlumnos, 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Cantidad de Docentes:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $cantidadDocentes, 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Cantidad de Acompanantes:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $cantidadAcompañantes, 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Total de Personas:', 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 10, $totalPersonas, 0, 1);

    $pdf->Cell(0, 10, utf8_decode('Datos del Hospedaje'), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);

    // Hospedaje
    $pdf->Cell(30, 10, 'Hospedaje:', 0, 0, 'L');
    $pdf->Cell(70, 10, utf8_decode($fila['nombreHospedaje']), 0, 1, 'L');

    // Teléfono
    $pdf->Cell(30, 10, 'Teléfono:', 0, 0, 'L');
    $pdf->Cell(70, 10, ($fila['telefonoHospedaje'] == 0) ? '-' : utf8_decode($fila['telefonoHospedaje']), 0, 1, 'L');

    // Segunda fila: Domicilio y Localidad
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, '', 0, 1); // Espacio

    $pdf->SetFont('Arial', '', 12);

    // Domicilio
    $pdf->Cell(30, 10, 'Domicilio:', 0, 0, 'L');
    $pdf->Cell(70, 10, utf8_decode($fila['domicilioHospedaje']), 0, 1, 'L');

    // Localidad
    $pdf->Cell(30, 10, 'Localidad:', 0, 0, 'L');
    $pdf->Cell(70, 10, utf8_decode($fila['localidadHospedaje']), 0, 1, 'L');

    // Gastos estimativos
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Gastos estimativos de la excursión:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, utf8_decode($fila['gastosEstimativos']), 0, 1);

    // Firmas
    $pdf->Ln(15); // Salto de línea

    // Fila de firmas
    $pdf->Cell(95, 10, '......................................................................', 0, 0, 'C');
    $pdf->Cell(95, 10, '......................................................................', 0, 1, 'C');

    $pdf->Cell(95, 10, utf8_decode('Lugar y fecha Firma de Autoridad del Establecimiento'), 0, 0, 'C');
    $pdf->Cell(95, 10, utf8_decode('Lugar y fecha Firma del Inspector (si correspondiere)'), 0, 1, 'C');

    // Segunda fila de firmas
    $pdf->Ln(10);
    $pdf->Cell(95, 10, '......................................................................', 0, 0, 'C');
    $pdf->Cell(95, 10, '......................................................................', 0, 1, 'C');

    $pdf->Cell(95, 10, utf8_decode('Lugar y fecha Firma del Inspector Jefe Distrital (si correspondiere)'), 0, 0, 'C');
    $pdf->Cell(95, 10, utf8_decode('Lugar y fecha Firma del Inspector Jefe Regional (si correspondiere)'), 0, 1, 'C');

    // Nota final
    $pdf->Ln(20);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(0, 10, utf8_decode('1) El presente formulario deberá estar completo por duplicado (Uno para la institución otro para la instancia de Supervisión)'), 0, 'C');

    // Salida del archivo
    // $pdf->Output('D', 'anexoIV.pdf');
    $pdf->Output('I');
?>
