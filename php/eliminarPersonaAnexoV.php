<?php
    session_start();

    if (isset($_POST['dniList'])) {
        $dniList = $_POST['dniList'];
        $idSalida = $_SESSION['idSalida'];

        include ('conexion.php');

        $dniListString = implode(",", array_map('intval', $dniList));

        $sqlSelect = "SELECT cargo, COUNT(*) as cantidad FROM anexov WHERE dni IN ($dniListString) AND fkAnexoIV = $idSalida GROUP BY cargo";
        $result = $conexion->query($sqlSelect);
        
        $cantidadDocentes = 0;
        $cantidadAlumnos = 0;
        $cantidadAcompañantes = 0;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                switch ($row['cargo']) {
                    case 2: 
                        $cantidadDocentes += $row['cantidad'];
                        break;
                    case 3: 
                        $cantidadAlumnos += $row['cantidad'];
                        break;
                    case 4:
                        $cantidadAcompañantes += $row['cantidad'];
                        break;
                }
            }
        }

        $sqlDelete = "DELETE FROM anexov WHERE dni IN ($dniListString) AND fkAnexoIV = $idSalida";
        if ($conexion->query($sqlDelete) === TRUE) {
            if ($cantidadDocentes > 0) {
                $sqlUpdateDocentes = "UPDATE anexoIV SET cantidadDocentes = cantidadDocentes - ? WHERE idAnexoIV = ?";
                $stmtDocentes = $conexion->prepare($sqlUpdateDocentes);
                $stmtDocentes->bind_param('ii', $cantidadDocentes, $idSalida);
                $stmtDocentes->execute();
                $stmtDocentes->close();
            }

            if ($cantidadAlumnos > 0) {
                $sqlUpdateAlumnos = "UPDATE anexoIV SET cantidadAlumnos = cantidadAlumnos - ? WHERE idAnexoIV = ?";
                $stmtAlumnos = $conexion->prepare($sqlUpdateAlumnos);
                $stmtAlumnos->bind_param('ii', $cantidadAlumnos, $idSalida);
                $stmtAlumnos->execute();
                $stmtAlumnos->close();
            }

            if ($cantidadAcompañantes > 0) {
                $sqlUpdateAcompañantes = "UPDATE anexoIV SET cantidadAcompañantes = cantidadAcompañantes - ? WHERE idAnexoIV = ?";
                $stmtAcompañantes = $conexion->prepare($sqlUpdateAcompañantes);
                $stmtAcompañantes->bind_param('ii', $cantidadAcompañantes, $idSalida);
                $stmtAcompañantes->execute();
                $stmtAcompañantes->close();
            }

            echo "Personas eliminadas correctamente y cantidades actualizadas.";
        } else {
            echo "Error al eliminar: " . $conexion->error;
        }

        $conexion->close();
    }
?>
