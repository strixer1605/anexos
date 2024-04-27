<?php
   include('../modulos/conexion.php');

    $fecha =  $_POST['fecha2'];
    $nombreapellido =  $_POST['no_ap2'];
    $nombrepadre = $_POST['no_ap_fa2'];
    $direccion = $_POST['direc'];
    $telefono = $_POST['telef'];
    $alergico = $_POST['alerg'];
    $alergia = $_POST['alergresp'];
    $malestares = $_POST['sufer'];
    $otromalestar = $_POST['suferresp'];
    $medicacion =  $_POST['medic'];
    $quemedicacion = $_POST['medicresp'];
    $constancia = $_POST['cons'];
    $obrasocial = $_POST['obras'];
    $institucion = $_POST['inst'];
    $profesor = $_POST['prof'];
    $meses = $_POST['mes'];

    $sql = "INSERT INTO 
            `anexo_vii`(`fecha`,`nombre`,`nombre_padre`,`direccion`,`telefono`,`es_alergico`,`ha_sufrido`,`medicacion`,`obra_social`,`institucion`,`profesor`,`mes`,`alergico_a`,`otro_malestar`,`su_medicacion`,`constancia`) 
            VALUES ('".$fecha."','".$nombreapellido."','".$nombrepadre."','".$direccion."','".$telefono."','".$alergico."',
            '".$malestares."',
            '".$medicacion."','".$obrasocial."','".$institucion."','".$profesor."','".$meses."','".$alergia."','".$otromalestar."','".$quemedicacion."','".$constancia."')";


    mysqli_query($conexion,$sql);

    if(mysqli_error($conexion) == "")
    {
        echo 'Se guardo correctamente';
    }else
    {
        echo mysqli_error($conexion);
    }
?>



