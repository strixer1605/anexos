<?php 
// session_start();
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Descripciones</title>
    <style>
        .section {
    margin-top: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 10px;
}

.section-title {
    font-weight: bold;
}

.input-container {
    margin-bottom: 10px;
    display: flex;
    flex-wrap: wrap; /* Permite que los elementos se ajusten en la línea */
    justify-content: space-between; /* Para distribuir bien el contenido */
}

.input-container input {
    flex: 1 1 auto; /* Hace que el input ocupe todo el ancho disponible */
    min-width: 200px; /* Asegura que el input tenga un tamaño mínimo */
}

.input-container button {
    flex: 0 0 auto; /* El botón ocupa el espacio necesario sin flexibilidad */
    margin-top: 10px;
    margin-left: 5px;
}

.btn-agregar {
    margin-top: 10px;
}

.btn-warning {
    margin-right: 10px;
}

.anexo8 {
    width: auto;
    margin-right: 5px;
}

/* Ajustes para pantallas pequeñas */
@media (max-width: 768px) {
    .input-container {
        flex-direction: column; /* Coloca los elementos uno debajo del otro */
        align-items: stretch; /* Alinea los elementos para que ocupen todo el ancho */
    }

    .input-container button {
        margin-left: 0; /* Elimina el margen izquierdo del botón en móviles */
        margin-top: 10px; /* Añade espacio superior en móviles */
        width: 100%; /* Asegura que el botón ocupe todo el ancho disponible */
    }
}

    </style>
</head>
<body>
    <!-- Sección de Objetivo -->
    <div id="seccionObjetivos" class="section">
        <div class="section-title">Objetivos</div>
        <div id="objetivoContainer" class="input-container">
            <input type="text" id="inputObjetivos" class="form-control" placeholder="Escribe un objetivo">
            <button class="btn btn-primary btn-agregar" type="button" inputId="inputObjetivos">Agregar</button>
        </div>
        <div id="objetivos" name="objetivo" class="contenedorInputs" data-input-id="inputObjetivos" data-label="Objetivos"></div>
    </div>

    <!-- Sección de Descripción Previa -->
    <div id="seccionDescripcionPrevia" class="section">
        <h3>Etapa previa</h3>
        <div class="mb-5">
            <label for="obsPrevia" class="form-label">Observaciones (Previamente):</label>
            <textarea class="form-control" name="obsPrevia" id="obsPrevia" placeholder="Ingrese Observaciones..." required></textarea>
        </div>
        <div class="section-title">Descripción Previa</div>
        <div class="input-container">
            <input type="text" id="inputDescripcionPrevia" class="form-control" placeholder="Escribe una descripción previa">
            <button class="btn btn-primary btn-agregar" type="button" inputId="inputDescripcionPrevia">Agregar</button>
        </div>
        <div id="descPrevia" class="contenedorInputs" data-input-id="inputDescripcionPrevia" data-label="Descripción previa"></div>

        <label for="respSelectPrevia" class="form-label">Seleccione Responsable:</label>
        <select class="form-control mb-3" id="respSelectPrevia" onchange="agregarResponsable('respSelectPrevia', 'contenedorRespPrevia', 'responsablesPrevia')">
            <option value="">Seleccione un docente</option>
            <?php foreach ($profesores as $profesor): ?>
                <option value="<?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div id="contenedorRespPrevia" class="contenedorInputsResponsables">
            <div class="input-container">
                <input type="text" disabled class="form-control anexo8" value="<?php echo $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; ?>">
            </div>
            <input type="hidden" name="responsablesPrevia" value="<?php echo htmlspecialchars($_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
    </div>

    <!-- Repetir el mismo proceso para las otras secciones (Durante y Evaluación) -->
    <!-- Sección de Descripción Durante -->
    <div id="seccionDescripcionDurante" class="section">
        <h3>Etapa durante</h3>
        <div class="mb-5">
            <label for="obsDurante" class="form-label">Observaciones (Durante):</label>
            <textarea class="form-control" id="obsDurante" name="obsDurante" placeholder="Ingrese Observaciones..." required></textarea>
        </div>
        <div class="section-title">Descripción Durante</div>
        <div class="input-container">
            <input type="text" id="inputDescripcionDurante" class="form-control" placeholder="Escribe una descripción durante">
            <button class="btn btn-primary btn-agregar" type="button" inputid="inputDescripcionDurante">Agregar</button>
        </div>
        <div id="descDurante" class="contenedorInputs" data-input-id="inputDescripcionDurante" data-label="Descripción durante"></div>

        <label for="respSelectDurante" class="form-label">Seleccione Responsable:</label>
        <select class="form-control mb-3" id="respSelectDurante" onchange="agregarResponsable('respSelectDurante', 'contenedorRespDurante', 'responsablesDurante')">
            <option value="">Seleccione un docente</option>
            <?php foreach ($profesores as $profesor): ?>
                <option value="<?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div id="contenedorRespDurante" class="contenedorInputsResponsables">
            <div class="input-container">
                <input type="text" disabled class="form-control anexo8" value="<?php echo $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; ?>">
            </div>
            <input type="hidden" name="responsablesDurante" value="<?php echo htmlspecialchars($_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
    </div>

    <!-- Sección de Evaluación -->
    <div id="seccionDescripcionEvaluacion" class="section">
        <h3>Etapa de Evaluación</h3>
        <div class="mb-5">
            <label for="obsEvaluacion" class="form-label">Observaciones (Evaluación):</label>
            <textarea class="form-control" id="obsEvaluacion" name="obsEvaluacion" placeholder="Ingrese Observaciones" required></textarea>
        </div>
        <div class="section-title">Descripción evaluación</div>
        <div class="input-container">
            <input type="text" id="inputDescripcionEvaluacion" class="form-control" placeholder="Escribe una evaluación">
            <button class="btn btn-primary btn-agregar" type="button" inputid="inputDescripcionEvaluacion">Agregar</button>
        </div>
        <div id="descEvaluacion" class="contenedorInputs" data-input-id="inputDescripcionEvaluacion" data-label="Descripción evaluación"></div>

        <label for="respSelectEvaluacion" class="form-label">Seleccione Responsable:</label>
        <select class="form-control mb-3" id="respSelectEvaluacion" onchange="agregarResponsable('respSelectEvaluacion', 'contenedorRespEvaluacion', 'responsablesEvaluacion')">
            <option value="">Seleccione un docente</option>
            <?php foreach ($profesores as $profesor): ?>
                <option value="<?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div id="contenedorRespEvaluacion" class="contenedorInputsResponsables">
            <div class="input-container">
                <input type="text" disabled class="form-control anexo8" value="<?php echo $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; ?>">
            </div>
            <input type="hidden" name="responsablesEvaluacion" value="<?php echo htmlspecialchars($_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

    </div>

    <!-- <button type="button" class="btn btn-success" id="valores">Mostrar Valores</button> -->

    <script>
        var nombreDocente = "<?php echo $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; ?>";

        function agregarResponsable(selectId, contenedorId, hiddenInputName) {
            const select = document.getElementById(selectId);
            const seleccionado = select.options[select.selectedIndex].value;

            if (seleccionado) {
                // Verificar si el responsable ya está agregado
                const existe = Array.from(document.querySelectorAll(`#${contenedorId} input.form-control`))
                    .some(input => input.value === seleccionado);

                if (!existe) {
                    const inputContainer = document.createElement('div');
                    inputContainer.classList.add('input-container');

                    const nuevoInput = document.createElement('input');
                    nuevoInput.type = 'text';
                    nuevoInput.value = seleccionado;
                    nuevoInput.disabled = true;
                    nuevoInput.classList.add('form-control');
                    nuevoInput.classList.add('anexo8');

                    let hiddenInput = document.querySelector(`input[name="${hiddenInputName}"]`);
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = hiddenInputName;
                        hiddenInput.value = seleccionado;
                        document.getElementById(contenedorId).appendChild(hiddenInput);
                    } else {
                        hiddenInput.value += (hiddenInput.value ? ', ' : '') + seleccionado;
                    }

                    const eliminarButton = document.createElement('button');
                    eliminarButton.innerText = "Eliminar";
                    eliminarButton.type = "button";
                    eliminarButton.classList.add("btn", "btn-danger");
                    eliminarButton.onclick = function () {
                        eliminarResponsable(inputContainer, hiddenInput, seleccionado);
                    };

                    inputContainer.appendChild(nuevoInput);
                    inputContainer.appendChild(eliminarButton);
                    document.getElementById(contenedorId).appendChild(inputContainer);
                }
            }
        }

        function eliminarResponsable(inputContainer, hiddenInput, valorResponsable) {
            const responsables = hiddenInput.value.split(',').map(v => v.trim());
            const nuevoValor = responsables.filter(v => v !== valorResponsable).join(', ');

            hiddenInput.value = nuevoValor;
            inputContainer.remove();
        }

