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
            <div class="row">
                <div class="col-12 mb-2">
                    <label class="form-label" for="domicilio">Domicilio:</label>
                    <input type="text" class="form-control" id="domicilio" value="'.$domicilio.'">
                </div>
                <div class="col-12 mb-2">
                    <label class="form-label" for="altura">Altura:</label>
                    <input type="text" class="form-control" id="altura" value="'.$altura.'">
                </div>
                <div class="col-12 mb-2">
                    <label class="form-label" for="localidad">Localidad:</label>
                    <input type="text" class="form-control" id="localidad" value="'.$localidad.'">
                </div>
            </div>';
} else {
    echo "No se encontraron registros del Anexo VI.";
}

mysqli_close($conexion);
?>
