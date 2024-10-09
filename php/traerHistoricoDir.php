<?php 
    include 'conexion.php';
    $sql = "SELECT * FROM `anexoiv` WHERE 1";
    $result = mysqli_query($conexion, $sql);

    if (!$result) {
        die('Ocurrió un error: ' . mysqli_error($conexion));
    }

    if (mysqli_num_rows($result) > 0) {
        while($fila = mysqli_fetch_assoc($result)) {
            //Tipo
            if ($fila['tipoSolicitud'] == 1) {
                $tipo = "Representación Institucional";
            } else if ($fila['tipoSolicitud'] == 2) {
                $tipo = "Educativa";
            } else {
                $tipo = "Desconocido";
            }

            // Estado
            if ($fila['estado'] == 0) {
                $estado = "Rechazada";
            } else if ($fila['estado'] == 2) {
                $estado = "Cancelada (Archivada)";
            } else if ($fila['estado'] == 3) {
                $estado = "Aprobada";
            } else {
                $estado = "Desconocido";
            }

            // Distancia y duración
            switch ($fila['distanciaSalida']) {
                case 1: 
                case 2: 
                case 4:
                case 6: 
                    $duracion = "Menos";
                    break;
                case 3: 
                case 5: 
                case 7: 
                case 8: 
                case 9:
                    $duracion = "Más";
                    break;
                default: 
                    $duracion = "No especificada";
                    break;
            }

            $anexoixHabil = ($fila['anexoixHabil'] == 1) ? "Si" : "No";

            echo '<tr>
                    <td> '.$fila['idAnexoIV'].' </td>
                    <td> '.$tipo.' </td>
                    <td> '.$fila['denominacionProyecto'].' </td>
                    <td> '.$estado.'</td>
                    <td> '.$duracion.' de 24hs </td>
                    <td> '.$fila['lugarVisita'].' </td>
                    <td> '.$fila['fechaSalida'].' </td>
                    <td> '.$fila['fechaRegreso'].' </td>
                    <td> '.$anexoixHabil.'</td>
                    <td> '.$fila['fechaLimite'].' </td>
                </tr>';
        }
    }

    mysqli_free_result($result);
    mysqli_close($conexion);
?>
