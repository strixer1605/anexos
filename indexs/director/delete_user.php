<?php
  include('../modulos/conexion.php');

  

  $id =  $_POST['id'];
    
 
  $sql = "DELETE FROM `anexoiv` WHERE `id` = '".$id."' ";


  mysqli_query($conexion,$sql);

  if(mysqli_error($conexion) == " ")
  {
      echo 'Se elimino correctamente';

  }else
  {
      echo mysqli_error($conexion);
  }
   
?>