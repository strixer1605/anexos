<?php
    include ('conexion.php');

    if (isset($idSalida)) {
        $sql = "SELECT anexoviiiHabil FROM anexoiv WHERE idAnexoIV = ?";
        $stmt = $conexion->prepare($sql);
        if ($stmt === false) {
            die('Error preparando la consulta: ' . $conexion->error);
        }

        $stmt->bind_param('i', $idSalida);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $anexoviiiHabil = $row['anexoviiiHabil'];

                if ($anexoviiiHabil == 1) {
                    $sqlAnexoVIII = "SELECT fkAnexoIV FROM anexoix WHERE fkAnexoIV = ?";
                    $stmtAnexoVIII = $conexion->prepare($sqlAnexoVIII);
                    $stmtAnexoVIII->bind_param('i', $idSalida);
                    $stmtAnexoVIII->execute();
                    $resultAnexoVIII = $stmtAnexoVIII->get_result();
                    
                    if ($resultAnexoVIII->num_rows > 0) {
                        echo '<li><a href="../pdf/plantillaAnexoIX.php" class="btn form-control botones w-100 mb-3">Anexo VIII</a></li>';
                    } else {
                        echo '<li><a class="btn form-control botones w-100 mb-3" disabled>Anexo VIII (Sin completar)</a></li>';
                    }
                    $stmtAnexoVIII->close();
                }
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
