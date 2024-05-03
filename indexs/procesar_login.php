<?php
    $dni = $_POST['dni'];
    $contrasena = $_POST['contrasena'];

    $directordni = 
    $directorcontraseña =

    include('../modulos/conexionescuela.php');

    $sql = "SELECT tipo FROM usuarios2 WHERE usuarios_dni = ? AND password = ?";
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "is", $dni, $contrasena);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $tipoUsuario = $row['ocupacion'];
        switch ($tipoUsuario) {
                header("Location: directivos.php");
            case 'Administrador':
                header("Location: profesores.php");
                break;
            case 'Preceptor':
                header("Location: padres.php");
                break;
            default:
                echo "<script>alert('Tipo de usuario no reconocido');
                window.location.href = 'index.html';</script>";
                break;
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
?>
