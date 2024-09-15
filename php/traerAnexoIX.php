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

            echo '
                <div class="mb-5">
                    <label for="razonSocial" class="form-label">Razon Social:</label>
                    <input type="text" class="form-control" id="razonSocial" name="razonSocial" placeholder="Ingrese la razón social" value="'.htmlspecialchars($row['razonSocial'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="domicilioTransporte" class="form-label">Domicilio del transporte:</label>
                    <input type="text" class="form-control" id="domicilioTransporte" name="domicilioTransporte" placeholder="Ingrese el domicilio del transporte" value="'.htmlspecialchars($row['domicilioTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="telefonoTransporte" class="form-label">Teléfono del transporte:</label>
                    <input type="number" class="form-control" id="telefonoTransporte" name="telefonoTransporte" placeholder="Ingrese el número" value="'.htmlspecialchars($row['telefonoTransporte'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="domicilioResponsable" class="form-label">Domicilio del responsable:</label>
                    <input type="text" class="form-control" id="domicilioResponsable" name="domicilioResponsable" placeholder="Ingrese el domicilio del responsable" value="'.htmlspecialchars($row['domicilioResponsable'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="telefonoResponsable" class="form-label">Teléfono:</label>
                    <input type="number" class="form-control" id="telefonoResponsable" name="telefonoResponsable" placeholder="Ingrese el teléfono" value="'.htmlspecialchars($row['telefono'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="telefonoMovil" class="form-label">Teléfono Movil:</label>
                    <input type="number" class="form-control" id="telefonoMovil" name="telefonoMovil" placeholder="Ingrese el teléfono móvil" value="'.htmlspecialchars($row['telefonoMovil'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="titularidadVehiculo" class="form-label">Titularidad del vehículo:</label>
                    <input type="text" class="form-control" id="titularidadVehiculo" name="titularidadVehiculo" placeholder="Ingrese la titularidad del vehículo" value="'.htmlspecialchars($row['titularidadVehiculo'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="companiaAseguradora" class="form-label">Compañía aseguradora:</label>
                    <input type="text" class="form-control" id="companiaAseguradora" name="companiaAseguradora" placeholder="Ingrese la compañía aseguradora" value="'.htmlspecialchars($row['companiaAseguradora'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="numeroPoliza" class="form-label">Número de póliza:</label>
                    <input type="number" class="form-control" id="numeroPoliza" name="numeroPoliza" placeholder="Ingrese el número de póliza" value="'.htmlspecialchars($row['numeroPoliza'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="tipoSeguro" class="form-label">Tipo de seguro:</label>
                    <input type="text" class="form-control" id="tipoSeguro" name="tipoSeguro" placeholder="Ingrese el tipo de seguro" value="'.htmlspecialchars($row['tipoSeguro'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="nombreConductor1" class="form-label">Nombre del Conductor 1:</label>
                    <input type="text" class="form-control" id="nombreConductor1" name="nombreConductor1" placeholder="Ingrese el nombre del conductor 1" value="'.htmlspecialchars($row['nombreConductor1'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="dniConductor1" class="form-label">DNI del Conductor 1:</label>
                    <input type="number" class="form-control" id="dniConductor1" name="dniConductor1" placeholder="Ingrese el DNI del conductor 1" value="'.htmlspecialchars($row['dniConductor1'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="licenciaConductor1" class="form-label">Licencia del Conductor 1:</label>
                    <input type="number" class="form-control" id="licenciaConductor1" name="licenciaConductor1" placeholder="Ingrese la licencia del conductor 1" value="'.htmlspecialchars($row['numeroLicencia1'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="vigenciaConductor1" class="form-label">Vigencia del Conductor 1:</label>
                    <input type="number" class="form-control" id="vigenciaConductor1" name="vigenciaConductor1" placeholder="Ingrese la vigencia de la licencia del conductor 1" value="'.htmlspecialchars($row['vigencia1'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="nombreConductor2" class="form-label">Nombre del Conductor 2:</label>
                    <input type="text" class="form-control" id="nombreConductor2" name="nombreConductor2" placeholder="Ingrese el nombre del conductor 2" value="'.htmlspecialchars($row['nombreConductor2'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="dniConductor2" class="form-label">DNI del Conductor 2:</label>
                    <input type="number" class="form-control" id="dniConductor2" name="dniConductor2" placeholder="Ingrese el DNI del conductor 2" value="'.htmlspecialchars($row['dniConductor2'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="licenciaConductor2" class="form-label">Licencia del Conductor 2:</label>
                    <input type="number" class="form-control" id="licenciaConductor2" name="licenciaConductor2" placeholder="Ingrese la licencia del conductor 2" value="'.htmlspecialchars($row['numeroLicencia2'], ENT_QUOTES, 'UTF-8').'" required>
                </div>

                <div class="mb-5">
                    <label for="vigenciaConductor2" class="form-label">Vigencia del Conductor 2:</label>
                    <input type="number" class="form-control" id="vigenciaConductor2" name="vigenciaConductor2" placeholder="Ingrese la vigencia de la licencia del conductor 2" value="'.htmlspecialchars($row['vigencia2'], ENT_QUOTES, 'UTF-8').'" required>
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
