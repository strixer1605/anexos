<?php
    require ('fpdf/fpdf.php'); // Asegúrate de que esta ruta sea correcta
    include ('../../php/verificarSessionPDF.php');

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
    $pdf->Image('../../imagenes/eest.png', 15, 8, 20); // Logo
    $pdf->Image('../../imagenes/logoprovincia.jpg', 112, 8, 90); // Logo

    // Ajusta el texto del encabezado usando mb_convert_encoding para convertir a ISO-8859-1
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 60, mb_convert_encoding('IF-2024-35029395-GDEBA-CGCYEDGCYE', 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
    $pdf->Ln(-20);  // Restamos 20 unidades al espaciado para acercar el texto "ANEXO IV"

    // Texto ANEXO IV
    $pdf->SetFont('Arial', '', 17);
    $pdf->Cell(0, 10, mb_convert_encoding('ANEXO IV', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    // Subtítulo
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(0, 10, mb_convert_encoding('Solicitud para la realización de:', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    // Tipo de solicitud
    if ($fila['tipoSolicitud'] == 1) {
        $pdf->Cell(0, 10, mb_convert_encoding('Salida Educativa / Salida de Representación Institucional', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    } else {
        $pdf->Cell(0, 10, mb_convert_encoding('Salida Educativa / Salida de Representación Institucional', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    }

    $pdf->Rect(8, 80, 195, 200); // Ajusta la posición y tamaño según tus necesidades

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(17, 10, mb_convert_encoding('Región:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 10, mb_convert_encoding($fila['region'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20, 10, mb_convert_encoding('Distrito:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 10, mb_convert_encoding($fila['distrito'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    // Continúa con el resto de la información dinámica
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(47, 10, mb_convert_encoding('Institución Educativa:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, mb_convert_encoding($fila['institucionEducativa'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(24, 10, mb_convert_encoding('Número: N°', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 10, mb_convert_encoding($fila['numeroInstitucion'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(22, 10, mb_convert_encoding('Domicilio:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 10, mb_convert_encoding($fila['domicilioInstitucion'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(59, 10, mb_convert_encoding('Denominacion del Proyecto:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(87, 10, mb_convert_encoding($fila['denominacionProyecto'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(21, 10, mb_convert_encoding('Teléfono:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, mb_convert_encoding($fila['telefonoInstitucion'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(59, 10, mb_convert_encoding('Lugar a visitar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(87, 10, mb_convert_encoding($fila['lugarVisita'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(59, 10, mb_convert_encoding('Dirección:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(87, 10, mb_convert_encoding($fila['direccionViaje'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(59, 10, mb_convert_encoding('Localidad:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(87, 10, mb_convert_encoding($fila['localidadViaje'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(59, 10, mb_convert_encoding('Región:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(87, 10, mb_convert_encoding($fila['regionViaje'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(20, 18, mb_convert_encoding('SALIDA', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 0, mb_convert_encoding('Fecha:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(30, 0, $fechaSalida, 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 0, mb_convert_encoding('Lugar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(86, 0, mb_convert_encoding($fila['lugarSalida'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(12, 0, mb_convert_encoding('Hora:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(30, 0, mb_convert_encoding($fila['horaSalida'], 'ISO-8859-1', 'UTF-8'), 0, 1);  // Agregar este campo para hora de salida
    
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(20, 10, mb_convert_encoding('REGRESO', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 10, mb_convert_encoding('Fecha:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(30, 10, $fechaRegreso, 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 10, mb_convert_encoding('Lugar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(86, 10, mb_convert_encoding($fila['lugarRegreso'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(12, 10, mb_convert_encoding('Hora:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(30, 10, mb_convert_encoding($fila['horaRegreso'], 'ISO-8859-1', 'UTF-8'), 0, 1); // Agregar este campo para hora de regreso

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20, 10, mb_convert_encoding('Itinerario:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(90, 10, mb_convert_encoding($fila['region'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(26, 10, mb_convert_encoding('Actividades:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(90, 10, mb_convert_encoding($fila['region'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(17, 10, mb_convert_encoding('Región:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 10, mb_convert_encoding($fila['region'], 'ISO-8859-1', 'UTF-8'), 0, 1);






    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(0, 10, mb_convert_encoding('Cantidad de alumnos: '.$cantidadAlumnos, 'ISO-8859-1', 'UTF-8'), 0, 1);
    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(0, 10, mb_convert_encoding('Cantidad de docentes acompañantes: '.$cantidadDocentes, 'ISO-8859-1', 'UTF-8'), 0, 1);
    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(0, 10, mb_convert_encoding('Cantidad de no docentes acompañantes: '.$cantidadAcompañantes, 'ISO-8859-1', 'UTF-8'), 0, 1);
    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(0, 10, mb_convert_encoding('Total de Personas: '.$totalPersonas, 'ISO-8859-1', 'UTF-8'), 0, 1);

    // // Profesores
    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(0, 10, mb_convert_encoding('Docentes:', 'ISO-8859-1', 'UTF-8'), 0, 1);
    // $pdf->SetFont('Arial', '', 12);
    // foreach ($nombresArray as $key => $nombre) {
    //     $pdf->Cell(0, 10, mb_convert_encoding($nombre, 'ISO-8859-1', 'UTF-8'), 0, 1);
    // }

    // $pdf->Cell(0, 10, utf8_decode('Datos del Hospedaje'), 0, 1, 'C');
    // $pdf->SetFont('Arial', '', 12);

    // // Hospedaje
    // $pdf->Cell(30, 10, 'Hospedaje:', 0, 0, 'L');
    // $pdf->Cell(70, 10, utf8_decode($fila['nombreHospedaje']), 0, 1, 'L');

    // // Teléfono
    // $pdf->Cell(30, 10, 'Teléfono:', 0, 0, 'L');
    // $pdf->Cell(70, 10, ($fila['telefonoHospedaje'] == 0) ? '-' : utf8_decode($fila['telefonoHospedaje']), 0, 1, 'L');

    // // Segunda fila: Domicilio y Localidad
    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(0, 10, '', 0, 1); // Espacio

    // $pdf->SetFont('Arial', '', 12);

    // // Domicilio
    // $pdf->Cell(30, 10, 'Domicilio:', 0, 0, 'L');
    // $pdf->Cell(70, 10, utf8_decode($fila['domicilioHospedaje']), 0, 1, 'L');

    // // Localidad
    // $pdf->Cell(30, 10, 'Localidad:', 0, 0, 'L');
    // $pdf->Cell(70, 10, utf8_decode($fila['localidadHospedaje']), 0, 1, 'L');

    // // Gastos estimativos
    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(0, 10, 'Gastos estimativos de la excursión:', 0, 1);
    // $pdf->SetFont('Arial', '', 12);
    // $pdf->MultiCell(0, 10, utf8_decode($fila['gastosEstimativos']), 0, 1);

    // // Firmas
    // $pdf->Ln(15); // Salto de línea

    // // Fila de firmas
    // $pdf->Cell(95, 10, '......................................................................', 0, 0, 'C');
    // $pdf->Cell(95, 10, '......................................................................', 0, 1, 'C');

    // $pdf->Cell(95, 10, utf8_decode('Lugar y fecha Firma de Autoridad del Establecimiento'), 0, 0, 'C');
    // $pdf->Cell(95, 10, utf8_decode('Lugar y fecha Firma del Inspector (si correspondiere)'), 0, 1, 'C');

    // // Segunda fila de firmas
    // $pdf->Ln(10);
    // $pdf->Cell(95, 10, '......................................................................', 0, 0, 'C');
    // $pdf->Cell(95, 10, '......................................................................', 0, 1, 'C');

    // $pdf->Cell(95, 10, utf8_decode('Lugar y fecha Firma del Inspector Jefe Distrital (si correspondiere)'), 0, 0, 'C');
    // $pdf->Cell(95, 10, utf8_decode('Lugar y fecha Firma del Inspector Jefe Regional (si correspondiere)'), 0, 1, 'C');

    // // Nota final
    // $pdf->Ln(20);
    // $pdf->SetFont('Arial', 'B', 10);
    // $pdf->MultiCell(0, 10, utf8_decode('1) El presente formulario deberá estar completo por duplicado (Uno para la institución otro para la instancia de Supervisión)'), 0, 'C');

    // Guardar PDF
    $pdf->Output('I', 'anexoIV.pdf');
?>
