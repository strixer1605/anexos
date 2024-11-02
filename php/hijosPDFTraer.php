<?php
    include ('conexion.php');

    if (isset($idSalida) && isset($dniAlumno)) {
        $sqlAnexoVI = "SELECT fkAnexoIV FROM anexovi WHERE fkAnexoIV = ? AND dniAlumno = ?";
        $stmtAnexoVI = $conexion->prepare($sqlAnexoVI);
        $stmtAnexoVI->bind_param('is', $idSalida, $dniAlumno); 
        $stmtAnexoVI->execute();
        $stmtAnexoVI = $stmtAnexoVI->get_result();
        
        if ($stmtAnexoVI->num_rows > 0) {
            echo '<li><a href="../pdf/plantillaAnexoVI.php" class="btn form-control botones w-100 mb-3">Anexo 6</a></li>';
        } else {
            echo '<li><a class="btn form-control botones w-100 mb-3" disabled>Anexo 6 (Sin completar)</a></li>';
        }
        $stmtAnexoVI->close();

        // $sqlAnexoVII = "SELECT fkAnexoIV FROM anexovii WHERE fkAnexoIV = ? AND dniAlumno = ?";
        // $stmtAnexoVII = $conexion->prepare($sqlAnexoVII);
        // $stmtAnexoVII->bind_param('is', $idSalida, $dniAlumno);
        // $stmtAnexoVII->execute();
        // $stmtAnexoVII = $stmtAnexoVII->get_result();
        
        // if ($stmtAnexoVII->num_rows > 0) {
        //     echo '<li><a href="../pdf/plantillaAnexoVII.php" class="btn form-control botones w-100 mb-3">Anexo 7</a></li>';
        // } else {
        //     echo '<li><a class="btn form-control botones w-100 mb-3" disabled>Anexo 7 (Sin completar)</a></li>';
        // }
        // $stmtAnexoVII->close();
        // $conexion->close();
    } else {
        die('Error: idSalida o dniAlumno no están definidos.');
    }
?>
