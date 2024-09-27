<?php
    include ('conexion.php');

    if (isset($idSalida)) {
        $sql = "SELECT anexoixHabil FROM anexoiv WHERE idAnexoIV = ?";
        $stmt = $conexion->prepare($sql);
        if ($stmt === false) {
            die('Error preparando la consulta: ' . $conexion->error);
        }

        $stmt->bind_param('i', $idSalida);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $anexoixHabil = $row['anexoixHabil'];

                $sqlAnexoVIII = "SELECT fkAnexoIV FROM anexoviii WHERE fkAnexoIV = ?";
                $stmtAnexoVIII = $conexion->prepare($sqlAnexoVIII);
                $stmtAnexoVIII->bind_param('i', $idSalida);
                $stmtAnexoVIII->execute();
                $resultAnexoVIII = $stmtAnexoVIII->get_result();
                
                if ($resultAnexoVIII->num_rows > 0) {
                    echo '<li><a href="../pdf/plantillaAnexoVIII.php" class="btn form-control botones w-100 mb-3">Anexo 8</a></li>';
                } else {
                    echo '<li><a class="btn form-control botones w-100 mb-3" disabled>Anexo 8 (Sin completar)</a></li>';
                }
                $stmtAnexoVIII->close();

                if ($anexoixHabil == 1) {
                    $sqlAnexoIX = "SELECT fkAnexoIV FROM anexoix WHERE fkAnexoIV = ?";
                    $stmtAnexoIX = $conexion->prepare($sqlAnexoIX);
                    $stmtAnexoIX->bind_param('i', $idSalida);
                    $stmtAnexoIX->execute();
                    $resultAnexoIX = $stmtAnexoIX->get_result();
                    
                    if ($resultAnexoIX->num_rows > 0) {
                        echo '<li><a href="../pdf/plantillaAnexoIX.php" class="btn form-control botones w-100 mb-3">Anexo 9</a></li>';
                    } else {
                        echo '<li><a class="btn form-control botones w-100 mb-3" disabled>Anexo 9 (Sin completar)</a></li>';
                    }
                    $stmtAnexoIX->close();
                }

                echo '<li><a href="../pdf/plantillaAnexoX.php" class="btn form-control botones w-100 mb-3">Anexo 10</a></li>';

            } else {
                die('Error: No se encontraron resultados.');
            }

        } else {
            die('Error al ejecutar la consulta: ' . $stmt->error);
        }

        $stmt->close();
        $conexion->close();
    } else {
        die('Error: idSalida no está definido.');
    }
?>
