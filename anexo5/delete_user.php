<?php
   include('../modulos/conexion.php');

    $n =  $_POST['n'];
        
    $sql = "DELETE FROM `anexov` WHERE n = '".$n."'";

    mysqli_query($conexion, $sql);

    if(mysqli_error($conexion) == "")
    {
        echo 'Se elimino correctamente';
    }else
    {
        echo mysqli_error($conexion);
    }


?>