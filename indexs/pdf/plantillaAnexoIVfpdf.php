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

    // $pdf->Rect(8, 80, 195, 200);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(17, 10, mb_convert_encoding('Región:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['region'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(18, 10, mb_convert_encoding('Distrito:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['distrito'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(45, 10, mb_convert_encoding('Institución Educativa:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(99, 10, mb_convert_encoding($fila['institucionEducativa'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(8, 10, mb_convert_encoding('N°:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 10, mb_convert_encoding($fila['numeroInstitucion'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(22, 10, mb_convert_encoding('Domicilio:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(122, 10, mb_convert_encoding($fila['domicilioInstitucion'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(21, 10, mb_convert_encoding('Teléfono:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['telefonoInstitucion'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(59, 10, mb_convert_encoding('Denominacion del Proyecto:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['denominacionProyecto'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(32, 10, mb_convert_encoding('Lugar a visitar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['lugarVisita'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, mb_convert_encoding('Dirección a visitar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['direccionVisita'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, mb_convert_encoding('Localidad a visitar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['localidadVisita'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(34, 10, mb_convert_encoding('Región a visitar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['regionVisita'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(20, 18, mb_convert_encoding('SALIDA', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 0, mb_convert_encoding('Fecha:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(25, 0, $fechaSalida, 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(12, 0, mb_convert_encoding('Hora:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 0, mb_convert_encoding($fila['horaSalida'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 0, mb_convert_encoding('Lugar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(86, 0, mb_convert_encoding($fila['lugarSalida'], 'ISO-8859-1', 'UTF-8'), 0, 0);
    
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(20, 10, mb_convert_encoding('REGRESO', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 10, mb_convert_encoding('Fecha:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(25, 10, $fechaRegreso, 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(12, 10, mb_convert_encoding('Hora:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 10, mb_convert_encoding($fila['horaRegreso'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(15, 10, mb_convert_encoding('Lugar:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 10, mb_convert_encoding($fila['lugarRegreso'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(15, 5, mb_convert_encoding('Observaciones respecto a las fechas (en caso de corresponder):', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(92, 15, mb_convert_encoding('Itinerario (detalle pormenorizado del mismo):', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 15, mb_convert_encoding($fila['itinerario'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Ln(50);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(27, 5, mb_convert_encoding('Actividades:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 5, mb_convert_encoding($fila['actividades'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Ln(30);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(47, 5, mb_convert_encoding('Objetivos de la salida:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 5, mb_convert_encoding($fila['objetivosSalida'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Ln(30);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(41, 5, mb_convert_encoding('Cronograma diario:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 5, mb_convert_encoding($fila['cronograma'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Ln(30);

    // Incluir el bloque de formulario
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Datos del/los docente/s responsables titulares', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(143, 8, mb_convert_encoding('Apellido y Nombre:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->Cell(0, 8, mb_convert_encoding('Cargo: Docente', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(5); // Espacio

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Datos del/los docente/s reemplazantes', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 10, mb_convert_encoding('Apellido y Nombre ___________________________________  Cargo ________________', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Cell(90, 10, mb_convert_encoding('Apellido y Nombre ___________________________________  Cargo ________________', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Cell(90, 10, mb_convert_encoding('Apellido y Nombre ___________________________________  Cargo ________________', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Cantidad de alumnos: '.$cantidadAlumnos, 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Cantidad de docentes acompañantes: '.$cantidadDocentes, 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Cantidad de no docentes acompañantes: '.$cantidadAcompañantes, 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Total de Personas: '.$totalPersonas, 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(5);
    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Sólo para salidas de más de 24 horas', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->Ln(2);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(25, 10, mb_convert_encoding('Hospedaje:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 10, mb_convert_encoding($fila['nombreHospedaje'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(21, 10, mb_convert_encoding('Teléfono:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    
    $value = ($fila['telefonoHospedaje'] == 0) ? '-' : $fila['telefonoHospedaje'];
    $pdf->Cell(0, 10, mb_convert_encoding($value, 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->Ln(5);    

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(22, 10, mb_convert_encoding('Domicilio:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(93, 10, mb_convert_encoding($fila['domicilioHospedaje'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(23, 10, mb_convert_encoding('Localidad:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['localidadHospedaje'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(10); // Espacio

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Gastos estimativos de la actividad y modo de solventarlos:', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(90, 5, mb_convert_encoding($fila['gastosEstimativos'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(10); // Espacio para completar con los datos manualmente

    // Lugar y fecha
    $pdf->Cell(0, 10, mb_convert_encoding('Lugar y fecha: ...................................................................................................', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Cell(0, 15, mb_convert_encoding('Nombre y Apellido de Autoridad del Establecimiento que completó este formulario:', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Cell(0, 10, mb_convert_encoding('.................................................................................................................', 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(10); // Espacio final antes de terminar

    $pdf->Output('I', 'anexoIV.pdf');
?>
