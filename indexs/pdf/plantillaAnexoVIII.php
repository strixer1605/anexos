<?php
    require ('fpdf/fpdf.php');
    include ('../../php/verificarSessionPDF.php');

    $dniAlumno = $_SESSION['dniAlumno'];
    $idSalida = $_SESSION['idSalida'];

    $sqlAnexoVIII = "SELECT * FROM anexoviii WHERE idAnexoIV = $idSalida";
    
    $resultadoAnexoVIII = mysqli_query($conexion, $sqlAnexoVIII);
    $filaAnexoVIII = mysqli_fetch_assoc($resultadoAnexoVIII);

    $pdf = new FPDF();
    
    $pdf->SetMargins(20, 20, 20, 20);
    // Establecer margen inferior
    $pdf->SetAutoPageBreak(true, 20);
    
    $pdf->AddPage();

    // Encabezado
    $pdf->Image('../../imagenes/eest.png', 20, 8, 20);
    $pdf->Image('../../imagenes/logoprovincia.jpg', 102, 8, 90); // Logo

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 40, mb_convert_encoding('IF-2024-35031394-GDEBA-CGCYEDGCYE', 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
    
    $pdf->Ln(-10);

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0, 10, mb_convert_encoding('ANEXO VIII', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 12); 
    $pdf->MultiCell(0, 7, mb_convert_encoding('PLANILLA INFORME DE TRANSPORTE A CONTRATAR', 'ISO-8859-1', 'UTF-8'), 0, 'C');
    
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(66, 10, mb_convert_encoding('Nombre de la empresa o razón social:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(3);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(53, 10, mb_convert_encoding('Nombre del gerente o responsable:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(56, 10, mb_convert_encoding('Domicilio del propietario o la empresa:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('', 'ISO-8859-1', 'UTF-8'), 0, 1);

    // $pdf->Cell(5, 10, chr(149), 0, 0);
    // $pdf->Cell(0, 10, mb_convert_encoding('Domicilio del gerente o responsable: ' . $filaAnexoIV['nombreHospedaje'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    // while ($filaAnexoV = mysqli_fetch_assoc($resultadoAnexoV)) {
    //     $dniAcompanante = $filaAnexoV['dni'];
    //     $sqlTelefonos = "SELECT telefono FROM telefono WHERE dni = '$dniAcompanante'";
    //     $resultadoTelefonos = mysqli_query($conexion, $sqlTelefonos);
    
    //     // Almacena los teléfonos en un array
    //     $telefonos = [];
    //     while ($filaTelefono = mysqli_fetch_assoc($resultadoTelefonos)) {
    //         $telefonos[] = $filaTelefono['telefono'];
    //     }
    
    //     $telefonosConcatenados = implode(', ', $telefonos);

    //     if ($telefonosConcatenados == ''){
    //         $telefonosConcatenados = '-';
    //     }
    
    //     $pdf->Cell(5, 8, chr(149), 0, 0);  // Viñeta
    //     $pdf->Cell(0, 8, mb_convert_encoding(ucwords(strtolower($filaAnexoV['apellidoNombre'])).', Teléfono: '.$telefonosConcatenados, 'ISO-8859-1', 'UTF-8'), 0, 1);
    // }
    
    // $pdf->Ln(5);
    // $pdf->MultiCell(0, 10, mb_convert_encoding('Empresa y/o empresas contratadas (nombre, dirección teléfonos): assss sdasasdasd asdasd asdas'.$filasPlantilla['empresas'].'', 'ISO-8859-1', 'UTF-8'), 0);

    // $pdf->Ln(10);

    // $telefArray = explode(',', $filaAnexoVI['telefonos']);
    // $arrayValores = array_map('trim', $telefArray);
    
    // foreach ($arrayValores as $fila => $telefono) {
    //     $pdf->Cell(5, 8, chr(149), 0, 0);  // Viñeta
    //     $pdf->Cell(0, 8, mb_convert_encoding($telefono, 'ISO-8859-1', 'UTF-8'), 0, 1);
    // }
    
    $pdf->Ln(5); 
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding('El punto 1 debe ser completado por la Escuela antes de enviar este anexo a las familias.', 'ISO-8859-1', 'UTF-8'), 0,);
    $pdf->MultiCell(0, 8, mb_convert_encoding('El presente anexo debe ser firmado por el adulto responsable y debe ser devuelto a la escuela (en papel, con firma original).', 'ISO-8859-1', 'UTF-8'), 0,);
    $pdf->MultiCell(0, 8, mb_convert_encoding('Al momento de realizar la Salida Educativa el/la docente responsable debe portar el anexo VI de las y los estudiantes.', 'ISO-8859-1', 'UTF-8'), 0,);

    $pdf->Output('I', 'anexoVI.pdf');
?>
