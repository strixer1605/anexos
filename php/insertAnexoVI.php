<?php
    session_start();

    if (isset($_SESSION['dniProfesor']) && isset($_SESSION['dniPadre'])) {
        $dniPadre = $_SESSION['dniProfesor'];
        include 'conexion.php';
    } else if (isset($_SESSION['dniPadre'])) {
        $dniPadre = $_SESSION['dniPadre'];
        include 'conexion.php';
    }

    $idSalida = $_SESSION['idSalida'];
    $dniHijo = $_SESSION['dniHijo'];
    $domicilio = isset($_POST['domicilio']) ? trim($_POST['domicilio']) : '';
    $altura = isset($_POST['altura']) ? trim($_POST['altura']) : '';
    $localidad = isset($_POST['localidad']) ? trim($_POST['localidad']) : '';

    $sqlCheck = "SELECT * FROM `anexovi` WHERE `dniAlumno` = '$dniHijo' AND `fkAnexoIV` = '$idSalida'";
    $resultCheck = mysqli_query($conexion, $sqlCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        $row = mysqli_fetch_assoc($resultCheck);
        
        // Verificar si el dniPadre actual es igual al almacenado en la base de datos
        if ($row['dniPadre'] === $dniPadre) {
            // Si son iguales, actualizar el registro existente
            $sqlUpdate = "UPDATE `anexovi` 
                        SET `domicilio` = '$domicilio', `altura` = '$altura', `localidad` = '$localidad' 
                        WHERE `dniAlumno` = '$dniHijo' AND `fkAnexoIV` = '$idSalida'";
            $resultado = mysqli_query($conexion, $sqlUpdate);
        } else {
            // Si el dniPadre es diferente, insertar un nuevo registro
            $sqlInsert = "INSERT INTO `anexovi`(`fkAnexoIV`, `dniAlumno`, `domicilio`, `altura`, `localidad`, `dniPadre`) 
                        VALUES ('$idSalida', '$dniHijo', '$domicilio', '$altura', '$localidad', '$dniPadre')";
            $resultado = mysqli_query($conexion, $sqlInsert);
        }
    } else {
        // Si no existe el registro, insertar uno nuevo
        $sqlInsert = "INSERT INTO `anexovi`(`fkAnexoIV`, `dniAlumno`, `domicilio`, `altura`, `localidad`, `dniPadre`) 
                    VALUES ('$idSalida', '$dniHijo', '$domicilio', '$altura', '$localidad', '$dniPadre')";
        $resultado = mysqli_query($conexion, $sqlInsert);
    }

    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Datos guardados correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar los datos: ' . mysqli_error($conexion)]);
    }

    mysqli_close($conexion);
?>
