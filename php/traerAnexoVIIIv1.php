<?php
    $idSalida = $_SESSION['idSalida'] ?? null;
    include('conexion.php');

    if (isset($idSalida)) {
        $sql = "SELECT * FROM anexoviii WHERE fkAnexoIV = ?";
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

            $nombreConductor2 = $row['nombreConductor2'];
            $dniConductor2 = $row['dniConductor2'];
            $licenciaConductor2 = $row['numeroLicencia2'];
            $vigenciaConductor2 = $row['vigencia2'];

            // Verificar las condiciones para mostrar los inputs vacíos
            if ($nombreConductor2 === "-" && $dniConductor2 === "-" && $licenciaConductor2 === "-" && $vigenciaConductor2 === "0000-00-00") {
                // Dejar los campos vacíos
                $nombreConductor2 = '';
                $dniConductor2 = '';
                $licenciaConductor2 = '';
                $vigenciaConductor2 = '';
            }

            echo '
                <div class="form-group">
                    <label for="razonSocial" class="form-label">Nombre de la empresa o razón social:</label>
                    <input type="text" class="form-control item" id="razonSocial" name="razonSocial" placeholder="Ingrese la razón social..." value="'.htmlspecialchars($row['razonSocial'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="domicilioTransporte" class="form-label">Nombre del gerente o responsable:</label>
                    <input type="text" class="form-control item" id="domicilioTransporte" name="domicilioTransporte" placeholder="Ingrese el domicilio del transporte..." value="'.htmlspecialchars($row['domicilioTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="domicilioTransporte" class="form-label">Domicilio del propietario o la empresa:</label>
                    <input type="text" class="form-control item" id="domicilioTransporte" name="domicilioTransporte" placeholder="Ingrese el domicilio del transporte..." value="'.htmlspecialchars($row['domicilioTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="telefonoTransporte" class="form-label">Teléfono del propietario o la empresa:</label>
                    <input type="text" class="form-control item" id="telefonoTransporte" name="telefonoTransporte" placeholder="Ingrese el número..." value="'.htmlspecialchars($row['telefonoTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                    <p style="margin-left: 2px;">Nota: El telefono no debe contener ceros delante, tampoco guiones. Dígitos máximos permitidos: 13.</p>    
                </div>

                <div class="form-group">
                    <label for="domicilioTransporte" class="form-label">Domicilio del gerente o responsable:</label>
                    <input type="text" class="form-control item" id="domicilioTransporte" name="domicilioTransporte" placeholder="Ingrese el domicilio del transporte..." value="'.htmlspecialchars($row['domicilioTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="telefonoTransporte" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control item" id="telefonoTransporte" name="telefonoTransporte" placeholder="Ingrese el número..." value="'.htmlspecialchars($row['telefonoTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="telefonoTransporte" class="form-label">Teléfono móvil:</label>
                    <input type="text" class="form-control item" id="telefonoTransporte" name="telefonoTransporte" placeholder="Ingrese el número..." value="'.htmlspecialchars($row['telefonoTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="titularidadVehiculo" class="form-label">Titularidad del vehículo:</label>
                    <input type="text" class="form-control item" id="titularidadVehiculo" name="titularidadVehiculo" placeholder="Ingrese la titularidad del vehículo..." value="'.htmlspecialchars($row['titularidadVehiculo'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="wrapper">
                    <div class="title">Números de registro:</div>
                    <div class="box">
                        <div id="telefonosDiv" style="display: flex; gap: 10px; align-items: center;">
                            <input class="form-control item" type="text" id="telefono" placeholder="Ingrese un número de teléfono...">
                            <button type="button" class="cargar" id="agregarTelefono">Agregar</button>
                        </div>
                        <input type="hidden" id="telefonosOculto" name="telefonos">
                        <div id="listaTelefonos" class="listaTelefonos">
                        </div>
                    </div>
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
