<?php
    session_start();
    $idSalida = $_SESSION['idSalida'];
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $institucion = $_POST['institucion'];
        $anio = $_POST['anio'];
        $division = $_POST['division'];
        $area = $_POST['area'];
        $docente = $_POST['docente'];
        $objetivo = $_POST['objetivo'];
        $fechaSalida = $_POST['fechaSalida'];
        $lugaresVisitar = $_POST['lugaresVisitar'];
        $descPrevia = $_POST['descPrevia'];
        $respPrevia = $_POST['respPrevia'];
        $obsPrevia = $_POST['obsPrevia'];
        $descDurante = $_POST['descDurante'];
        $respDurante = $_POST['respDurante'];
        $obsDurante = $_POST['obsDurante'];
        $descEvaluacion = $_POST['descEvaluacion'];
        $respEvaluacion = $_POST['respEvaluacion'];
        $obsEvaluacion = $_POST['obsEvaluacion'];

        $sqlVerificacion = "SELECT * FROM anexoviii WHERE fkAnexoIV = ?";
        $stmtVerificacion = $conexion->prepare($sqlVerificacion);
        $stmtVerificacion->bind_param("i", $idSalida);
        $stmtVerificacion->execute();
        $result = $stmtVerificacion->get_result();

        if ($result->num_rows > 0) {
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

            $stmt->bind_param("sssssssssssssss",
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
            );

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();

        } else {
            $sql = "INSERT INTO anexoviii 
                (fkAnexoIV, institucion, año, division, area, docente, objetivo, fechaSalida, lugaresVisitar, descripcionPrevias, responsablesPrevias, observacionesPrevias, descripcionDurante, responsablesDurante, observacionesDurante, descripcionEvaluacion, responsablesEvaluacion, observacionesEvaluacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("issssssssssssssssi", 
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
        
        $conexion->close();
    }
?>
