<?php
session_start();
include('conexion.php');

// Obtener el ID de la salida desde la sesión
$idSalida = $_SESSION['idSalida'];
$dniHijo = $_SESSION['dniHijo'];

// Consultar los datos del Anexo VI basados en el idSalida y dniHijo
$sql = "SELECT domicilio, altura, localidad FROM anexovi WHERE fkAnexoIV = '$idSalida' AND dniAlumno = '$dniHijo'";
$resultado = mysqli_query($conexion, $sql);

// Variables para almacenar los valores por defecto
$domicilio = "";
$altura = "";
$localidad = "";

// Si hay resultados, asignar los valores a las variables
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $domicilio = htmlspecialchars($fila['domicilio'], ENT_QUOTES, 'UTF-8');
    $altura = htmlspecialchars($fila['altura'], ENT_QUOTES, 'UTF-8');
    $localidad = htmlspecialchars($fila['localidad'], ENT_QUOTES, 'UTF-8');

    echo '
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .form-label {
            display: inline-block;
            margin-bottom: 5px;
            text-align: left; /* Alinear texto a la izquierda */
        }
        .form-control {
            width: calc(100% - 10px); /* Ajustar el ancho para incluir padding */
            margin-left: 0; /* Asegurar que no haya margen a la izquierda */
        }

        .labels6 {
            text-align: left; /* Alinear texto a la izquierda */
        }

        .col-12 {
            display: flex;
            flex-direction: column; /* Alinear etiquetas y campos en columna */
            align-items: flex-start; /* Alinear a la izquierda */
        }
    </style>
    <div class="row">
        <div class="col-12 mb-2">
            <label class="form-label labels6" for="domicilio">Domicilio:</label>
            <input type="text" class="form-control" id="domicilio" value="'.$domicilio.'">
        </div>
        <div class="col-12 mb-2">
            <label class="form-label labels6" for="altura">Altura:</label>
            <input type="text" class="form-control" id="altura" value="'.$altura.'">
        </div>
        <div class="col-12 mb-2">
            <label class="form-label labels6" for="localidad">Localidad:</label>
            <input type="text" class="form-control" id="localidad" value="'.$localidad.'">
        </div>
    </div>
    ';
} else {
    echo "No se encontraron registros del Anexo VI.";
}
mysqli_close($conexion);
?>
