<?php
   include('coneccion.php');


    $Nombre_de_la_persona_o_razon_social_de_la_empresa =  $_POST['Nombre_de_la_persona_o_razon_social_de_la_empresa'];
    $Domicilio_del_propietario_o_la_empresa = $_POST['Domicilio_del_propietario_o_la_empresa'];
    $Telefono_del_propietario_o_la_empresa = $_POST['Telefono_del_propietario_o_la_empresa'];
    $Domicilio_del_gerente_o_responsable = $_POST['Domicilio_del_gerente_o_responsable'];
    $Telefono = $_POST['Telefono'];
    $Telefono_movil = $_POST['Telefono_movil'];
    $Titularidad_del_vehiculo = $_POST['Titularidad_del_vehiculo'];
    $Compania_aseguradora = $_POST['Compania_aseguradora'];
    $Numero_de_poliza = $_POST['Numero_de_poliza'];
    $Tipo_de_seguro = $_POST['Tipo_de_seguro'];
    $Nombre_del_conductor1 = $_POST['Nombre_del_conductor1'];
    $DNI_conductor1 = $_POST['DNI_conductor1'];
    $Licencia_N1 = $_POST['Licencia_N1'];
    $Vigencia1 = $_POST['Vigencia1'];
    $Nombre_del_conductor2 = $_POST['Nombre_del_conductor2'];
    $DNI_del_conductor2 = $_POST['DNI_del_conductor2'];
    $Licencia_N2 = $_POST['Licencia_N2'];
    $Vigencia2 = $_POST['Vigencia2'];


        
    $sql = "INSERT INTO 
            `anexo_ix`(`Nombre_de_la_persona_o_razon_social_de_la_empresa`,`Domicilio_del_propietario_o_la_empresa`, `Telefono_del_propietario_o_la_empresa`, `Domicilio_del_gerente_o_responsable`, `Telefono`, `Telefono_movil`, `Titularidad_del_vehiculo`,`Numero_de_poliza`,`Tipo_de_seguro`,`Nombre_del_conductor1`,`DNI_conductor1`,`Licencia_N1`,`Vigencia1`,`Nombre_del_conductor2`,`DNI_del_conductor2`,`Licencia_N2`,`Vigencia2`) 
            VALUES ('".$Nombre_de_la_persona_o_razon_social_de_la_empresa."','".$Domicilio_del_propietario_o_la_empresa."','".$Telefono_del_propietario_o_la_empresa."','".$Domicilio_del_gerente_o_responsable."','".$Telefono."','".$Telefono_movil."','".$Titularidad_del_vehiculo."','".$Numero_de_poliza."','".$Tipo_de_seguro."','".$Nombre_del_conductor1."','".$DNI_conductor1."','".$Licencia_N1."','".$Vigencia1."','".$Nombre_del_conductor2."','".$DNI_del_conductor2."','".$Licencia_N2."','".$Vigencia2."')";


 

     $result = mysqli_query($coneccion,$sql);




     if(mysqli_error($coneccion) == "")
     {
         echo 'Se guardo correctamente';
     }else
     {
         echo ' se produjo un error al guardar'.mysqli_error($conexion);
     }
 


?>