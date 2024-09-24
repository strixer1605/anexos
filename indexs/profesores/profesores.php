<?php
    session_start();
    if (!isset($_SESSION['dniProfesor'])) {
        header('Location: ../../index.php');
        exit;
    }
    include('../../php/conexion.php');
    echo $_SESSION['dniProfesor'];
    echo $_SESSION['dniPadre'];
    
    $hijos = isset($_SESSION['hijos']) ? $_SESSION['hijos'] : [];
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="../../librerias/jquery.js?v=1"></script>
        <link rel="stylesheet" href="../../librerias/bootstrap.css">
        <link rel="stylesheet" href="../../css/estilos.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Menu</title>
    </head>
    <body>
        <div class="container">
            <a href="../../php/logout.php" class="btn btn-danger">Cerrar sesión</a>
            <div class="row justify-content-center ">
                <div class="col-6">
                    <h2 class="col-12 text-center mt-4">Opciones</h2>
                    <div class="col-12 text-center mt-4">
                        <a href="menuAdministrarSalidas.php" class="btn border-bottom border-top form-control" style="width: 100%;">Salidas Educativas</a>
                    </div>
                </div>
                <div class="col-6">
                    <h2 class="col-12 text-center mt-4">Hijos a Cargo</h2>
                    <div class="col-12 text-center mt-4">
                        <?php if (!empty($hijos)): ?>
                            <?php foreach ($hijos as $hijo): ?>
                                <a href="../salidasHijos.php?dniHijo=<?= $hijo['dni'] ?>" class="btn border-bottom border-top form-control" style="width: 100%;"><?= $hijo['apellido'] . ' ' . $hijo['nombre'] ?></a><br><br>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay hijos asociados.</p>
                        <?php endif; ?>
                        <?php if ($error): ?>
                            <p><?= $error ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../librerias/jquery.js"></script>
        <script src="../../librerias/boostrap.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>