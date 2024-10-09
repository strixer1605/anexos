<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
    // $docenteSession = $_SESSION['nombreCompleto'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $institucion = $_POST['institucion'] ?? null;
        $cursos = $_POST['cursos'] ?? null;
        $materias = $_POST['materias'] ?? null;
        $docente = $_POST['docente'] ?? null;
        $objetivo = $_POST['inputObjetivos'] ?? null;
        $fechaSalida = $_POST['fechaSalida'] ?? null;
        $lugaresVisitar = $_POST['lugaresVisitar'] ?? null;
        $descPrevia = $_POST['inputDescripcionPrevia'] ?? null;
        $respPrevia = $_POST['responsablesPrevia'] ?? null;
        $obsPrevia = $_POST['obsPrevia'] ?? null;
        $descDurante = $_POST['inputDescripcionDurante'] ?? null;
        $respDurante = $_POST['responsablesDurante'] ?? null;
        $obsDurante = $_POST['obsDurante'] ?? null;
        $descEvaluacion = $_POST['inputDescripcionEvaluacion'] ?? null;
        $respEvaluacion = $_POST['responsablesEvaluacion'] ?? null;
        $obsEvaluacion = $_POST['obsEvaluacion'] ?? null;

        // Verificar si ya existe un registro para la salida
        $sqlVerificacion = "SELECT * FROM anexoviii WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        $currentArea = '';

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentArea = $row['area'];
        }
        
        if (!empty($materias)) {
            $currentArea = $materias;
        }

        if ($result->num_rows > 0) {
            $sql = "UPDATE anexoviii SET 
                institucion = ?, 
                cursos = ?, 
                area = ?, 
                docente = ?, 
                objetivo = ?, 
                fechaSalida = ?, 
                lugaresVisitar = ?, 
                descripcionPrevias = ?, 
                responsablesPrevias = ?, 
                observacionesPrevias = ?, 
                descripcionDurante = ?, 
                responsablesDurante = ?, 
                observacionesDurante = ?, 
                descripcionEvaluacion = ?, 
                responsablesEvaluacion = ?, 
                observacionesEvaluacion = ? 
                WHERE fkAnexoIV = ?";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("ssssssssssssssssi", 
                $institucion,
                $cursos,  
                $currentArea,
                $docente, 
                $objetivo, 
                $fechaSalida, 
                $lugaresVisitar, 
                $descPrevia, 
                $respPrevia, 
                $obsPrevia, 
                $descDurante, 
                $respDurante, 
                $obsDurante, 
                $descEvaluacion, 
                $respEvaluacion, 
                $obsEvaluacion,
                $idSalida
            );

            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();

        } else {
            // Si no existe, insertar
            $sql = "INSERT INTO anexoviii 
                (fkAnexoIV, institucion, cursos, area, docente, objetivo, fechaSalida, lugaresVisitar, descripcionPrevias, responsablesPrevias, observacionesPrevias, descripcionDurante, responsablesDurante, observacionesDurante, descripcionEvaluacion, responsablesEvaluacion, observacionesEvaluacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("issssssssssssssss", 
                $idSalida, 
                $institucion, 
                $cursos, 
                $materias, 
                $docente, 
                $objetivo, 
                $fechaSalida, 
                $lugaresVisitar, 
                $descPrevia, 
                $respPrevia, 
                $obsPrevia, 
                $descDurante, 
                $respDurante, 
                $obsDurante, 
                $descEvaluacion, 
                $respEvaluacion, 
                $obsEvaluacion
            );

            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }

        $stmtVerificacion->close();
        $conexion->close();
    }
?>
