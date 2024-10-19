<?php
    $idSalida = $_SESSION['idSalida'] ?? null;
    include('conexion.php');

    if (isset($idSalida)) {
        $sql = "SELECT * FROM anexoix WHERE fkAnexoIV = ?";
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
                    <label for="razonSocial" class="form-label">Razón Social:</label>
                    <input type="text" class="form-control item" id="razonSocial" name="razonSocial" placeholder="Ingrese la razón social..." value="'.htmlspecialchars($row['razonSocial'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="domicilioTransporte" class="form-label">Domicilio del transporte:</label>
                    <input type="text" class="form-control item" id="domicilioTransporte" name="domicilioTransporte" placeholder="Ingrese el domicilio del transporte..." value="'.htmlspecialchars($row['domicilioTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="telefonoTransporte" class="form-label">Teléfono del transporte:</label>
                    <input type="text" class="form-control item" id="telefonoTransporte" name="telefonoTransporte" placeholder="Ingrese el número" value="'.htmlspecialchars($row['telefonoTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                    <p style="margin-top: 5px; margin-left: 2px;">Nota: El telefono no debe contener ceros delante, tampoco guiones. Dígitos máximos permitidos: 13.</p>    
                </div>

                <div class="form-group">
                    <label for="domicilioResponsable" class="form-label">Domicilio del responsable:</label>
                    <input type="text" class="form-control item" id="domicilioResponsable" name="domicilioResponsable" placeholder="Ingrese el domicilio del responsable..." value="'.htmlspecialchars($row['domicilioResponsable'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="telefonoResponsable" class="form-label">Teléfono del responsable:</label>
                    <input type="text" class="form-control item" id="telefonoResponsable" name="telefonoResponsable" placeholder="Ingrese el teléfono" value="'.htmlspecialchars($row['telefono'], ENT_QUOTES, 'UTF-8').'" required>
                    <p style="margin-top: 5px; margin-left: 2px;">Nota: El telefono no debe contener ceros delante, tampoco guiones. Dígitos máximos permitidos: 13.</p>    
                </div>

                <div class="form-group">
                    <label for="titularidadVehiculo" class="form-label">Titularidad del vehículo:</label>
                    <input type="text" class="form-control item" id="titularidadVehiculo" name="titularidadVehiculo" placeholder="Ingrese la titularidad del vehículo..." value="'.htmlspecialchars($row['titularidadVehiculo'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="companiaAseguradora" class="form-label">Compañía aseguradora:</label>
                    <input type="text" class="form-control item" id="companiaAseguradora" name="companiaAseguradora" placeholder="Ingrese la compañía aseguradora..." value="'.htmlspecialchars($row['companiaAseguradora'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="numeroPoliza" class="form-label">Número de póliza:</label>
                    <input type="text" class="form-control item" id="numeroPoliza" name="numeroPoliza" placeholder="Ingrese el número de póliza..." value="'.htmlspecialchars($row['numeroPoliza'], ENT_QUOTES, 'UTF-8').'" pattern="\d{1,15}" title="El número de póliza debe contener solo dígitos y no debe exceder los 15 dígitos." required>
                </div>

                <div class="form-group">
                    <label for="tipoSeguro" class="form-label">Tipo de seguro:</label>
                    <input type="text" class="form-control item" id="tipoSeguro" name="tipoSeguro" placeholder="Ingrese el tipo de seguro..." value="'.htmlspecialchars($row['tipoSeguro'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="nombreConductor1" class="form-label">Nombre del Conductor 1:</label>
                    <input type="text" class="form-control item" id="nombreConductor1" name="nombreConductor1" placeholder="Ingrese el nombre del conductor 1..." value="'.htmlspecialchars($row['nombreConductor1'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="dniConductor1" class="form-label">DNI del Conductor 1:</label>
                    <input type="text" class="form-control item" id="dniConductor1" name="dniConductor1" placeholder="Ingrese el DNI del conductor 1..." value="'.htmlspecialchars($row['dniConductor1'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="licenciaConductor1" class="form-label">Licencia del Conductor 1:</label>
                    <input type="text" class="form-control item" id="licenciaConductor1" name="licenciaConductor1" placeholder="Ingrese la licencia del conductor 1..." value="'.htmlspecialchars($row['numeroLicencia1'], ENT_QUOTES, 'UTF-8').'" required>
                    <p style="margin-top: 5px; margin-left: 2px;">Nota: La licencia debe coincidir con el DNI.</p>    
                </div>

                <div class="form-group">
                    <label for="vigenciaConductor1" class="form-label">Vigencia del Conductor 1:</label>
                    <input type="date" class="form-control item" id="vigenciaConductor1" name="vigenciaConductor1" placeholder="Ingrese la vigencia de la licencia del conductor 1..." value="'.htmlspecialchars($row['vigencia1'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <span class="fw-bold">Atención:</span><span> La carga del Conductor 2 es opcional, al no cargar los datos figurará en el PDF como "-". Si usted completa un campo, deberá completar los demás.</span><br><br>
                <div class="form-group">
                    <label for="nombreConductor2" id="nc2l" class="form-label">Nombre del Conductor 2:</label>
                    <input type="text" class="form-control item" id="nombreConductor2" name="nombreConductor2" placeholder="Ingrese el nombre del conductor 2..." value="'.htmlspecialchars($nombreConductor2, ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="dniConductor2" id="dc2l" class="form-label">DNI del Conductor 2:</label>
                    <input type="text" class="form-control item" id="dniConductor2" name="dniConductor2" placeholder="Ingrese el DNI del conductor 2..." value="'.htmlspecialchars($dniConductor2, ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="form-group">
                    <label for="licenciaConductor2" id="lc2l" class="form-label">Licencia del Conductor 2:</label>
                    <input type="text" class="form-control item" id="licenciaConductor2" name="licenciaConductor2" placeholder="Ingrese la licencia del conductor 2..." value="'.htmlspecialchars($licenciaConductor2, ENT_QUOTES, 'UTF-8').'" required>
                    <p style="margin-top: 5px; margin-left: 2px;">Nota: La licencia debe coincidir con el DNI.</p>    
                </div>

                <div class="form-group">
                    <label for="vigenciaConductor2" id="vc2l" class="form-label">Vigencia del Conductor 2:</label>
                    <input type="date" class="form-control item" id="vigenciaConductor2" name="vigenciaConductor2" placeholder="Ingrese la vigencia de la licencia del conductor 2..." value="'.htmlspecialchars($vigenciaConductor2, ENT_QUOTES, 'UTF-8').'" required>
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
