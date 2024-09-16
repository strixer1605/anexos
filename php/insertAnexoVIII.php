<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $institucion = isset($_POST['institucion']) ? $_POST['institucion'] : null;
        $anio = isset($_POST['anio']) ? $_POST['anio'] : null;
        $division = isset($_POST['division']) ? $_POST['division'] : null;
        $area = isset($_POST['area']) ? $_POST['area'] : null;
        $docente = isset($_POST['docente']) ? $_POST['docente'] : null;
        $objetivo = isset($_POST['objetivo']) ? $_POST['objetivo'] : null;
        $fechaSalida = isset($_POST['fechaSalida']) ? $_POST['fechaSalida'] : null;
        $lugaresVisitar = isset($_POST['lugaresVisitar']) ? $_POST['lugaresVisitar'] : null;
        $descPrevia = isset($_POST['descPrevia']) ? $_POST['descPrevia'] : null;
        $respPrevia = isset($_POST['respPrevia']) ? $_POST['respPrevia'] : null;
        $obsPrevia = isset($_POST['obsPrevia']) ? $_POST['obsPrevia'] : null;
        $descDurante = isset($_POST['descDurante']) ? $_POST['descDurante'] : null;
        $respDurante = isset($_POST['respDurante']) ? $_POST['respDurante'] : null;
        $obsDurante = isset($_POST['obsDurante']) ? $_POST['obsDurante'] : null;
        $descEvaluacion = isset($_POST['descEvaluacion']) ? $_POST['descEvaluacion'] : null;
        $respEvaluacion = isset($_POST['respEvaluacion']) ? $_POST['respEvaluacion'] : null;
        $obsEvaluacion = isset($_POST['obsEvaluacion']) ? $_POST['obsEvaluacion'] : null;

        if (empty($area)) {
            $area = 'Ninguna';
        }

        // Verificar si ya existe un registro para la salida
        $sqlVerificacion = "SELECT * FROM anexoviii WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        if ($result->num_rows > 0) {
            // Si existe, actualizar
            $sql = "UPDATE anexoviii SET 
                institucion = ?, 
                año = ?, 
                division = ?, 
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

            $stmt->bind_param("sssssssssssssssssi", 
                $institucion, 
                $anio, 
                $division, 
                $area, 
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
                echo "success";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();

        } else {
            // Si no existe, insertar
            $sql = "INSERT INTO anexoviii 
                (fkAnexoIV, institucion, año, division, area, docente, objetivo, fechaSalida, lugaresVisitar, descripcionPrevias, responsablesPrevias, observacionesPrevias, descripcionDurante, responsablesDurante, observacionesDurante, descripcionEvaluacion, responsablesEvaluacion, observacionesEvaluacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("isssssssssssssssss", 
                $idSalida, 
                $institucion, 
                $anio, 
                $division, 
                $area, 
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
                echo "success";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }

        $stmtVerificacion->close();
        $conexion->close();
    }
?>
