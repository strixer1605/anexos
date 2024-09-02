<?php
    include('conexion.php');

    $id =  $_POST['id'];
    $estado = $_POST['estado'];

    print_r ($estado);

    $sql = "UPDATE `anexoiv` SET `estado`='$estado', fecha_modificacion = NOW() WHERE `id` = '".$id."' ";
    mysqli_query($conexion,$sql);
?>



