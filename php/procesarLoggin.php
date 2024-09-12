<?php
    session_start();
    session_unset();

    include('conexion.php');
    include('passwordDirector.php');

    $dni = mysqli_real_escape_string($conexion, $_POST["dni"]);
    $password = mysqli_real_escape_string($conexion, $_POST["password"]);

    $sql_personal = "SELECT * FROM personal WHERE dni = '$dni'";
    $result_personal = $conexion->query($sql_personal);

    $sql_padre = "SELECT * FROM padrestutores WHERE dni = '$dni' AND ocupacion NOT LIKE 'DOCENTE'";
    $result_padre = $conexion->query($sql_padre);

    $conexion->close();

    if ($dni == $dniDirector && $password == $password_d) {
        $_SESSION['dniDirector'] = $dniDirector;
        header("Location: datosSesion.php");
        exit;
    } 

    if ($result_personal->num_rows > 0) {
        $row = $result_personal->fetch_assoc();
        
        if ($password === $row["pass"]) {
            $_SESSION['dniProfesor'] = $dni;
            header("Location: datosSesion.php");
            exit;
        }
    }

    if ($result_padre->num_rows > 0) {
        $row = $result_padre->fetch_assoc();
        if ($password === $row["contrasena"]) {
            $_SESSION['dniPadre'] = $dni;
            header("Location: datosSesion.php");
            exit;
        }
    }

    header("Location: error.php");
    exit;
?>
