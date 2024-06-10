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

    $dniAlumno = $_GET['dniAlumno'];
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
            <?php echo '<a href="hijos/hijosMenu.php?dniAlumno='.$dniAlumno.'" class="btn border-bottom border-top form-control" style="width: 100%;">Salidas Educativas</a>'?>
        </div>

        <script src="../librerias/jquery.js?v=1"></script>
        <script src="../librerias/boostrap.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>