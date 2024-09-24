<?php   
    include ('conexion.php');

    if (isset($idSalida)) {
        $sql = "SELECT anexoviiiHabil, anexoixHabil, anexoxHabil FROM anexoiv WHERE idAnexoIV = ?";
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
                $anexoixHabil = $row['anexoixHabil'];
                $anexoxHabil = $row['anexoxHabil'];
                
                if($anexoviiiHabil == 1){
                    echo'<li><a href="../pdf/plantillaAnexoVIII/plantillaAnexoVIII.php" class="btn form-control botones w-100 mb-3">Anexo 8</a></li>';
                }
                if($anexoixHabil == 1){
                    echo'<li><a href="../pdf/plantillaAnexoIX/plantillaAnexoIX.php" class="btn form-control botones w-100 mb-3">Anexo 9</a></li>';
                }
                if($anexoxHabil == 1){
                    echo'<li><a href="../pdf/plantillaAnexoX/plantillaAnexoX.php" class="btn form-control botones w-100 mb-3">Anexo 10</a></li>';
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
