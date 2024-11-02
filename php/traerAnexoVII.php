<?php
    include('conexion.php');

    // Obtener el ID de la salida desde la sesión
    $idSalida = $_SESSION['idSalida'];
    $dniEstudiante = $_SESSION['dniEstudiante'];

    // Consultar los datos del Anexo VI basados en el idSalida y dniEstudiante
    $sql = "SELECT * FROM anexovii WHERE fkAnexoIV = '$idSalida' AND dniEstudiante = '$dniEstudiante'";
    $resultado = mysqli_query($conexion, $sql);

    // Si hay resultados, asignar los valores a las variables
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        // Mostrar el formulario (Bloque If)
        echo '
        <div class="form-group">
            <div class="form-group">
                <label class="form-label labels6" for="domicilio">Domicilio:</label>
                <input type="text" class="form-control item" id="domicilio" value="'.$fila['domicilio'].'">
            </div>
            <div class="form-group">
                <label class="form-label labels6" for="altura">Altura:</label>
                <input type="number" class="form-control item" id="altura" value="'.$fila['altura'].'">
            </div>
            <div class="form-group">
                <label class="form-label labels6" for="localidad">Localidad:</label>
                <input type="text" class="form-control item" id="localidad" value="'.$fila['localidad'].'">
            </div>
        </div>
        <div class="wrapper">
            <div class="title">Observaciones</div>
            <div class="box">
                <h6>Deje constancia de cualquier indicación que estime necesario deba conocer el personal docente a cargo y personal médico:</h6>
                <textarea class="form-control item" id="observaciones" name="observaciones" rows="3">' . $fila['observaciones'] . '</textarea>
            </div>
        </div>
        
        <br>
        <div class="wrapper">
            <div class="title">¿Tiene obra social?</div>
            <div class="box">
                <input type="radio" id="obraSocialSi" ' . ($fila['obraSocial'] ? 'checked' : '') . ' name="obraSocial" value="si">
                <input type="radio" id="obraSocialNo" ' . ($fila['obraSocial'] ? '' : 'checked') . ' name="obraSocial" value="no">

                <label for="obraSocialSi" class="obraSocialSi">
                    <div class="dot"></div>
                    <div class="text">Si</div>
                </label>

                <label for="obraSocialNo" class="obraSocialNo">
                    <div class="dot"></div>
                    <div class="text">No</div>
                </label>

                <div id="obraSocialNombreDiv" style="display:none;">
                    <label class="form-label" for="nombreObraSocial">Ingrese el nombre de su obra social:</label>
                    <input type="text" class="form-control item" id="nombreObraSocial" value="' . $fila['nombreObraSocial'] . '" name="nombreObraSocial">
                </div>

                <div id="obraSocialNumeroDiv" style="display:none;">
                    <label class="form-label" for="numeroAfiliado">Ingrese su número de afiliado:</label>
                    <input type="text" class="form-control item" id="numeroAfiliado" value="' . $fila['numeroAfiliado'] . '" name="numeroAfiliado">
                </div>

                <div id="obraSocialMensaje" style="display:none;">
                    <p>En caso de respuesta positiva deberá acompañar la presente planilla con carnet o copia del carnet.</p>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="title">Teléfonos de contacto:</div>
            <div class="box">
            <h6>(Consignar varios)</h6>

                <div id="telefonosDiv">
                    <label class="form-label" for="telefono">Número de teléfono:</label>
                    <input class="form-control item" type="text" id="telefono" placeholder="Ingrese un número de teléfono">
                    <button type="button" class="cargar" id="agregarTelefono">Agregar</button>
                </div>
                
                <input type="hidden" id="telefonosOculto" name="telefonos" value="'.$fila['telefonos'].'">

                <div id="listaTelefonos" class="listaTelefonos">';
                    // Verificar si hay teléfonos en la variable y separarlos
                    $telefonos = !empty($fila['telefonos']) ? explode(',', $fila['telefonos']) : [];
                    foreach ($telefonos as $index => $telefono) {
                        $telefono = trim($telefono); // Quitar espacios en blanco
                        if (!empty($telefono)) { // Verificar que el teléfono no esté vacío
                            echo '<div class="telefono-container">
                                    <label class="telefono-label">' . htmlspecialchars($telefono) . '</label>
                                    <span class="telefono-button">
                                        <button class="btn btn-danger" onclick="eliminarTelefono(' . $index . ')">Eliminar</button>
                                    </span>
                                </div>';
                        }
                    }
                    echo '
                </div>
            </div>
        </div>
        ';

    } else {
        // Mostrar el formulario (Bloque Else actualizado)
        echo '
        <div class="form-group">
            <div class="form-group">
                <label class="form-label labels6" for="domicilio">Domicilio:</label>
                <input type="text" class="form-control item" id="domicilio" placeholder="Ingrese su domicilio...">
            </div>
            <div class="form-group">
                <label class="form-label labels6" for="altura">Altura:</label>
                <input type="number" class="form-control item" id="altura" placeholder="Ingrese la altura de su domicilio...">
            </div>
            <div class="form-group">
                <label class="form-label labels6" for="localidad">Localidad:</label>
                <input type="text" class="form-control item" id="localidad" placeholder="Ingrese su localidad...">
            </div>
        </div>
        <div class="wrapper">
            <div class="title">Observaciones</div>
            <div class="box">
                <h6>Deje constancia de cualquier indicación que estime necesario deba conocer el personal docente a cargo y personal médico:</h6>
                <textarea class="form-control item" id="observaciones" name="observaciones" rows="3"></textarea>
            </div>
        </div>
        
        <br>
        <div class="wrapper">
            <div class="title">¿Tiene obra social?</div>
            <div class="box">
                <input type="radio" id="obraSocialSi" name="obraSocial" value="si">
                <input type="radio" id="obraSocialNo" name="obraSocial" value="no">

                <label for="obraSocialSi" class="obraSocialSi">
                    <div class="dot"></div>
                    <div class="text">Si</div>
                </label>

                <label for="obraSocialNo" class="obraSocialNo">
                    <div class="dot"></div>
                    <div class="text">No</div>
                </label>

                <div id="obraSocialNombreDiv" style="display:none;">
                    <label class="form-label" for="nombreObraSocial">Ingrese el nombre de su obra social:</label>
                    <input type="text" class="form-control item" id="nombreObraSocial" name="nombreObraSocial">
                </div>

                <div id="obraSocialNumeroDiv" style="display:none;">
                    <label class="form-label" for="numeroAfiliado">Ingrese su número de afiliado:</label>
                    <input type="text" class="form-control item" id="numeroAfiliado" name="numeroAfiliado">
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="title">Teléfonos de contacto:</div>
            <div class="box">
            <h6>(Consignar varios)</h6>

                <div id="telefonosDiv">
                    <label class="form-label" for="telefono">Número de teléfono:</label>
                    <input class="form-control item" type="text" id="telefono" placeholder="Ingrese un número de teléfono">
                    <button type="button" class="cargar" id="agregarTelefono">Agregar</button>
                </div>
                
                <input type="hidden" id="telefonosOculto" name="telefonos">

                <div id="listaTelefonos"></div>
            </div>
        </div>
        ';
    }
    mysqli_close($conexion);
?>
