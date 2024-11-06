<?php
    include '../../php/verificarSessionEstudiantes.php';

    $sqlAnexoV = "
    SELECT aiv.idAnexoIV, aiv.denominacionProyecto 
    FROM anexoiv aiv
    JOIN anexov av ON av.fkAnexoIV = aiv.idAnexoIV
    WHERE av.dni = '$dniEstudiante' AND aiv.estado = 3";

    $resultado = mysqli_query($conexion, $sqlAnexoV);
    if (!$resultado) {
        echo "Error en la consulta: " . mysqli_error($conexion);
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/hijosMenu.css">
</head>
<body>
    <nav class="navbar navbar-custom">
        <div class="container-fluid d-flex align-items-center">
            <a onclick="window.history.back();" class="btn btn-warning ms-auto"  style="color: white; font-family: system-ui;">Atrás</a>
        </div>
    </nav>
    <div class="container">
        <h1>Salidas Educativas</h1>
        <div class="row mt-5">
            <div class="col-md">
                <h3>Salidas Activas (Aprobadas)</h3>
                <hr>
                <ul>
                    <?php
                    // Comprobamos si hay resultados
                    if (mysqli_num_rows($resultado) > 0) {
                        // Iteramos sobre los resultados y mostramos las salidas
                        while ($filaAnexoIV = mysqli_fetch_assoc($resultado)) {
                            echo "<li><a href='formularioAnexoVII.php?idSalida=" . $filaAnexoIV['idAnexoIV'] . "' class='btn border-bottom border-top form-control'>" . $filaAnexoIV['denominacionProyecto'] . "</a></li>";
                        }
                    } else {
                        echo "<li>No hay salidas educativas disponibles para este alumno.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>