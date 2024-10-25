<?php
    require ('fpdf/fpdf.php'); // Asegúrate de que esta ruta sea correcta
    include ('../../php/verificarSessionPDF.php');

    $dniAlumno = $_SESSION['dniAlumno'];

   // Preparar y ejecutar la consulta
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
    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $dniAlumno);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Obtener el resultado
    if ($fila = $resultado->fetch_assoc()) {
        $nombreCompleto = $fila['nombreCompleto'];
        $ano = $fila['ano'];
        $division = $fila['division'];

        // echo $nombreCompleto;
        // echo $ano;
        // echo $division;
    } else {
        echo "No se encontraron resultados.";
    }
    // Crear PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Encabezado
    $pdf->Image('../../imagenes/eest.png', 15, 8, 20); // Logo
    $pdf->Image('../../imagenes/logoprovincia.jpg', 112, 8, 90); // Logo

    // Ajusta el texto del encabezado usando mb_convert_encoding para convertir a ISO-8859-1
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 60, mb_convert_encoding('IF-2024-35029272-GDEBA-CGCYEDGCYE', 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
    $pdf->Ln(-20);  // Restamos 20 unidades al espaciado para acercar el texto "ANEXO IV"

    // Texto ANEXO IV
    $pdf->SetFont('Arial', 'B', 15  );  // Texto en negrita
    $pdf->Cell(0, 10, mb_convert_encoding('ANEXO III', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    // Obtener el ancho del texto para centrar el subrayado
    $text = 'ANEXO III';
    $text_width = $pdf->GetStringWidth(mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8'));

    // Posicionar la línea justo debajo del texto
    $x = ($pdf->GetPageWidth() - $text_width) / 2;  // Calcular la posición X para centrar
    $y = $pdf->GetY() - 2;  // Obtener la posición Y actual para dibujar la línea justo debajo

    // Dibujar la línea subrayada
    $pdf->Line($x, $y, $x + $text_width, $y);

    // Subtítulo
    $pdf->SetFont('Arial', 'B', 10);  // Texto en negrita

    // Centrar el primer bloque de texto y forzar salto en "LECTIVO"
    $pdf->MultiCell(0, 7, mb_convert_encoding('AUTORIZACIÓN GENERAL PARA ACTIVIDADES DURANTE EL CICLO LECTIVO', 'ISO-8859-1', 'UTF-8'), 0, 'C');

    // Añadir el siguiente bloque con salto en "ESTUDIANTES"
    $pdf->MultiCell(0, 7, mb_convert_encoding('SALIDA EDUCATIVA/ REPRESENTACIÓN INSTITUCIONAL PARA ESTUDIANTES', 'ISO-8859-1', 'UTF-8'), 0, 'C');

    // Añadir el último bloque
    $pdf->MultiCell(0, 7, mb_convert_encoding('CON MENOS DE 18 AÑOS DE EDAD', 'ISO-8859-1', 'UTF-8'), 0, 'C');

    $pdf->Ln(5);
    
    $pdf->SetFont('Arial', '', 12);

    // Inserta el primer texto centrado y justificado con una altura de 8 unidades
    $pdf->MultiCell(0, 8, mb_convert_encoding('Por la presente autorizo a '.$nombreCompleto.'.', 'ISO-8859-1', 'UTF-8'), 0, 'C');

    // Inserta el segundo texto con el mismo valor de altura para el mismo espacio
    $pdf->MultiCell(0, 8, mb_convert_encoding('DNI '.$dniAlumno.', estudiante de '.$ano.' Año, sección '.$division.' a participar', 'ISO-8859-1', 'UTF-8'), 0, 'C');

    // Inserta el tercer texto con el mismo espacio de línea
    $pdf->MultiCell(0, 8, mb_convert_encoding('de las Salidas Educativas o de Representación Institucional que se lleven a cabo en el', 'ISO-8859-1', 'UTF-8'), 0, 'C');

    $pdf->MultiCell(0, 8, mb_convert_encoding('barrio o área geográfica inmediata o próxima al establecimiento educativo, sin ', 'ISO-8859-1', 'UTF-8'), 0, 'C');

    $pdf->MultiCell(0, 8, mb_convert_encoding('necesidad de utilizar un medio de transporte, en el marco de la normativa vigente.', 'ISO-8859-1', 'UTF-8'), 0, 'C');
    
    $pdf->MultiCell(0, 8, mb_convert_encoding('La presente autorización es válida para actividades académicas, deportivas, culturales', 'ISO-8859-1', 'UTF-8'), 0, 'C');
    
    $pdf->MultiCell(0, 8, mb_convert_encoding('o comunitarias que se realicen durante el actual ciclo lectivo.', 'ISO-8859-1', 'UTF-8'), 0, 'C');

        

    // Obtener la fecha actual en el formato deseado
    $fechaActual = date('d/m/y');

    // Establecer la fuente
    $pdf->SetFont('Arial', '', 12);

    // Añadir un salto de línea para el espacio arriba de "Fecha"
    $pdf->Ln(10); // Ajusta el valor según el espacio deseado arriba de "Fecha"

    // Mover la posición X a la derecha
    $pdf->SetX(22);

    // Insertar el texto "Fecha" en el PDF con la fecha actual
    $pdf->MultiCell(0, 10, mb_convert_encoding('Fecha: '.$fechaActual, 'ISO-8859-1', 'UTF-8'), 0, 'L'); // Altura de la celda

    // Añadir un salto de línea con espacio después de la fecha
    $pdf->Ln(15); // Ajusta el valor según el espacio deseado debajo de "Fecha"

    // Insertar el texto "Firma, aclaración y DNI..." en el PDF
    $pdf->SetX(22); // Volver a establecer la posición X
    $pdf->MultiCell(0, 10, mb_convert_encoding('Firma, aclaración y DNI (madre, padre o adulto responsable):', 'ISO-8859-1', 'UTF-8'), 0, 'L'); // Altura de la celda

    // Añadir un salto de línea para el espacio debajo de la firma
    $pdf->Ln(15); // Ajusta el valor según el espacio deseado debajo de "Firma"

    
    $pdf->MultiCell(0, 8, mb_convert_encoding('Aclaración: El presente anexo se debe completar y firmar por única vez; tendrá', 'ISO-8859-1', 'UTF-8'), 0, 'C'); 
    
    $pdf->MultiCell(0, 8, mb_convert_encoding('validez para cada ocasión en la que se requiera durante el presente ciclo lectivo y será ', 'ISO-8859-1', 'UTF-8'), 0, 'C'); 
    
    $pdf->MultiCell(0, 8, mb_convert_encoding('archivado en el Legajo de cada Estudiante. ', 'ISO-8859-1', 'UTF-8'), 0, 'C'); 

    $pdf->MultiCell(0, 8, mb_convert_encoding('El mismo puede ser completado de forma digital, pero debe ser impreso y llevar la', 'ISO-8859-1', 'UTF-8'), 0, 'C'); 
    
    $pdf->MultiCell(0, 8, mb_convert_encoding('firma original del adulto responsable. ', 'ISO-8859-1', 'UTF-8'), 0, 'C'); 
    
    // Insertar la imagen a la izquierda
    $pdf->Image('../../imagenes/logoprovincia.jpg', 20, 250, 70); // Logo a la izquierda

    // Establecer la posición X a la derecha de la imagen
    $pdf->SetXY(110, 255); // Cambia 70 al valor deseado para el espacio a la derecha de la imagen

    // Insertar el texto en la misma posición Y que la imagen
    $pdf->MultiCell(0, 8, mb_convert_encoding('IF-2024-35029272-GDEBA-CGCYEDGCYE', 'ISO-8859-1', 'UTF-8'), 0, 'L'); 

    $pdf->Image('../../imagenes/selloEscuela.png', 80, 235, 40); // Logo a la izquierda
    
    // $pdf->AddPage();



        
    // Guardar PDF
    $pdf->Output('I', 'anexoIII.pdf');
?>
