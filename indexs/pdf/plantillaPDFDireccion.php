<?php 
require('fpdf/fpdf.php');
include('../../php/verificarSessionPDF.php');

// Encabezado 
class PDF extends FPDF
{    
    // Content
    function addContent()
    {
        $this->Image('../../imagenes/eest.png', 20, 8, 20);
        $this->Image('../../imagenes/logoprovincia.jpg', 102, 8, 90);

        // Arial bold 12
        $this->SetFont('Arial', 'B', 12);
        // Título
        $this->Cell(0, 50, mb_convert_encoding('ANEXO IX', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Line(95, 47, 115, 47);
        
        // Subtítulo
        // $this->Ln(5); // Añadir un poco de espacio debajo del título principal
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, -10, mb_convert_encoding('SALIDAS EDUCATIVAS / DE REPRESENTACIÓN INSTITUCIONAL', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Cell(0, -10, mb_convert_encoding('DECLARACIÓN JURADA DE DIRECTIVOS Y/O REPRESENTANTES LEGALES', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        // Espacio adicional debajo del encabezado
        $this->Ln(20);

        // Información del Establecimiento
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 7, mb_convert_encoding('NOMBRE DEL ESTABLECIMIENTO:', 'ISO-8859-1', 'UTF-8'), 0, 0); // Mantener en la misma línea con ancho fijo
        
        // Configuración para el nombre de la escuela
        $nombreEscuela = 'Escuela de Educación Raul Scalabrini Ortiz';
        $this->MultiCell(0, 7, mb_convert_encoding($nombreEscuela, 'ISO-8859-1', 'UTF-8'), 0, 1); // Usar MultiCell para ajuste automático

        $this->Cell(5, 7, mb_convert_encoding('Nº', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->Cell(70, 7, '1', 0, 0);
        $this->Cell(10, 7, mb_convert_encoding('CUE:', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $cue = '061806600';
        $this->Cell(0, 7, $cue, 0, 1);

        $this->Cell(20, 7, mb_convert_encoding('DOMICILIO:', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $domicilioInstitucion = "calle 124 N°345";
        $this->Cell(60, 7, mb_convert_encoding($domicilioInstitucion, 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->Cell(20, 7, mb_convert_encoding('DISTRITO:', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $distrito = 'La Costa';
        $this->Cell(0, 7, mb_convert_encoding($distrito, 'ISO-8859-1', 'UTF-8'), 0, 1);

        // Director/a del establecimiento
        $this->Cell(68, 7, mb_convert_encoding('DIRECTOR/A DEL ESTABLECIMIENTO:', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->MultiCell(0, 7, mb_convert_encoding('Martin Raul Salvado', 'ISO-8859-1', 'UTF-8'), 0, 1);

        // Representante legal (DIEGEP)
        $this->Cell(62, 7, mb_convert_encoding('REPRESENTANTE LEGAL (DIEGEP)', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->Cell(0, 7, '___________________________________________', 0, 1);

        // Entidad propietaria (DIEGEP)
        $this->Cell(60, 7, mb_convert_encoding('ENTIDAD PROPIETARIA (DIEGEP)', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->Cell(0, 7, '___________________________________________', 0, 1);

        // Fecha y lugar de realización
        $this->Cell(100, 7, mb_convert_encoding('FECHA Y LUGAR DE REALIZACIÓN DE LA SALIDA EDUCATIVA /', 'ISO-8859-1', 'UTF-8'), 0, 1);
        $this->Cell(1, 2, mb_convert_encoding('SALIDA DE REPRESENTACIÓN INSTITUCIONAL', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->Cell(1, 13, mb_convert_encoding('Ahora es Tiempo de Sumar XIV - El Regreso', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->MultiCell(0, 22, mb_convert_encoding('15//11/2024 CINE ATLANTICO, SANTA TERESITA, CALLE 41 N°238', 'ISO-8859-1', 'UTF-8'), 0, 1);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 7, mb_convert_encoding('DATOS DEL SEGURO ESCOLAR:', 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        $this->SetFont('Arial', '', 10);
        // Compañía aseguradora
        $this->Cell(50, 7, mb_convert_encoding('COMPAÑÍA ASEGURADORA:', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->MultiCell(0, 7, mb_convert_encoding('SANCOR SEGUROS', 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        // Tipo de seguro
        $this->Cell(38, 7, mb_convert_encoding('TIPO DE SEGURO (1)', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->MultiCell(0, 7, mb_convert_encoding('ESCOLAR', 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        $this->SetFont('Arial', '', 10);
        
        // Campos adicionales: PÓLIZA N°, VIGENCIA, OBSERVACIONES (2)
        $this->Cell(20, 7, mb_convert_encoding('PÓLIZA N°', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, '11966714', 0, 1);
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(20, 7, mb_convert_encoding('VIGENCIA', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $anioActual = date("Y");
        
        $this->Cell(0, 10, $anioActual, 0, 1);
        
        $this->Cell(50, 7, mb_convert_encoding('COMPAÑÍA ASEGURADORA:', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->MultiCell(0, 7, mb_convert_encoding('PROVINCIA SEGUROS', 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        $this->Cell(0, 7, mb_convert_encoding('TIPO DE SEGURO (1) RESPONSABILIDAD CIVIL PARA ALUMNOS MENORES:', 'ISO-8859-1', 'UTF-8'), 0, 0);
        
        $this->Ln(5);
        
        $this->Cell(20, 7, mb_convert_encoding('PÓLIZA N°:', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->MultiCell(0, 7, mb_convert_encoding('121966', 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(20, 7, mb_convert_encoding('VIGENCIA', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $anioActual = date("Y");
        
        $this->Cell(0, 7, $anioActual, 0, 1);
        
        $this->Cell(50, 7, mb_convert_encoding('COMPAÑÍA ASEGURADORA:', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->MultiCell(0, 7, mb_convert_encoding('PROVINCIA SEGUROS', 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        $this->Cell(37, 7, mb_convert_encoding('TIPO DE SEGURO (1)', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->MultiCell(0, 7, mb_convert_encoding('RESPONSABILIDAD CIVIL PARA MAYORES DE 18 AÑOS', 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        $this->SetFont('Arial', '', 10);
        
        $this->Cell(20, 4, mb_convert_encoding('___________________________', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->Ln(5);
        $this->Cell(20, 7, mb_convert_encoding('PÓLIZA N°', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 7, mb_convert_encoding('121713', 'ISO-8859-1', 'UTF-8'), 0, 0);
        
        $this->Ln(5);
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(20, 7, mb_convert_encoding('VIGENCIA', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $anioActual = date("Y");
        
        $this->Cell(0, 7, $anioActual, 0, 1);
        $this->Cell(0, 10, mb_convert_encoding('OBSERVACIONES (2):', 'ISO-8859-1', 'UTF-8'), 0, 1);
        $this->Cell(0, 12, mb_convert_encoding('___________________________________________________________________________________', 'ISO-8859-1', 'UTF-8'), 0, 1);

        // Declaración jurada
        $this->Ln(10);
        $this->SetFont('Arial', '', 11);
        $declaracion = "En nuestro carácter de Director/a y/o Representante Legal del establecimiento educativo de referencia declaramos bajo juramento haber dado cumplimiento a los requerimientos del Anexo II de la Resolución de Salidas Educativas/ de Representación Institucional referidos a: Lugar de realización de la Salida Educativa y Salida de Representación Institucional, transporte, autorizaciones de madre, padre, tutor o responsable de los/as estudiantes con menos de 18 años de edad y Declaración Jurada de las/los estudiantes mayores de 18 años; garantizando el cumplimiento de la relación docente/estudiante y la información a los responsables legales de la Salida Educativa / Salida de Representación Institucional que realizará la institución educativa en el marco de su Proyecto Institucional. \nPonemos asimismo a disposición de la autoridad educativa que lo requiera los Anexos III, IV, V, VI, VII, VIII y IX completos (según corresponda, conforme lo estipulado en el Anexo II), como así también el libro de Actas Institucionales.";
        $this->MultiCell(0, 7, mb_convert_encoding($declaracion, 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        $this->Ln(5);
        
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 7, mb_convert_encoding('Aclaración:', 'ISO-8859-1', 'UTF-8'), 0, 1);
        $this->SetFont('Arial', '', 11);
        $declaracion = "El presente formulario debe ser completado por el/la directora/a. Y en el caso de las Escuelas Públicas de Gestión Privada, también por el/la Representante Legal. Este Anexo debe ser transcripto en puño y letra en el Libro de Actas Institucional de Salidas Educativas, con firma original. Para ser enviado al/la Inspector/a y al Seguro Escolar puede hacerse con el formato digital o bien sacarle una foto a la transcripción realizada en el Libro de Actas y enviar en formato PDF.";
        $this->MultiCell(0, 7, mb_convert_encoding($declaracion, 'ISO-8859-1', 'UTF-8'), 0, 1);

        $this->Ln(15);
        
        $this->Cell(0, 10, mb_convert_encoding('1) Deberá constar en la póliza que el tipo de seguro es de responsabilidad civil.', 'ISO-8859-1', 'UTF-8'), 0, 1);
        $this->MultiCell(0, 7, mb_convert_encoding('2) En este rubro se dejará constancia de todas las situaciones que puedan surgir y no estén previstas en el presente formulario.', 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        $this->Cell(0, 40, mb_convert_encoding('Lugar y fecha:..........................................................................................', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        
        $this->Ln(20);

        // Ancho de la mitad de la página
        $halfPageWidth = $this->GetPageWidth() / 2 - 20; // Resta márgenes si los hay

        // Línea de "FIRMA Y SELLO"
        $this->Cell($halfPageWidth, 5, mb_convert_encoding('FIRMA Y SELLO', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
        $this->Cell($halfPageWidth, 5, mb_convert_encoding('FIRMA Y SELLO', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        // Línea de "DIRECTOR/A" y "REPRESENTANTE LEGAL"
        $this->Cell($halfPageWidth, 5, mb_convert_encoding('DIRECTOR/A', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
        $this->Cell($halfPageWidth, 5, mb_convert_encoding('REPRESENTANTE LEGAL', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');


    }
}

// Crear PDF
$pdf = new PDF();
$pdf->SetMargins(20, 20, 20, 20);
// Establecer margen inferior
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();
$pdf->addContent();

$pdf->Output('I', 'anexoIX.pdf');
?>
