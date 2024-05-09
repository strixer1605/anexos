<?php
    session_start();

    include('config.php');
    include('conexionescuela.php');

    $dni = mysqli_real_escape_string($conexion, $_POST["dni"]);
    $password = mysqli_real_escape_string($conexion, $_POST["password"]);

    $_SESSION['dni'] = $dni;

    $sql_personal = "SELECT * FROM personal WHERE dni = '$dni'";
    $result_personal = $conexion->query($sql_personal);

    $sql_padres = "SELECT * FROM padrestutores WHERE dni = '$dni'";
    $result_padres = $conexion->query($sql_padres);

    if ($dni === $dni_director) {
        header("Location: ../indexs/directivos.php");
        exit;
    }

    if ($result_personal && $result_personal->num_rows > 0) {
        $row = $result_personal->fetch_assoc();
        // Verificar si la contraseña ingresada coincide con la contraseña almacenada
        if ($password === $row["pass"]) {
            // Redirigir al profesor
            header("Location: ../indexs/profesores.php");
            exit;
        }
    }

    // Verificar si el DNI y la contraseña coinciden en la tabla padrestutores
    if ($result_padres && $result_padres->num_rows > 0) {
        $row = $result_padres->fetch_assoc();
        // Verificar si la contraseña ingresada coincide con la contraseña almacenada
        if ($password === $row["contrasena"]) {
            // Redirigir al padre
            header("Location: ../indexs/padres/hijos(padres).php");
            exit;
        }
    }

    // Si ninguna autenticación fue exitosa, redirigir a una página de error
    header("Location: error.php");
    exit;

    // Cerrar la conexión (si es necesario)
    $conexion->close();
?>
