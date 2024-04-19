<?php
   include('../modulos/conexion.php');


    $nombre_ap =  $_POST['no_ap'];
    
    $DNI = $_POST['dni'];
    
    $calle = $_POST['calle'];

    $num = $_POST['num'];

    $localidad = $_POST['local'];

    $telefono = $_POST['tele'];

    $lugar = $_POST['lugar'];

    $fecha = $_POST['fecha'];

    $dni_padre = $_POST['dnipa'];
        
    $sql = "INSERT INTO 
            `vi`(`alumno`,`DNI`,`domicilio`,`num`,`localidad`,`telefono`,`lugar`,`fecha`,`DNI_padre`) 
            VALUES ('".$nombre_ap."','".$DNI."','".$calle."','".$num."','".$localidad."','".$telefono."','".$lugar."','".$fecha."','".$dni_padre."')";


    mysqli_query($conexion,$sql);

    if(mysqli_error($conexion) == "")
    {
        echo 'se guardo correctamente';
    }else
    {
        echo mysqli_error($conexion);
    }


?>