//ver si se envian bien los docentes y recibirlos

    function actualizarListaProfesores(selectId) {
        const select = document.getElementById(selectId);
        select.innerHTML = '<option value="">Seleccione un docente</option>'; // Reiniciar el select

        // Realizar una solicitud AJAX para obtener la lista de profesores
        fetch('../../php/obtenerProfesores.php')
            .then(response => response.json())
            .then(data => {
                // Llenar el select con los nuevos profesores
                data.forEach(profesor => {
                    const option = document.createElement('option');
                    option.value = profesor.apellidoNombre;
                    option.textContent = profesor.apellidoNombre;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Error al obtener los profesores:', error));
    }

    // Llamar a la función al cargar la página o cada vez que se actualicen los datos en el primer tab
    document.addEventListener('DOMContentLoaded', () => {
        // Obtener los elementos select
        const selectPrevia = document.getElementById('respSelectPrevia');
        const selectDurante = document.getElementById('respSelectDurante');
        const selectEvaluacion = document.getElementById('respSelectEvaluacion');

        // Función para actualizar la lista de profesores
        const actualizarSelect = (selectId) => {
            actualizarListaProfesores(selectId);
        };

        // Agregar eventos de clic a cada select
        selectPrevia.addEventListener('click', () => actualizarSelect('respSelectPrevia'));
        selectDurante.addEventListener('click', () => actualizarSelect('respSelectDurante'));
        selectEvaluacion.addEventListener('click', () => actualizarSelect('respSelectEvaluacion'));
    });
</script>
</body>
</html>
