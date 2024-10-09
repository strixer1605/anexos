<?php
    if (empty($_SESSION['dniDirector'])) {
        header('Location: ../index.php');
        exit;
    }
    
    include('../../php/conexion.php');
    
    $sql = "SELECT * FROM anexoiv";
    $anexoiv = mysqli_query($conexion, $sql);
    
    while ($resp = mysqli_fetch_assoc($anexoiv)) {
        echo '<tr class="col-12 text-center">';
        echo '<td>' . $resp['idAnexoIV'] . '</td>';
        echo '<td>' . $resp['denominacionProyecto'] . '</td>';
        echo '<td>' . $resp['tipoSolicitud'] . '</td>';
        echo '<td>' . $resp['lugarVisita'] . '</td>';
        echo '<td>' . $resp['fechaSalida'] . '</td>';
        echo '<td>' . $resp['fechaRegreso'] . '</td>';
    
        // Consulta para la distancia (diferencia de horas)
        $distanciaHoras = "SELECT distanciaSalida FROM anexoiv WHERE idAnexoIV = '".$resp['idAnexoIV']."'";
        $distanciaHorasRespuesta = mysqli_query($conexion, $distanciaHoras);
    
        if ($distanciaHorasRespuesta && mysqli_num_rows($distanciaHorasRespuesta) > 0) {
            $distancia = mysqli_fetch_assoc($distanciaHorasRespuesta)['distanciaSalida'];
            if (in_array($distancia, [1, 2, 4, 6])) {
                echo '<td>Si</td>';
            } else {
                echo '<td>No</td>';
            }
        }
    
        // Anexo 9 (Consulta habilitación de Anexo IX)
        $anexoixHabilsql = "SELECT anexoixHabil FROM anexoiv WHERE idAnexoIV = '".$resp['idAnexoIV']."'";
        $anexoixHabilresponse = mysqli_query($conexion, $anexoixHabilsql);
        
        if ($anexoixHabilresponse && mysqli_num_rows($anexoixHabilresponse) > 0) {
            $anexoixHabil = mysqli_fetch_assoc($anexoixHabilresponse)['anexoixHabil'];
            if ($anexoixHabil == 1) {
                echo '<td>Si</td>';
            } else {
                echo '<td>No</td>';
            }
        }
    
        // Verificación de anexos V, VIII, X
        $sqlAnexoV = "SELECT * FROM anexov WHERE fkAnexoIV = '".$resp['idAnexoIV']."'";
        $anexoVResponse = mysqli_query($conexion, $sqlAnexoV);
        $sqlAnexoVIII = "SELECT * FROM anexoviii WHERE fkAnexoIV = '".$resp['idAnexoIV']."'";
        $anexoVIIIResponse = mysqli_query($conexion, $sqlAnexoVIII);
        $sqlAnexoX = "SELECT * FROM anexox WHERE fkAnexoIV = '".$resp['idAnexoIV']."'";
        $anexoXResponse = mysqli_query($conexion, $sqlAnexoX);
    
        // Comprobar si todas las consultas tienen exactamente un resultado
        if (
            mysqli_num_rows($anexoVResponse) >= 1 &&
            mysqli_num_rows($anexoVIIIResponse) == 0 &&
            mysqli_num_rows($anexoXResponse) == 0
        ) {
            echo '<td>Si</td>';
        } else {
            echo '<td>No</td>';
        }
    
        echo '</tr>';
    }    
?>