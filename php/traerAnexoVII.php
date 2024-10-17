<?php
    session_start();
    include('conexion.php');

    // Obtener el ID de la salida desde la sesión
    $idSalida = $_SESSION['idSalida'];
    $dniAlumno = $_SESSION['dniAlumno'];

    // Consultar los datos del Anexo VI basados en el idSalida y dniAlumno
    $sql = "SELECT * FROM anexovii WHERE fkAnexoIV = '$idSalida' AND dniAlumno = '$dniAlumno'";
    $resultado = mysqli_query($conexion, $sql);

    // Si hay resultados, asignar los valores a las variables
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        // Mostrar el formulario (Bloque If)
        echo '
        <div class="wrapper">
            <div class="title">¿Es alérgico?</div>
            <div class="box">
                <input type="radio" id="alergicoSi" name="alergico" value="si" ' . ($fila['alergico'] ? 'checked' : '') . ' onclick="toggleAlergiaInput(true)">
                <input type="radio" id="alergicoNo" name="alergico" value="no" ' . ($fila['alergico'] ? '' : 'checked') . ' onclick="toggleAlergiaInput(false)">

                <label for="alergicoSi" class="alergicoSi">
                    <div class="dot"></div>
                    <div class="text">Si</div>
                </label>

                <label for="alergicoNo" class="alergicoNo">
                    <div class="dot"></div>
                    <div class="text">No</div>
                </label>

                <div id="alergiaInput" style="display:none;" class="form-group">
                    <label class="form-label" for="aQue">¿A qué es alérgico?</label>
                    <input type="text" value="' . $fila['tipoAlergia'] . '" class="form-control item" id="aQue" name="aQue">
                </div>
            </div>
        </div>

        <br>
        <div class="wrapper">
            <div class="title">¿Ha sufrido en los últimos 30 días?</div>
            <div class="box">
                <input type="checkbox" name="problemas[]" value="inflamatorios" id="inflamatorios" ' . ($fila['sufrioA'] ? 'checked' : '') . '>
                <input type="checkbox" name="problemas[]" value="fracturas" id="fracturas" ' . ($fila['sufrioB'] ? 'checked' : '') . '>
                <input type="checkbox" name="problemas[]" value="enfermedades" id="enfermedades" ' . ($fila['sufrioC'] ? 'checked' : '') . '>
                <input type="checkbox" name="problemas[]" value="otras" id="otras" ' . ($fila['otroMalestar'] ? 'checked' : '') . ' onclick="toggleOtrasInput()">

                <label for="inflamatorios" class="inflamatorios">
                    <div class="dot"></div>
                    <div class="text">a. Inflamaciones</div>
                </label>

                <label for="fracturas" class="fracturas">
                    <div class="dot"></div>
                    <div class="text">b. Fracturas</div>
                </label>

                <label for="enfermedades" class="enfermedades">
                    <div class="dot"></div>
                    <div class="text">c. Enfermedades</div>
                </label>

                <label for="otras" class="otras">
                    <div class="dot"></div>
                    <div class="text">d. Otras:</div>
                </label>
                <input type="text" class="form-control item" id="otrasInput" name="otrasInput" value="' . $fila['otroMalestar'] . '" style="display:none;">
            </div>
        </div>

        <br>
        <div class="wrapper">
            <div class="title">¿Está tomando alguna medicación?</div>
            <div class="box">
                <input type="radio" id="medicacionSi" ' . ($fila['medicacion'] ? 'checked' : '') . ' name="medicacion" value="si" onclick="toggleMedicacionInput(true)">
                <input type="radio" id="medicacionNo" ' . ($fila['medicacion'] ? '' : 'checked') . ' name="medicacion" value="no" onclick="toggleMedicacionInput(false)">

                <label for="medicacionSi" class="medicacionSi">
                    <div class="dot"></div>
                    <div class="text">Si</div>
                </label>

                <label for="medicacionNo" class="medicacionNo">
                    <div class="dot"></div>
                    <div class="text">No</div>
                </label>

                <div id="medicacionInput" style="display:none;">
                    <label class="form-label" for="medicacionDetalles">¿Qué medicación?</label>
                    <input type="text" class="form-control item" id="medicacionDetalles" value="' . $fila['tipoMedicacion'] . '" name="medicacionDetalles">
                </div>
            </div>
        </div>

        <br>

        <div class="wrapper">
            <div class="title">Observaciones</div>
            <div class="box">
                <h6>Deje constancia de cualquier indicación que estime necesario deba conocer el personal médico y docente a cargo:</h6>
                <textarea class="form-control item" id="indicaciones" name="indicaciones" rows="3">' . $fila['observaciones'] . '</textarea>
            </div>
        </div>
        
        <br>
        <div class="wrapper">
            <div class="title">¿Tiene obra social?</div>
            <div class="box">
                <input type="radio" id="obraSocialSi" ' . ($fila['obraSocial'] ? 'checked' : '') . ' name="obraSocial" value="si" onclick="toggleObraSocialMensaje(true)">
                <input type="radio" id="obraSocialNo" ' . ($fila['obraSocial'] ? '' : 'checked') . ' name="obraSocial" value="no" onclick="toggleObraSocialMensaje(false)">

                <label for="obraSocialSi" class="obraSocialSi">
                    <div class="dot"></div>
                    <div class="text">Si</div>
                </label>

                <label for="obraSocialNo" class="obraSocialNo">
                    <div class="dot"></div>
                    <div class="text">No</div>
                </label>

                <div id="obraSocialMensaje" style="display:none;">
                    <p>En caso de respuesta positiva deberá acompañar la presente planilla con carnet o copia del carnet.</p>
                </div>
            </div>
        </div>
        ';

    } else {
        // Mostrar el formulario (Bloque Else actualizado)
        echo '
        <div class="wrapper">
            <div class="title">¿Es alérgico?</div>
            <div class="box">
                <input type="radio" id="alergicoSi" name="alergico" value="si" onclick="toggleAlergiaInput(true)">
                <input type="radio" id="alergicoNo" name="alergico" value="no" onclick="toggleAlergiaInput(false)">

                <label for="alergicoSi" class="alergicoSi">
                    <div class="dot"></div>
                    <div class="text">Si</div>
                </label>

                <label for="alergicoNo" class="alergicoNo">
                    <div class="dot"></div>
                    <div class="text">No</div>
                </label>

                <div id="alergiaInput" style="display:none;" class="form-group">
                    <label class="form-label" for="aQue">¿A qué es alérgico?</label>
                    <input type="text" class="form-control item" id="aQue" name="aQue">
                </div>
            </div>
        </div>

        <br>
        <div class="wrapper">
            <div class="title">¿Ha sufrido en los últimos 30 días?</div>
            <div class="box">
                <input type="checkbox" name="problemas[]" value="inflamatorios" id="inflamatorios">
                <input type="checkbox" name="problemas[]" value="fracturas" id="fracturas">
                <input type="checkbox" name="problemas[]" value="enfermedades" id="enfermedades">
                <input type="checkbox" name="problemas[]" value="otras" id="otras" onclick="toggleOtrasInput()">

                <label for="inflamatorios" class="inflamatorios">
                    <div class="dot"></div>
                    <div class="text">a. Inflamaciones</div>
                </label>

                <label for="fracturas" class="fracturas">
                    <div class="dot"></div>
                    <div class="text">b. Fracturas</div>
                </label>

                <label for="enfermedades" class="enfermedades">
                    <div class="dot"></div>
                    <div class="text">c. Enfermedades</div>
                </label>

                <label for="otras" class="otras">
                    <div class="dot"></div>
                    <div class="text">d. Otras:</div>
                </label>
                <input type="text" class="form-control item" id="otrasInput" name="otrasInput" style="display:none;">
            </div>
        </div>

        <br>
        <div class="wrapper">
            <div class="title">¿Está tomando alguna medicación?</div>
            <div class="box">
                <input type="radio" id="medicacionSi" name="medicacion" value="si" onclick="toggleMedicacionInput(true)">
                <input type="radio" id="medicacionNo" name="medicacion" value="no" onclick="toggleMedicacionInput(false)">

                <label for="medicacionSi" class="medicacionSi">
                    <div class="dot"></div>
                    <div class="text">Si</div>
                </label>

                <label for="medicacionNo" class="medicacionNo">
                    <div class="dot"></div>
                    <div class="text">No</div>
                </label>

                <div id="medicacionInput" style="display:none;">
                    <label class="form-label" for="medicacionDetalles">¿Qué medicación ?</label>
                    <input type="text" class="form-control item" id="medicacionDetalles" name="medicacionDetalles">
                </div>
            </div>
        </div>

        <br>

        <div class="wrapper">
            <div class="title">Observaciones</div>
            <div class="box">
                <h6>Deje constancia de cualquier indicación que estime necesario deba conocer el personal médico y docente a cargo:</h6>
                <textarea class="form-control item" id="indicaciones" name="indicaciones" rows="3"></textarea>
            </div>
        </div>
        
        <br>
        <div class="wrapper">
            <div class="title">¿Tiene obra social?</div>
            <div class="box">
                <input type="radio" id="obraSocialSi" name="obraSocial" value="si" onclick="toggleObraSocialMensaje(true)">
                <input type="radio" id="obraSocialNo" name="obraSocial" value="no" onclick="toggleObraSocialMensaje(false)">

                <label for="obraSocialSi" class="obraSocialSi">
                    <div class="dot"></div>
                    <div class="text">Si</div>
                </label>

                <label for="obraSocialNo" class="obraSocialNo">
                    <div class="dot"></div>
                    <div class="text">No</div>
                </label>

                <div id="obraSocialMensaje" style="display:none;">
                    <p>En caso de respuesta positiva deberá acompañar la presente planilla con carnet o copia del carnet.</p>
                </div>
            </div>
        </div>
        ';
    }
    mysqli_close($conexion);
?>
