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

    // Variables para problemas recientes
    $inflamatorios = isset($_POST['problemas']) && in_array('inflamatorios', $_POST['problemas']) ? 1 : 0;
    $fracturas = isset($_POST['problemas']) && in_array('fracturas', $_POST['problemas']) ? 1 : 0;
    $enfermedades = isset($_POST['problemas']) && in_array('enfermedades', $_POST['problemas']) ? 1 : 0;
    $otras = isset($_POST['otrasInput']) ? htmlspecialchars($_POST['otrasInput'], ENT_QUOTES, 'UTF-8') : '';

    // Mostrar el formulario
    echo '
    <style>
        .form-section {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .form-label {
            display: inline-block;
            margin-bottom: 5px;
            text-align: left; /* Alinear texto a la izquierda */
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
        }
        .checkbox-group {
            margin-left: 20px; /* Espacio para los checkboxes */
        }
    </style>

    <!-- Sección de Alergias -->
    <div class="form-section">
        <h5>Información de Salud</h5>
        <div class="form-group">
            <label class="form-label">¿Es alérgico?</label><br>
            <div class="checkbox-group">
                <input type="radio" id="alergicoSi" name="alergico" value="si" onclick="toggleAlergiaInput(true)">
                <label for="alergicoSi">Sí</label><br>
                <input type="radio" id="alergicoNo" name="alergico" value="no" onclick="toggleAlergiaInput(false)">
                <label for="alergicoNo">No</label>
            </div>
        </div>
        <div id="alergiaInput" style="display:none;">
            <label class="form-label" for="aQue">¿A qué es alérgico?</label>
            <input type="text" class="form-control" id="aQue" name="aQue">
        </div>
    </div>

    <!-- Sección de Problemas Recientes -->
    <div class="form-section">
        <h5>Problemas Recientes</h5>
        <div class="form-group">
            <label class="form-label">¿Ha sufrido en los últimos 30 días?</label><br>
            <div class="checkbox-group">
                <input type="checkbox" name="problemas[]" value="inflamatorios" id="inflamatorios" ' . ($inflamatorios ? 'checked' : '') . '>
                <label for="inflamatorios">a. Procesos Inflamatorios</label><br>
                <input type="checkbox" name="problemas[]" value="fracturas" id="fracturas" ' . ($fracturas ? 'checked' : '') . '>
                <label for="fracturas">b. Fracturas o esguinces</label><br>
                <input type="checkbox" name="problemas[]" value="enfermedades" id="enfermedades" ' . ($enfermedades ? 'checked' : '') . '>
                <label for="enfermedades">c. Enfermedades infecto-contagiosas</label><br>
                <input type="checkbox" name="problemas[]" value="otras" id="otras" onclick="toggleOtrasInput()">
                <label for="otras">d. Otras:</label>
                <input type="text" class="form-control" id="otrasInput" name="otrasInput" value="' . $otras . '" style="display:none;">
            </div>
        </div>
    </div>

    <!-- Sección de Medicación -->
    <div class="form-section">
        <h5>Medicación</h5>
        <div class="form-group">
            <label class="form-label">¿Está tomando alguna medicación?</label><br>
            <div class="checkbox-group">
                <input type="radio" id="medicacionSi" name="medicacion" value="si" onclick="toggleMedicacionInput(true)">
                <label for="medicacionSi">Sí</label><br>
                <input type="radio" id="medicacionNo" name="medicacion" value="no" onclick="toggleMedicacionInput(false)">
                <label for="medicacionNo">No</label>
            </div>
        </div>
        <div id="medicacionInput" style="display:none;">
            <label class="form-label" for="medicacionDetalles">¿Qué medicación está tomando?</label>
            <input type="text" class="form-control" id="medicacionDetalles" name="medicacionDetalles">
        </div>
    </div>

    <!-- Sección de Observaciones -->
    <div class="form-section">
        <h5>Observaciones</h5>
        <div class="form-group">
            <label class="form-label">Deje constancia de cualquier indicación que estime necesario deba conocer el personal médico y docente a cargo:</label>
            <textarea class="form-control" id="indicaciones" name="indicaciones" rows="3"></textarea>
        </div>
    </div>

    <!-- Sección de Obra Social -->
    <div class="form-section">
        <h5>Obra Social</h5>
        <div class="form-group">
            <label class="form-label">¿Tiene obra social?</label><br>
            <div class="checkbox-group">
                <input type="radio" id="obraSocialSi" name="obraSocial" value="si" onclick="toggleObraSocialMensaje(true)">
                <label for="obraSocialSi">Sí</label><br>
                <input type="radio" id="obraSocialNo" name="obraSocial" value="no" onclick="toggleObraSocialMensaje(false)">
                <label for="obraSocialNo">No</label>
            </div>
        </div>
        <div id="obraSocialMensaje" style="display:none;">
            <p>En caso de respuesta positiva deberá acompañar la presente planilla con carnet o copia del carnet.</p>
        </div>
    </div>
    ';
} else {
    echo "No se encontraron registros del Anexo VII.";
}

mysqli_close($conexion);
?>
