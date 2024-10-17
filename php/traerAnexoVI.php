<?php
    session_start();
    include('conexion.php');

    // Obtener el ID de la salida desde la sesión
    $idSalida = $_SESSION['idSalida'];
    $dniAlumno = $_SESSION['dniAlumno'];

    // Consultar los datos del Anexo VI basados en el idSalida y dniAlumno
    $sql = "SELECT domicilio, altura, localidad FROM anexovi WHERE fkAnexoIV = '$idSalida' AND dniAlumno = '$dniAlumno'";
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
            <div class="form-group">
                <div class="form-group">
                    <label class="form-label labels6" for="domicilio">Domicilio:</label>
                    <input type="text" class="form-control item" id="domicilio" value="'.$domicilio.'">
                </div>
                <div class="form-group">
                    <label class="form-label labels6" for="altura">Altura:</label>
                    <input type="text" class="form-control item" id="altura" value="'.$altura.'">
                </div>
                <div class="form-group">
                    <label class="form-label labels6" for="localidad">Localidad:</label>
                    <input type="text" class="form-control item" id="localidad" value="'.$localidad.'">
                </div>
            </div>
        ';
    } else {
        echo '
            <div class="form-group">
                <div class="form-group">
                    <label class="form-label labels6" for="domicilio">Domicilio:</label>
                    <input type="text" class="form-control item" id="domicilio" placeholder="Ingrese su domicilio...">
                </div>
                <div class="form-group">
                    <label class="form-label labels6" for="altura">Altura:</label>
                    <input type="text" class="form-control item" id="altura" placeholder="Ingrese la altura de su domicilio...">
                </div>
                <div class="form-group">
                    <label class="form-label labels6" for="localidad">Localidad:</label>
                    <input type="text" class="form-control item" id="localidad" placeholder="Ingrese su localidad...">
                </div>
            </div>
        ';
    }
    mysqli_close($conexion);
?>
