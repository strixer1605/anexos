<?php
    session_start();

    include('conexion.php');
    include('conexionescuela.php');

    $dni = mysqli_real_escape_string($conexion, $_POST["dni"]);
    $password = mysqli_real_escape_string($conexion, $_POST["password"]);

    $_SESSION['dni'] = $dni;

    include('config.php');

    if ($dni_director == $dni) {
        $sql_director = "SELECT * FROM padrestutores WHERE dni = '$dni' AND ocupacion LIKE 'DIRECTOR'";
        $result_director = $conexion->query($sql_director);
    }

    $sql_docente = "SELECT * FROM padrestutores WHERE dni = '$dni' AND ocupacion LIKE 'DOCENTE'";
    $result_docente = $conexion->query($sql_docente);

    $sql_padre = "SELECT * FROM padrestutores WHERE dni = '$dni' AND ocupacion NOT LIKE 'DOCENTE'";
    $result_padre = $conexion->query($sql_padre);

    $conexion->close();

    if (isset($result_director) && $result_director->num_rows > 0) {
        $row = $result_director->fetch_assoc();
        if ($password === $row["contrasena"]) {
            $_SESSION['dni_director'] = $dni;
            header("Location: datosDirectorLogin.php");
            exit;
        }
    }

    if ($result_docente->num_rows > 0) {
        $row = $result_docente->fetch_assoc();
        if ($password === $row["contrasena"]) {
            $_SESSION['dni_profesor'] = $dni;
            header("Location: datosProfesorLogin.php");
            exit;
        }
    }

    if ($result_padre->num_rows > 0) {
        $row = $result_padre->fetch_assoc();
        if ($password === $row["contrasena"]) {
            $_SESSION['dni_padre'] = $dni;
            header("Location: datosPadreLogin.php");
            exit;
        }
    }

    header("Location: error.php");
    exit;
?>
