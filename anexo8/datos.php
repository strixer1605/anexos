<?php

include('conexion.php');

    $caja1 =  $_POST['in1'];
    $caja2 =  $_POST['in2'];
    $caja3 =  $_POST['in3'];
    $caja4 =  $_POST['in4'];
    $caja5 =  $_POST['in5'];
    $caja6 =  $_POST['in6'];
    $caja7 =  $_POST['in7'];
    $caja8 =  $_POST['in8'];
    $caja9 =  $_POST['in9'];
    $caja10 =  $_POST['in10'];
    $caja11 =  $_POST['in11'];
    $caja12 =  $_POST['in12'];
    $caja13 =  $_POST['in13'];
    $caja14 =  $_POST['in14'];
    $caja15 =  $_POST['in15'];
    $caja16 =  $_POST['in16'];
    $caja17 =  $_POST['in17'];

    if($caja1 != null && $caja1 != "" && $caja2 != "" && $caja2 != null &&
       $caja3 != null && $caja3 != "" && $caja4 != "" && $caja4 != null &&
       $caja5 != null && $caja5 != "" && $caja6 != "" && $caja6 != null &&
       $caja7 != null && $caja7 != "" && $caja8 != "" && $caja8 != null &&
       $caja9 != null && $caja9 != "" && $caja10 != "" && $caja10 != null &&
       $caja11 != null && $caja11 != "" && $caja12 != "" && $caja12 != null &&
       $caja13 != null && $caja13 != "" && $caja14 != "" && $caja14 != null &&
       $caja15 != null && $caja15 != "" && $caja16 != "" && $caja16 != null &&
       $caja17 != null && $caja17){


        $sql = "INSERT INTO 

                `anexoviii`(`institucion`, `año`, `division`, `area`, `docente`,
                `objetivo`, `fecha`, `lugares`, 
                `descripcion`, `responsables`,`observaciones`,
                `descripcion2`, `responsables2`, `observaciones2`,
                `descripcion3`, `responsables3`, `observaciones3`) 
                VALUES ('".$caja1."','".$caja2."','".$caja3."','".$caja4."','".$caja5."'
                ,'".$caja6."','".$caja7."','".$caja8."'
                ,'".$caja9."','".$caja10."','".$caja11."'
                ,'".$caja12."','".$caja13."','".$caja14."'
                ,'".$caja15."','".$caja16."','".$caja17."')";

        mysqli_query($conexion,$sql);

        echo 'se guardo correctamente';

    }else{

        echo 'faltan campos por completar';
        
    }
?>
