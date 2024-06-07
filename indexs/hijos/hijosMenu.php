<?php
    session_start();
    // echo $dniUsuario;
    if (empty($_SESSION['dni'])) {
        // Redirigir al usuario a la página de inicio
        header('Location: ../index.php');
        exit;
    }
    $dniPadre = $_SESSION['dni'];
    $dniAlumno = $_GET['dniAlumno'];
    // echo $dniPadre, " ", $dniAlumno;
    include('../../modulos/conexion.php');
    include('../../modulos/conexionescuela.php');
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
                $Anexo5Hijo = 'SELECT * FROM `anexo_v` WHERE documento = '.$dniAlumno.'';
                $resultadoAnexo5 = mysqli_query($conexion, $Anexo5Hijo);
                $rowA5 = $resultadoAnexo5->fetch_assoc();
                if($resultadoAnexo5){
                    $Anexo4Hijo = 'SELECT * FROM `anexo_iv` WHERE id = '.$rowA5['fk_anexoIV'].'';
                    $resultadoA4 = mysqli_query($conexion, $Anexo4Hijo);
                    $rowA4 = $resultadoA4->fetch_assoc();
                    echo $rowA4['nombre_del_proyecto'];
                }
                else{
                    echo 'No hay salidas pendientes...';
                }
            ?>
        </div>

        <script src="../librerias/jquery.js?v=1"></script>
        <script src="../librerias/boostrap.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>