<?php
$idSalida = $_SESSION['idSalida'] ?? null;
include('conexion.php');

if (isset($idSalida)) {
    $sql = "SELECT * FROM anexox WHERE fkAnexoIV = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt === false) {
        error_log('Error preparando la consulta: ' . $conexion->error);
        die('Error interno del servidor.');
    }

    $stmt->bind_param('i', $idSalida);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } 

        echo '
            <div class="form-group">
                <label for="localidadEmpresa" class="form-label">Localidad de la Empresa:</label>
                <input type="text" class="form-control item" id="localidadEmpresa" name="localidadEmpresa" placeholder="Ingrese la localidad de la Empresa..." value="'.htmlspecialchars($row['localidadEmpresa'], ENT_QUOTES, 'UTF-8').'">
            </div>
            <div class="form-group">
                <label for="hospitales" class="form-label">Hospital/es disponibles:</label>
                <input type="text" class="form-control item" id="hospitales" name="hospitales" placeholder="Ingrese los hospital/es disponibles..." value="'.htmlspecialchars($row['hospitales'], ENT_QUOTES, 'UTF-8').'">
            </div>
            <div class="form-group">
                <label for="hospitalesTelefono" class="form-label">Teléfono de los hospital/es:</label>
                <input type="number" class="form-control item" id="hospitalesTelefono" name="hospitalesTelefono" placeholder="Teléfono..." value="'.htmlspecialchars($row['hospitalesTelefono'], ENT_QUOTES, 'UTF-8').'">
            </div>
            <div class="form-group">
                <label for="hospitalesDireccion" class="form-label">Dirección de los hospital/es:</label>
                <input type="text" class="form-control item" id="hospitalesDireccion" name="hospitalesDireccion" placeholder="Dirección..." value="'.htmlspecialchars($row['hospitalesDireccion'], ENT_QUOTES, 'UTF-8').'">
            </div>
            <div class="form-group">
                <label for="hospitalesLocalidad" class="form-label">Localidad de los hospital/es:</label>
                <input type="text" class="form-control item" id="hospitalesLocalidad" name="hospitalesLocalidad" placeholder="Localidad..." value="'.htmlspecialchars($row['hospitalesLocalidad'], ENT_QUOTES, 'UTF-8').'">
            </div>
            <div class="form-group" style="margin-bottom:25px;">
                <label for="datosInteres" class="form-label">Infraestructura disponible:</label>
                <input type="text" style="margin-bottom: 0;" class="form-control item" id="datosInteres" name="datosInteres" placeholder="Ingrese datos de interés..." value="'.htmlspecialchars($row['datosInteresNombre'], ENT_QUOTES, 'UTF-8').'"><br>
            <span class="fw-bold">Atención:</span><span> Sí carga datos de infraestructura, los campos relacionados a esta pasaran a ser obligatorios.</span>
            </div>
            <div class="form-group">
                <label for="datosInteresTelefono" class="form-label">Teléfono de los datos opcionales:</label>
                <input type="number" class="form-control item" id="datosInteresTelefono" name="datosInteresTelefono" placeholder="Teléfono..." value="'.htmlspecialchars($row['datosInteresTelefono'], ENT_QUOTES, 'UTF-8').'">
            </div>
            <div class="form-group">
                <label for="datosInteresDireccion" class="form-label">Dirección de los datos opcionales:</label>
                <input type="text" class="form-control item" id="datosInteresDireccion" name="datosInteresDireccion" placeholder="Dirección..." value="'.htmlspecialchars($row['datosInteresDireccion'], ENT_QUOTES, 'UTF-8').'">
            </div>
            <div class="form-group">
                <label for="datosInteresLocalidad" class="form-label">Localidad de los datos opcionales:</label>
                <input type="text" class="form-control item" id="datosInteresLocalidad" name="datosInteresLocalidad" placeholder="Localidad..." value="'.htmlspecialchars($row['datosInteresLocalidad'], ENT_QUOTES, 'UTF-8').'">
            </div>
        ';
    } else {
        error_log('Error al ejecutar la consulta: ' . $stmt->error);
        die('Error interno del servidor.');
    }

    $stmt->close();
    $conexion->close();
} else {
    die('Error: idSalida no está definido.');
}
?>
