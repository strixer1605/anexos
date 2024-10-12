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
            .input-container {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px; /* Espacio entre el input y el botón */
                width: 100%; /* Asegura que ocupe todo el ancho del contenedor */
            }

            .input-container input {
                flex: 1; /* El input ocupará todo el espacio disponible */
                min-width: 0; /* Para que no se desborde en pantallas más pequeñas */
            }

            .input-container button {
                flex-shrink: 0; /* Evita que el botón se encoja */
                white-space: nowrap; /* Evita que el texto del botón se divida en varias líneas */
            }

            #inputObjetivos {
                border-radius: 20px;
                padding: 10px 20px;
                border: 1px solid #d1d1d1;
                transition: border-color 0.3s ease;
            }

            #inputObjetivos:focus {
                border-color: #5891ff;
                box-shadow: 0 0 5px rgba(88, 145, 255, 0.5);
            }

            .btn-agregar {
                margin-top: 10px;
            }

            .btn-warning {
                margin-right: 10px;
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
        <div id="seccionObjetivos" class="form-group">
            <div class="form-label">Objetivos</div>
            <div id="objetivoContainer" class="input-container">
                <input type="text" id="inputObjetivos" class="form-control" placeholder="Escribe un objetivo">
                <button class="cargar-anexo8" type="button" inputId="inputObjetivos">Agregar</button>
            </div>
            <div id="objetivos" name="objetivo" class="contenedorInputs" data-input-id="inputObjetivos" data-label="Objetivos"></div>
        </div>

        <!-- Sección de Descripción Previa --><br>

        <div class="wrapper">
            <div class="title">Etapa Previa</div>
            <div class="box">
                <div id="seccionDescripcionPrevia" class="section">
                    <div class="form-group">
                        <label for="obsPrevia" class="form-label">Observaciones (Previamente):</label>
                        <textarea class="form-control item-anexo8" name="obsPrevia" id="obsPrevia" placeholder="Ingrese Observaciones..." required></textarea>
                    </div>
                    <br>
                    <div class="form-label">Descripción Previa</div>
                    <div class="form-group input-container">
                        <input type="text" id="inputDescripcionPrevia" class="form-control item-anexo8" placeholder="Escribe una descripción previa">
                        <button class="cargar-anexo8" type="button" inputId="inputDescripcionPrevia">Agregar</button>
                    </div>
                    <div id="descPrevia" class="contenedorInputs" data-input-id="inputDescripcionPrevia" data-label="Descripción previa"></div>
                    <br>
                    <div class="form-group">
                        <label for="respSelectPrevia" class="form-label">Seleccione Responsable:</label>
                        <select class="form-control item-anexo8" id="respSelectPrevia" onchange="agregarResponsable('respSelectPrevia', 'contenedorRespPrevia', 'responsablesPrevia')">
                            <option value="">Seleccione un docente</option>
                            <?php foreach ($profesores as $profesor): ?>
                                <option value="<?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="contenedorRespPrevia" class="contenedorInputsResponsables">
                            <div class="form-group">
                                <input type="text" disabled class="form-control anexo8 item-anexo8-v2" value="<?php echo $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; ?>">
                            </div>
                            <input type="hidden" name="responsablesPrevia" value="<?php echo htmlspecialchars($_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Descripción Durante --><br>
        <div class="wrapper">
            <div class="title">Etapa Durante</div>
            <div class="box">
                <div id="seccionDescripcionDurante" class="section">
                    <div class="form-group">
                        <label for="obsDurante" class="form-label">Observaciones (Durante):</label>
                        <textarea class="form-control item-anexo8" id="obsDurante" name="obsDurante" placeholder="Ingrese Observaciones..." required></textarea>
                    </div>
                    <br>
                    <div class="form-label">Descripción Durante</div>
                    <div class="form-group input-container"> <!-- Aquí aplicamos el contenedor flex -->
                        <input type="text" id="inputDescripcionDurante" class="form-control item-anexo8" placeholder="Escribe una descripción durante">
                        <button class="cargar-anexo8" type="button" inputid="inputDescripcionDurante">Agregar</button>
                    </div>
                    <div id="descDurante" class="contenedorInputs" data-input-id="inputDescripcionDurante" data-label="Descripción durante"></div>
                    <br>
                    <div class="form-group">
                        <label for="respSelectDurante" class="form-label">Seleccione Responsable:</label>
                        <select class="form-control item-anexo8" id="respSelectDurante" onchange="agregarResponsable('respSelectDurante', 'contenedorRespDurante', 'responsablesDurante')">
                            <option value="">Seleccione un docente</option>
                            <?php foreach ($profesores as $profesor): ?>
                                <option value="<?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="contenedorRespDurante" class="contenedorInputsResponsables">
                            <div class="input-container">
                                <input type="text" disabled class="form-control anexo8 item-anexo8-v2" value="<?php echo $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; ?>">
                            </div>
                            <input type="hidden" name="responsablesDurante" value="<?php echo htmlspecialchars($_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Evaluación --><br>
        <div class="wrapper">
            <div class="title">Etapa Evaluación</div>
            <div class="box">
                <div id="seccionDescripcionEvaluacion" class="section">
                    <div class="form-group">
                        <label for="obsEvaluacion" class="form-label">Observaciones (Evaluación):</label>
                        <textarea class="form-control item-anexo8" id="obsEvaluacion" name="obsEvaluacion" placeholder="Ingrese Observaciones" required></textarea>
                    </div>
                    <br>

                    <div class="form-label">Descripción Evaluación</div>
                        <div class="form-group input-container"> <!-- Aquí aplicamos el contenedor flex -->
                            <input type="text" id="inputDescripcionEvaluacion" class="form-control item-anexo8" placeholder="Escribe una evaluación">
                            <button class="cargar-anexo8" type="button" inputid="inputDescripcionEvaluacion">Agregar</button>
                        </div>
                        <div id="descEvaluacion" class="contenedorInputs" data-input-id="inputDescripcionEvaluacion" data-label="Descripción evaluación"></div>                
                    <br>
                    <div class="form-group">
                        <label for="respSelectEvaluacion" class="form-label">Seleccione Responsable:</label>
                        <select class="form-control item-anexo8" id="respSelectEvaluacion" onchange="agregarResponsable('respSelectEvaluacion', 'contenedorRespEvaluacion', 'responsablesEvaluacion')">
                            <option value="">Seleccione un docente</option>
                            <?php foreach ($profesores as $profesor): ?>
                                <option value="<?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="contenedorRespEvaluacion" class="contenedorInputsResponsables">
                            <div class="input-container">
                                <input type="text" disabled class="form-control anexo8 item-anexo8-v2" style="" value="<?php echo $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; ?>">
                            </div>
                            <input type="hidden" name="responsablesEvaluacion" value="<?php echo htmlspecialchars($_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                </div>
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
                        nuevoInput.classList.add('item-anexo8-v2');
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
                        eliminarButton.classList.add("eliminar-descripcion");
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

            // Ver si se envian bien los docentes y recibirlos

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
