<?php 
require('fpdf/fpdf.php');
include('../../php/verificarSessionPDF.php');

    $pdf = new FPDF();
    $pdf->SetMargins(20, 20, 20, 20);
    // Establecer margen inferior
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->AddPage();
        
    //datos
    $nombreDirector = ucwords(strtolower($_SESSION['nombreDir'] . ' ' . $_SESSION['apellidoDir']));
    $idSalida = $_SESSION['idSalida'];
    $sql = "SELECT 
        tipoSolicitud, 
        denominacionProyecto, 
        DATE_FORMAT(fechaSalida, '%d/%m/%Y') AS fechaSalida, 
        lugarVisita,
        direccionVisita, 
        localidadVisita 
    FROM 
        anexoiv 
    WHERE 
        idAnexoIV =  $idSalida;
    "
    ;

    $result = $conexion->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtener la fila de resultados
        $rowAnexoIX = $result->fetch_assoc();

        // Concatenar los valores en el formato solicitado
        $textoAnexoIX = $rowAnexoIX['fechaSalida'] . ' ' . $rowAnexoIX['lugarVisita'] . ', ' . $rowAnexoIX['localidadVisita'] . ', ' . $rowAnexoIX['direccionVisita'];

    } else {
        echo "No se encontraron resultados para el id proporcionado.";
    }

    // Consulta para obtener los datos principales
    $sql = "SELECT 
            aiv.*, 
            GROUP_CONCAT(av.apellidoNombre SEPARATOR ',\n') AS nombresConcatenados 
            FROM anexoiv aiv 
            LEFT JOIN anexov av ON av.fkAnexoIV = aiv.idAnexoIV AND av.cargo = 2 
            WHERE aiv.idAnexoIV = $idSalida 
            GROUP BY aiv.idAnexoIV";

    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);

    // Obtener nombres de docentes titulares y suplentes por separado
    $sqlTitulares = "SELECT apellidoNombre FROM anexov WHERE fkAnexoIV = $idSalida AND cargo = 2";
    $resultadoTitulares = mysqli_query($conexion, $sqlTitulares);

    $sqlSuplentes = "SELECT apellidoNombre FROM anexov WHERE fkAnexoIV = $idSalida AND cargo = 5";
    $resultadoSuplentes = mysqli_query($conexion, $sqlSuplentes);

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

    $sqlInfoAIV = "SELECT * FROM anexoiv WHERE idAnexoIV";
    $resultado = mysqli_query($conexion, $sqlInfoAIV);
    $fila = mysqli_fetch_assoc($resultado);

    $sqlIntegrantes = "SELECT * FROM anexov WHERE cargo != 5";
    $resultadoIntegrantes = mysqli_query($conexion, $sqlIntegrantes);

    $fechaSalida = date('d/m/Y', strtotime($fila['fechaSalida']));


    // Crear PDF
    $pdf = new FPDF();
    $pdf->SetMargins(15, 15, 15);
    // Establecer margen inferior
    $pdf->SetAutoPageBreak(true, 20);
    
    $pdf->AddPage();

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Anexo  IV///////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////


    // Encabezado
    $pdf->Image('../../imagenes/eest.png', 20, 8, 20);
    $pdf->Image('../../imagenes/logoprovincia.jpg', 102, 8, 90);

    // Ajusta el texto del encabezado usando mb_convert_encoding para convertir a ISO-8859-1
    $pdf->SetFont('Arial', '', 12);
    
    $pdf->Ln(5);

    $pdf->Cell(0, 30, mb_convert_encoding('IF-2024-35029395-GDEBA-CGCYEDGCYE', 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');


    // Texto ANEXO IV
    $pdf->SetFont('Arial', '', 17);
    $pdf->Cell(0, 10, mb_convert_encoding('ANEXO IV', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    // Subtítulo
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(0, 10, mb_convert_encoding('Presentación y solicitud para la realización de:', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $texto = 'Salida Educativa / Salida de Representación Institucional';
    if ($fila['tipoSolicitud'] == 1) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $pdf->SetLineWidth(0.4); // Ancho de la línea
        // Tachar el texto
        $pdf->Line(82, 75 , 46, 75);
    } else {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $pdf->SetLineWidth(0.4); // Ancho de la línea
        // Tachar el texto
        $pdf->Line(163, 75 , 84, 75);
    }

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
    $pdf->Cell(88, 10, mb_convert_encoding($fila['institucionEducativa'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(8, 10, mb_convert_encoding('N°:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, mb_convert_encoding($fila['numeroInstitucion'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(22, 10, mb_convert_encoding('Domicilio:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(111, 10, mb_convert_encoding($fila['domicilioInstitucion'], 'ISO-8859-1', 'UTF-8'), 0, 0);

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
    
    // Cambiar esta sección del código
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 15, mb_convert_encoding('Itinerario (detalle pormenorizado del mismo):', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->Ln(12);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, mb_convert_encoding($fila['itinerario'], 'ISO-8859-1', 'UTF-8'));
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 15, mb_convert_encoding('Actividades:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(12);
    $pdf->MultiCell(0, 8, mb_convert_encoding($fila['actividades'], 'ISO-8859-1', 'UTF-8'));
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 15, mb_convert_encoding('Objetivos de la salida:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(12);
    $pdf->MultiCell(0, 8, mb_convert_encoding($fila['objetivosSalida'], 'ISO-8859-1', 'UTF-8'));
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 15, mb_convert_encoding('Cronograma diario:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(12);
    $pdf->MultiCell(0, 8, mb_convert_encoding($fila['cronograma'], 'ISO-8859-1', 'UTF-8'));
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Datos del/los docente/s responsables titulares', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    
    while ($row = mysqli_fetch_assoc($resultadoTitulares)) {
        $nombre = ucwords(strtolower($row['apellidoNombre']));
        $pdf->Cell(130, 8, mb_convert_encoding("Apellido y Nombre: $nombre", 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 8, mb_convert_encoding('Cargo: Docente titular', 'ISO-8859-1', 'UTF-8'), 0, 1);
    }

    // Datos de los docentes suplentes
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, mb_convert_encoding('Datos del/los docente/s reemplazantes', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 12);

    while ($row = mysqli_fetch_assoc($resultadoSuplentes)) {
        $nombre = ucwords(strtolower($row['apellidoNombre']));
        $pdf->Cell(130, 8, mb_convert_encoding("Apellido y Nombre: $nombre", 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 8, mb_convert_encoding('Cargo: Docente suplente', 'ISO-8859-1', 'UTF-8'), 0, 1);
    }

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

    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 15, mb_convert_encoding('Gastos estimativos de la actividad y modo de solventarlos:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(12);
    $pdf->MultiCell(0, 8, mb_convert_encoding($fila['gastosEstimativos'], 'ISO-8859-1', 'UTF-8'));

    $pdf->Ln(40);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Cell(95, 5, mb_convert_encoding('Lugar y fecha', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('Lugar y fecha', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Ln(5);

    $pdf->Cell(95, 5, mb_convert_encoding('Firma y alcaración de la Autoridad del Establecimiento', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('Firma del Inspector (si correspondiere):', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Cell(95, 5, mb_convert_encoding('que completó este formulario:', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Ln(50);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('.......................................................................', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Cell(95, 5, mb_convert_encoding('Lugar y fecha', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('Lugar y fecha', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Ln(5);

    $pdf->Cell(95, 5, mb_convert_encoding('Firma del Jefe Distrital (si correspondiere):', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell(95, 5, mb_convert_encoding('Firma del Jefe Distrital (si correspondiere):', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    
    $pdf->Ln(50);

    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 5, mb_convert_encoding('El presente formulario debe ser completado de forma digital por un integrante del Equipo Directivo,', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell(0, 5, mb_convert_encoding('y enviado al/la Inspector/a en este formato.', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
   
    $pdf->Ln(5);

    $pdf->Cell(0, 5, mb_convert_encoding('El presente formulario deberá estar completo por duplicado', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell(0, 5, mb_convert_encoding('(Uno para la institución otro la para la instancia de Supervisión)', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Anexo  V///////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////

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

    $pdf->Ln(10);
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Anexo  IX///////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    $pdf->AddPage();
    $pdf->Image('../../imagenes/eest.png', 20, 8, 20);
    $pdf->Image('../../imagenes/logoprovincia.jpg', 102, 8, 90);

    // Arial bold 12
    $pdf->SetFont('Arial', 'B', 12);
    // Título
    $pdf->Cell(0, 50, mb_convert_encoding('ANEXO IX', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Line(95, 47, 115, 47);
    
    // Subtítulo
    // $pdf->Ln(5); // Añadir un poco de espacio debajo del título principal
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, -10, mb_convert_encoding('SALIDAS EDUCATIVAS / DE REPRESENTACIÓN INSTITUCIONAL', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell(0, -10, mb_convert_encoding('DECLARACIÓN JURADA DE DIRECTIVOS Y/O REPRESENTANTES LEGALES', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    // Espacio adicional debajo del encabezado
    $pdf->Ln(20);

    // Información del Establecimiento
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(60, 7, mb_convert_encoding('NOMBRE DEL ESTABLECIMIENTO:', 'ISO-8859-1', 'UTF-8'), 0, 0); // Mantener en la misma línea con ancho fijo
    
    // Configuración para el nombre de la escuela
    $nombreEscuela = 'Escuela de Educación Raul Scalabrini Ortiz';
    $pdf->MultiCell(0, 7, mb_convert_encoding($nombreEscuela, 'ISO-8859-1', 'UTF-8'), 0, 1); // Usar MultiCell para ajuste automático

    $pdf->Cell(5, 7, mb_convert_encoding('Nº', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->Cell(70, 7, '1', 0, 0);
    $pdf->Cell(10, 7, mb_convert_encoding('CUE:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $cue = '061806600';
    $pdf->Cell(0, 7, $cue, 0, 1);

    $pdf->Cell(20, 7, mb_convert_encoding('DOMICILIO:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $domicilioInstitucion = "calle 124 N°345";
    $pdf->Cell(60, 7, mb_convert_encoding($domicilioInstitucion, 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->Cell(20, 7, mb_convert_encoding('DISTRITO:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $distrito = 'La Costa';
    $pdf->Cell(0, 7, mb_convert_encoding($distrito, 'ISO-8859-1', 'UTF-8'), 0, 1);

    // Director/a del establecimiento
    $pdf->Cell(68, 7, mb_convert_encoding('DIRECTOR/A DEL ESTABLECIMIENTO:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->MultiCell(0, 7, mb_convert_encoding($nombreDirector, 'ISO-8859-1', 'UTF-8'), 0, 1);

    // Representante legal (DIEGEP)
    $pdf->Cell(62, 7, mb_convert_encoding('REPRESENTANTE LEGAL (DIEGEP)', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->Cell(0, 7, '___________________________________________', 0, 1);

    // Entidad propietaria (DIEGEP)
    $pdf->Cell(60, 7, mb_convert_encoding('ENTIDAD PROPIETARIA (DIEGEP)', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->Cell(0, 7, '___________________________________________', 0, 1);

    // Fecha y lugar de realización
    if ($rowAnexoIX == 1) {
        $pdf->Line(93, 115, 125, 115);
    } else {
        $pdf->Line(23, 120, 100, 120);
    }
    $pdf->Cell(100, 7, mb_convert_encoding('FECHA Y LUGAR DE REALIZACIÓN DE LA SALIDA EDUCATIVA /', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Cell(1, 2, mb_convert_encoding('SALIDA DE REPRESENTACIÓN INSTITUCIONAL', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->Cell(1, 13, mb_convert_encoding($rowAnexoIX['denominacionProyecto'], 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->MultiCell(0, 22, mb_convert_encoding($textoAnexoIX, 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 7, mb_convert_encoding('DATOS DEL SEGURO ESCOLAR:', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->SetFont('Arial', '', 10);
    // Compañía aseguradora
    $pdf->Cell(50, 7, mb_convert_encoding('COMPAÑÍA ASEGURADORA:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->MultiCell(0, 7, mb_convert_encoding('SANCOR SEGUROS', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    // Tipo de seguro
    $pdf->Cell(38, 7, mb_convert_encoding('TIPO DE SEGURO (1)', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(0, 7, mb_convert_encoding('ESCOLAR', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->SetFont('Arial', '', 10);
    
    // Campos adicionales: PÓLIZA N°, VIGENCIA, OBSERVACIONES (2)
    $pdf->Cell(20, 7, mb_convert_encoding('PÓLIZA N°', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 7, '11966714', 0, 1);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(20, 7, mb_convert_encoding('VIGENCIA', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $anioActual = date("Y");
    
    $pdf->Cell(0, 7, $anioActual, 0, 1);
    
    $pdf->Cell(50, 7, mb_convert_encoding('COMPAÑÍA ASEGURADORA:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->MultiCell(0, 7, mb_convert_encoding('PROVINCIA SEGUROS', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->Cell(0, 7, mb_convert_encoding('TIPO DE SEGURO (1) RESPONSABILIDAD CIVIL PARA ALUMNOS MENORES:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    
    $pdf->Ln(5);
    
    $pdf->Cell(20, 7, mb_convert_encoding('PÓLIZA N°:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(0, 7, mb_convert_encoding('121966', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(20, 7, mb_convert_encoding('VIGENCIA', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $anioActual = date("Y");
    
    $pdf->Cell(0, 7, $anioActual, 0, 1);
    
    $pdf->Cell(50, 7, mb_convert_encoding('COMPAÑÍA ASEGURADORA:', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->MultiCell(0, 7, mb_convert_encoding('PROVINCIA SEGUROS', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->Cell(37, 7, mb_convert_encoding('TIPO DE SEGURO (1)', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(0, 7, mb_convert_encoding('RESPONSABILIDAD CIVIL PARA MAYORES DE 18 AÑOS', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->SetFont('Arial', '', 10);
    
    $pdf->Cell(20, 4, mb_convert_encoding('___________________________', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->Ln(5);
    $pdf->Cell(20, 7, mb_convert_encoding('PÓLIZA N°', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 7, mb_convert_encoding('121713', 'ISO-8859-1', 'UTF-8'), 0, 0);
    
    $pdf->Ln(5);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(20, 7, mb_convert_encoding('VIGENCIA', 'ISO-8859-1', 'UTF-8'), 0, 0);
    $anioActual = date("Y");
    
    $pdf->Cell(0, 7, $anioActual, 0, 1);
    $pdf->Cell(0, 10, mb_convert_encoding('OBSERVACIONES (2):', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Cell(0, 20, mb_convert_encoding('___________________________________________________________________________________', 'ISO-8859-1', 'UTF-8'), 0, 1);

    // Declaración jurada
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 11);
    $declaracion = "En nuestro carácter de Director/a y/o Representante Legal del establecimiento educativo de referencia declaramos bajo juramento haber dado cumplimiento a los requerimientos del Anexo II de la Resolución de Salidas Educativas/ de Representación Institucional referidos a: Lugar de realización de la Salida Educativa y Salida de Representación Institucional, transporte, autorizaciones de madre, padre, tutor o responsable de los/as estudiantes con menos de 18 años de edad y Declaración Jurada de las/los estudiantes mayores de 18 años; garantizando el cumplimiento de la relación docente/estudiante y la información a los responsables legales de la Salida Educativa / Salida de Representación Institucional que realizará la institución educativa en el marco de su Proyecto Institucional. \nPonemos asimismo a disposición de la autoridad educativa que lo requiera los Anexos III, IV, V, VI, VII, VIII y IX completos (según corresponda, conforme lo estipulado en el Anexo II), como así también el libro de Actas Institucionales.";
    $pdf->MultiCell(0, 7, mb_convert_encoding($declaracion, 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->Ln(5);
    
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 7, mb_convert_encoding('Aclaración:', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->SetFont('Arial', '', 11);
    $declaracion = "El presente formulario debe ser completado por el/la directora/a. Y en el caso de las Escuelas Públicas de Gestión Privada, también por el/la Representante Legal. Este Anexo debe ser transcripto en puño y letra en el Libro de Actas Institucional de Salidas Educativas, con firma original. Para ser enviado al/la Inspector/a y al Seguro Escolar puede hacerse con el formato digital o bien sacarle una foto a la transcripción realizada en el Libro de Actas y enviar en formato PDF.";
    $pdf->MultiCell(0, 7, mb_convert_encoding($declaracion, 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Ln(15);
    
    $pdf->Cell(0, 10, mb_convert_encoding('1) Deberá constar en la póliza que el tipo de seguro es de responsabilidad civil.', 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->MultiCell(0, 7, mb_convert_encoding('2) En este rubro se dejará constancia de todas las situaciones que puedan surgir y no estén previstas en el presente formulario.', 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $pdf->Cell(0, 40, mb_convert_encoding('Lugar y fecha:..........................................................................................', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    
    $pdf->Ln(20);

    // Ancho de la mitad de la página
    $halfPageWidth = $pdf->GetPageWidth() / 2 - 20; // Resta márgenes si los hay

    // Línea de "FIRMA Y SELLO"
    $pdf->Cell($halfPageWidth, 5, mb_convert_encoding('FIRMA Y SELLO', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell($halfPageWidth, 5, mb_convert_encoding('FIRMA Y SELLO', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    // Línea de "DIRECTOR/A" y "REPRESENTANTE LEGAL"
    $pdf->Cell($halfPageWidth, 5, mb_convert_encoding('DIRECTOR/A', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    $pdf->Cell($halfPageWidth, 5, mb_convert_encoding('REPRESENTANTE LEGAL', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $pdf->Output('I', 'anexoIX.pdf');
?>
