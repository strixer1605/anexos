<?php
    session_start();
    include('conexion.php');
    $idSalida = $_SESSION['idSalida'];
    $dniAlumno = $_SESSION['dniAlumno'];

    $sql = "SELECT * FROM anexovi WHERE fkAnexoIV = '$idSalida' AND dniAlumno = '$dniAlumno'";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        // 1 para "Sí", 0 para "No"
        $obraSocialCheckedSi = $fila['obraSocial'] ? 'checked' : '';
        $obraSocialCheckedNo = !$fila['obraSocial'] ? 'checked' : '';
        
        // Mostrar campos
        $displayObraInputs = $fila['obraSocial'] ? 'block' : 'none';

        echo '
            <div class="form-group">
                <div class="form-group">
                    <label class="form-label labels6" for="constancia">Constancia médica (condición, enfermedad o discapacidad, etc.) (opcional):</label>
                    <textarea class="form-control item" id="constancia" name="constancia" rows="3" placeholder="Descripción..." required>'.$fila['constanciaMedica'].'</textarea>
                </div>
            </div>

            <div class="wrapper">
                <div class="title">¿Tiene Obra Social / Prepaga?</div>
                <div class="box">
                    <input type="radio" id="obraSi" '.$obraSocialCheckedSi.' name="obraSocial" value="1" onclick="toggleMedicacionInput(true)">
                    <input type="radio" id="obraNo" '.$obraSocialCheckedNo.' name="obraSocial" value="0" onclick="toggleMedicacionInput(false)">

                    <label for="obraSi" class="obraSi">
                        <div class="dot"></div>
                        <div class="text">Sí</div>
                    </label>

                    <label for="obraNo" class="obraNo">
                        <div class="dot"></div>
                        <div class="text">No</div>
                    </label>
                </div>
            </div>

            <br><br>
            <div id="nomInput" style="display:'.$displayObraInputs.';">
                <label class="form-label" for="nomObra">Ingrese el nombre de la Obra Social / Prepaga:</label>
                <input type="text" class="form-control item" id="nomObra" name="nomObra" value="'.$fila['nombreObra'].'" placeholder="Ingrese el nombre...">
            </div>

            <div id="nroInput" style="display:'.$displayObraInputs.';">
                <label class="form-label" for="nroObra">Ingrese el número de socio:</label>
                <input type="text" class="form-control item" id="nroObra" name="nroObra" value="'.$fila['nSocio'].'" placeholder="Ingrese el número...">
            </div>
            <br>
        ';
    } else {
        echo '
            <div class="form-group">
                <div class="form-group">
                    <label class="form-label labels6" for="constancia">Constancia médica (condición, enfermedad o discapacidad, etc.) (opcional):</label>
                    <textarea class="form-control item" id="constancia" name="constancia" rows="3" placeholder="Descripción..." required></textarea>
                </div>
            </div>

            <div class="wrapper">
                <div class="title">¿Tiene Obra Social / Prepaga?</div>
                <div class="box">
                    <input type="radio" id="obraSi" name="obraSocial" value="1" onclick="toggleMedicacionInput(true)">
                    <input type="radio" id="obraNo" name="obraSocial" value="0" onclick="toggleMedicacionInput(false)">

                    <label for="obraSi" class="obraSi">
                        <div class="dot"></div>
                        <div class="text">Sí</div>
                    </label>

                    <label for="obraNo" class="obraNo">
                        <div class="dot"></div>
                        <div class="text">No</div>
                    </label>
                </div>
            </div>

            <br>
            <div id="nomInput" style="display:none;">
                <label class="form-label" for="nomObra">Ingrese el nombre de la Obra Social / Prepaga:</label>
                <input type="text" class="form-control item" id="nomObra" name="nomObra" placeholder="Ingrese el nombre...">
            </div>

            <div id="nroInput" style="display:none;">
                <label class="form-label" for="nroObra">Ingrese el número de asociado:</label>
                <input type="text" class="form-control item" id="nroObra" name="nroObra" placeholder="Ingrese el número...">
            </div>
            <br>
        ';
    }
    mysqli_close($conexion);
?>
