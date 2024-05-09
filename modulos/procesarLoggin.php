<?php
    session_start();

    include('config.php');
    include('conexionescuela.php');

    $dni = mysqli_real_escape_string($conexion, $_POST["dni"]);
    $password = mysqli_real_escape_string($conexion, $_POST["password"]);

    $_SESSION['dni'] = $dni;

    $sql_personal = "SELECT * FROM padrestutores WHERE dni = '$dni' AND ocupacion LIKE 'DOCENTE'";
    $result_personal = $conexion->query($sql_personal);

    $sql_padres = "SELECT * FROM padrestutores WHERE dni = '$dni' AND ocupacion NOT LIKE 'DOCENTE'";
    $result_padres = $conexion->query($sql_padres);

    if ($dni === $dni_director) {
        header("Location: ../indexs/directivos.php");
        exit;
    }

    if ($result_personal && $result_personal->num_rows > 0) {
        $row = $result_personal->fetch_assoc();
        if ($password === $row["contrasena"]) {
            header("Location: ../indexs/profesores/profesores.php");
            exit;
        }
    }

    if ($result_padres && $result_padres->num_rows > 0) {
        $row = $result_padres->fetch_assoc();
        if ($password === $row["contrasena"]) {
            header("Location: ../indexs/padres/padres.php");
            exit;
        }
    }

    header("Location: error.php");
    exit;

    $conexion->close();
?>
