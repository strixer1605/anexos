<?php
    session_start();

    if (isset($_SESSION['dni_profesor'])) {
        $dni_padre = $_SESSION['dni_profesor'];
    } elseif (isset($_SESSION['dni_director'])) {
        $dni_padre = $_SESSION['dni_director'];
    } elseif (isset($_SESSION['dni_padre'])) {
        $dni_padre = $_SESSION['dni_padre'];
    } else {
        header('Location: ../index.php');
        exit;
    }

    if (empty($dni_padre)) {
        header('Location: ../index.php');
        exit;
    }

    $dniAlum = $_GET['dniAlumno'];
    include('../../modulos/conexion.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salidas Educativas</title>
        <link rel="stylesheet" href="../librerias/bootstrap.css">
        <link rel="stylesheet" href="../css/estilos.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <br>
        <div class="col-md-6 contenedor">
            <br>
            <?php
            $Anexo5Hijo = 'SELECT * FROM anexo_v WHERE documento = "' . $dniAlum . '"';
            $resultadoAnexo5 = mysqli_query($conexion, $Anexo5Hijo);

            if ($resultadoAnexo5 && mysqli_num_rows($resultadoAnexo5) > 0) {
                $rowA5 = mysqli_fetch_assoc($resultadoAnexo5);

                if (isset($rowA5['fk_anexoIV']) && !empty($rowA5['fk_anexoIV'])) {
                    $Anexo4Hijo = 'SELECT * FROM anexo_iv WHERE id = "' . $rowA5['fk_anexoIV'] . '"';
                    $resultadoA4 = mysqli_query($conexion, $Anexo4Hijo);

                    if ($resultadoA4 && mysqli_num_rows($resultadoA4) > 0) {
                        while ($rowA4 = mysqli_fetch_assoc($resultadoA4)) {
                            echo '<div class="d-inline-flex align-items-center mt-2">';
                            echo '<p class="btn border form-control mb-0" style="cursor: text; width: 250px;">' . htmlspecialchars($rowA4['nombre_del_proyecto']) . '</p>';
                            echo '<a href="../../anexo6/anexo6.php?id=' . htmlspecialchars($rowA4['id']) . '&nombre=' . urlencode($rowA4['nombre_del_proyecto']) . '&dniAlumno='.urlencode($dniAlum).'" class="btn btn-sm btn-success botones" style="text-decoration: none; margin-left: 5px; height: auto; font-size:16px; padding:5px;">Autorización</a>';
                            echo '<a href="../../anexo7/anexo7.php?id=' . htmlspecialchars($rowA4['id']) . '&nombre=' . urlencode($rowA4['nombre_del_proyecto']) . '&dniAlumno='.urlencode($dniAlum).'" class="btn btn-sm btn-primary botones" style="text-decoration: none; margin-left: 5px; height: auto; font-size:16px; padding:5px;">Ficha Médica</a>';
                            echo '</div>';
                        }
                    } else {
                        echo 'No se encontró el Anexo IV correspondiente.';
                    }
                } else {
                    echo 'No se encontró el campo fk_anexoIV en Anexo V.';
                }
            } else {
                echo 'No hay salidas pendientes...';
            }
            ?>
        </div>

        <script src="../librerias/jquery.js?v=1"></script>
        <script src="../librerias/boostrap.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
