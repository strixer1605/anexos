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

            if ($nombreConductor2 === "-" && $dniConductor2 === "-" && $licenciaConductor2 === "-" && $vigenciaConductor2 === "0000-00-00") {
                $nombreConductor2 = '';
                $dniConductor2 = '';
                $licenciaConductor2 = '';
                $vigenciaConductor2 = '';
            }

            echo '
                <div class="form-group">
                    <label for="nombreEmpresa" class="form-label">Nombre de la empresa o razón social:</label>
                    <input type="text" class="form-control item" id="nombreEmpresa" name="nombreEmpresa" placeholder="Ingrese el nombre de la empresa..." value="'.htmlspecialchars($row['razonSocial'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="nombreGerente" class="form-label">Nombre del gerente o responsable:</label>
                    <input type="text" class="form-control item" id="nombreGerente" name="nombreGerente" placeholder="Ingrese el nombre del responsable de la empresa..." value="'.htmlspecialchars($row['domicilioTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="domicilioEmpresa" class="form-label">Domicilio del propietario o la empresa:</label>
                    <input type="text" class="form-control item" id="domicilioEmpresa" name="domicilioEmpresa" placeholder="Ingrese el domicilio de la empresa..." value="'.htmlspecialchars($row['domicilioTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="telefonoEmpresa" class="form-label">Teléfono del propietario o la empresa:</label>
                    <input type="text" class="form-control item" id="telefonoEmpresa" name="telefonoEmpresa" placeholder="Ingrese el número..." value="'.htmlspecialchars($row['telefonoTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                    <p style="margin-left: 2px;">Nota: El telefono no debe contener ceros delante, tampoco guiones. Dígitos máximos permitidos: 13.</p>    
                </div>

                <div class="form-group">
                    <label for="domicilioGerente" class="form-label">Domicilio del gerente o responsable:</label>
                    <input type="text" class="form-control item" id="domicilioGerente" name="domicilioGerente" placeholder="Ingrese el domicilio del responsable..." value="'.htmlspecialchars($row['domicilioTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="number" class="form-control item" id="telefono" name="telefono" placeholder="Ingrese el número..." value="'.htmlspecialchars($row['telefonoTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="telefonoMovil" class="form-label">Teléfono móvil:</label>
                    <input type="number" class="form-control item" id="telefonoMovil" name="telefonoMovil" placeholder="Ingrese el número..." value="'.htmlspecialchars($row['telefonoTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="titularidadVehiculo" class="form-label">Titularidad del vehículo:</label>
                    <input type="text" class="form-control item" id="titularidadVehiculo" name="titularidadVehiculo" placeholder="Ingrese la titularidad del vehículo..." value="'.htmlspecialchars($row['titularidadVehiculo'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="aseguradora" class="form-label">Compañía aseguradora:</label>
                    <input type="text" class="form-control item" id="aseguradora" name="aseguradora" placeholder="Ingrese la compañía aseguradora..." value="'.htmlspecialchars($row['telefonoTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="cantidadVehiculos" class="form-label">Seleccione la cantidad de vehiculos:</label>
                    <select id="cantidadVehiculos" class="form-control item" onchange="generarVehiculos()">
                        <option value="0" disabled selected>Seleccione la cantidad...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>

                <div id="vehiculosContainer"></div>

                <div class="form-group">
                    <label for="cantidadConductores" class="form-label">Seleccione la cantidad de conductores:</label>
                    <select id="cantidadConductores" class="form-control item" onchange="generarConductores()">
                        <option value="0" disabled selected>Seleccione la cantidad...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>

                <div id="conductoresContainer"></div>

                <input type="hidden" id="numeroRegistroArray" name="numeroRegistroArray">
                <input type="hidden" id="fechaHabilitacionArray" name="fechaHabilitacionArray">
                <input type="hidden" id="tipoHabilitacionArray" name="tipoHabilitacionArray">
                <input type="hidden" id="cantidadAsientosArray" name="cantidadAsientosArray">
                <input type="hidden" id="vigenciaVTVArray" name="vigenciaVTVArray">
                <input type="hidden" id="polizaArray" name="polizaArray">
                <input type="hidden" id="tipoSeguroArray" name="tipoSeguroArray">
                
                <input type="hidden" id="nombresConductoresArray" name="nombresConductoresArray">
                <input type="hidden" id="dnisConductoresArray" name="dnisConductoresArray">
                <input type="hidden" id="carnetConductoresArray" name="carnetConductoresArray">
                <input type="hidden" id="vigenciaConductoresArray" name="vigenciaConductoresArray">
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
