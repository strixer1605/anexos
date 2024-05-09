<?php
  include('../modulos/conexion.php');

  

  $id =  $_POST['id'];
    
 
  $sql = "DELETE FROM `anexoiv` WHERE `id` = '".$id."' ";


  mysqli_query($conexion,$sql);

  if(mysqli_error($conexion) == " ")
  {
      echo 'se elimino correctamente';

  }else
  {
      echo mysqli_error($conexion);
  }
   
?>