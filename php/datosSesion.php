<?php
    session_start();
    include('conexion.php');
    var_dump($_SESSION);

    if (isset($_SESSION['dni_director'])) {
        $dni_director = $_SESSION['dni_director'];
        $sql_director = "SELECT * FROM personal WHERE dni = '$dni_director'";
        $result_director = $conexion->query($sql_director);

        if ($result_director -> num_rows > 0) {
            $row = $result_director->fetch_assoc();
            $_SESSION['nombreDir'] = $row['nombre'];
            $_SESSION['apellidoDir'] = $row['apellido'];

            $hijoSQL = 'SELECT `dni_alumnos` FROM `padresalumnos` WHERE `dni_padrestutores` = "' . $dni_director . '"';
            include('datosHijo.php');
        } else {
            header('Location: error.php');
            exit;
        }

        $conexion->close();        
        header("Location: ../indexs/director/directivos.php");
        exit;
    }

    elseif (isset($_SESSION['dni_profesor'])) {
        $dni_profesor = $_SESSION['dni_profesor'];
        $sql_profesor = "SELECT * FROM personal WHERE dni = '$dni_profesor'";
        $result_profesor = $conexion->query($sql_profesor);

        if ($result_profesor->num_rows > 0) {
            $row = $result_profesor->fetch_assoc();
            $_SESSION['nombreDoc'] = $row['nombre'];
            $_SESSION['apellidoDoc'] = $row['apellido'];

            $hijoSQL = 'SELECT `dni_alumnos` FROM `padresalumnos` WHERE `dni_padrestutores` = "'.$dni_profesor.'"';
            include('datosHijo.php');
        } else {
            header('Location: error.php');
            exit;
        }

        $conexion->close();
        header("Location: ../indexs/profesores/profesores.php");
        exit;
    }

    elseif (isset($_SESSION['dni_padre'])) {
        $dni_padre = $_SESSION['dni_padre'];
        $sql_padre = "SELECT * FROM padrestutores WHERE dni = '$dni_padre'";
        $result_padre = $conexion->query($sql_padre);

        if ($result_padre->num_rows > 0) {
            $row = $result_padre->fetch_assoc();
            $_SESSION['nombre_padre'] = $row['nombre'];
            $_SESSION['apellido_padre'] = $row['apellido'];

            $hijoSQL = 'SELECT `dni_alumnos` FROM `padresalumnos` WHERE `dni_padrestutores` = "'.$dni_padre.'"';
            include('datosHijo.php');
        } else {
            header('Location: error.php');
            exit;
        }

        $conexion->close();
        header("Location: ../indexs/padres/padres.php");
        exit;
    }

    else {
        header('Location: ../index.php');
        exit;
    }
?>
