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
                // echo $anexoviiiHabil, $anexoixHabil, $anexoxHabil;
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
