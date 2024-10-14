<?php 
include 'conexion.php';

// Suponemos que la columna de la tabla 'anexoviii' tiene un valor separado por comas
$idSalida = $_SESSION['idSalida'];
$sql = "SELECT * FROM anexoviii WHERE fkAnexoIV = $idSalida";

$resultado = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_assoc($resultado);

// Definir los nombres de los campos que necesitas separar
$campos = [
    'objetivo',
    'descripcionPrevias',
    'responsablesPrevias',
    'observacionesPrevias',
    'descripcionDurante',
    'responsablesDurante',
    'observacionesDurante',
    'descripcionEvaluacion',
    'responsablesEvaluacion',
    'observacionesEvaluacion'
];

// Array para almacenar los arrays separados por campo
$valoresSeparados = [];

// Iterar sobre cada campo
foreach ($campos as $campo) {
    // Verificar si el campo existe en la fila
    if (isset($fila[$campo])) {
        // Convertir la cadena en un array usando explode
        $valores = explode(',', $fila[$campo]);

        // Inicializar el array para este campo
        $valoresSeparados[$campo] = [];

        // Bucle while para recorrer cada valor separado por comas y agregarlo al array
        $i = 0;
        while ($i < count($valores)) {
            $valoresSeparados[$campo][] = trim($valores[$i]); // trim() para eliminar espacios en blanco
            $i++;
        }
    } else {
        // Si el campo no está presente en $fila, dejar el array vacío
        $valoresSeparados[$campo] = [];
    }
}


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
        <div id="objetivos" name="objetivo" class="contenedorInputs" data-input-id="inputObjetivos" data-label="Objetivos">
            
            <?php 
                // Verificar si la posición 0 existe y si es distinta de ''
                if (isset($valoresSeparados['objetivo'][0]) && $valoresSeparados['objetivo'][0] != '') {
                    // Recorrer y generar el HTML solo si el primer valor no es una cadena vacía
                    foreach ($valoresSeparados['objetivo'] as $valor) {
                        echo '<div class="input-container">';
                        echo '    <input type="text" disabled class="form-control anexo8 item" style="margin-top: 25px;" value="' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '">';
                        
                        // Botón para editar/guardar el valor
                        echo '    <button type="button" class="editar-objetivo" onclick="editarValor(this, \'hiddenObjetivos\', objetivos)">Editar</button>';
                        
                        // Botón para eliminar el input, pasando el campo hidden correspondiente
                        echo '    <button type="button" class="eliminar-objetivo" onclick="eliminarValor(this, \'hiddenObjetivos\', objetivos)">Eliminar</button>';
                        
                        echo '</div>';
                    }
                }
            ?>
                <input type="hidden" id="hiddenObjetivos" name="inputObjetivos" value="<?php echo htmlspecialchars($fila['objetivo'], ENT_QUOTES, 'UTF-8'); ?>">

        </div>
    </div>


    <div class="wrapper">
        <div class="title">Etapa Previa</div>
        <div class="box">
            <div id="seccionDescripcionPrevia" class="section">
                <div class="form-group">
                    <label for="obsPrevia" class="form-label">Observaciones (Previamente):</label>
                    <textarea class="form-control item-anexo8" name="obsPrevia" id="obsPrevia" placeholder="Ingrese Observaciones..." required><?php echo htmlspecialchars($fila['observacionesPrevias'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <br>
                <div class="form-label">Descripción Previa</div>
                <div class="form-group input-container">
                    <input type="text" id="inputDescripcionPrevia" class="form-control item-anexo8" placeholder="Escribe una descripción previa">
                    <button class="cargar-anexo8" type="button" inputId="inputDescripcionPrevia">Agregar</button>
                </div>
                <div id="descPrevia" class="contenedorInputs" data-input-id="inputDescripcionPrevia" data-label="Descripción previa">
                    <?php 
                        // Verificar si la posición 0 existe y si es distinta de ''
                        if (isset($valoresSeparados['descripcionPrevias'][0]) && $valoresSeparados['descripcionPrevias'][0] != '') {
                            // Recorrer y generar el HTML solo si el primer valor no es una cadena vacía
                            foreach ($valoresSeparados['descripcionPrevias'] as $valor) {
                                echo '<div class="input-container">';
                                echo '    <input type="text" disabled class="form-control anexo8 item" style ="margin-top: 25px;" value="' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '">';
                                
                                // Botón para editar/guardar el valor
                                echo '    <button type="button" class="editar-objetivo" onclick="editarValor(this, \'hiddenDescPrevia\', descPrevia)">Editar</button>';
                                
                                // Botón para eliminar el input
                                echo '    <button type="button" class="eliminar-objetivo" onclick="eliminarValor(this, \'hiddenDescPrevia\', descPrevia)">Eliminar</button>';
                                
                                echo '</div>';
                            }
                        }
                    ?>
                    <input type="hidden" id="hiddenDescPrevia" name="inputDescripcionPrevia" value="<?php echo htmlspecialchars($fila['descripcionPrevias'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
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
                        <?php 
                            // Verificar si la posición 0 existe y si es distinta de ''
                            $responsablesPrevia = ''; // Inicializar variable para los responsables previos

                            if (isset($valoresSeparados['responsablesPrevias'][0]) && $valoresSeparados['responsablesPrevias'][0] != '') {
                                // Recorrer y generar el HTML solo si el primer valor no es una cadena vacía
                                foreach ($valoresSeparados['responsablesPrevias'] as $valor) {
                                    // Verificar si el valor no es igual a la concatenación de apellidoDoc y nombreDoc
                                    $responsableDoc = $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'];
                                    
                                    echo '<div class="input-container">';
                                    echo '    <input type="text" disabled class="form-control anexo8 item-anexo8-v2" value="' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '">';
                                    
                                    // Agregar el valor al campo oculto
                                    $responsablesPrevia .= ($responsablesPrevia ? ', ' : '') . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');

                                    // Solo agregar el botón "Eliminar" si el valor no es igual a responsableDoc
                                    if ($valor != $responsableDoc) {
                                        echo '    <button type="button" style="margin-top: 25px;"  class="eliminar-objetivo" onclick="eliminarResponsable(this.parentNode, document.querySelector(`input[name=\'responsablesPrevia\']`), \'' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '\')">Eliminar</button>';
                                    }
                                    echo '</div>';
                                }
                            } else {
                                // Si no hay valores o el primer valor es una cadena vacía, mostrar el valor de la sesión
                                echo '<div class="input-container">';
                                echo '    <input type="text" disabled class="form-control anexo8 item-anexo8-v2" value="' . $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'] . '">';
                                echo '</div>';
                                $responsablesPrevia = $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; // Solo asignar el valor de sesión
                            }
                        ?>

                        <!-- Campo oculto para responsables previas -->
                        <input type="hidden" name="responsablesPrevia" value="<?php echo htmlspecialchars($responsablesPrevia, ENT_QUOTES, 'UTF-8'); 
                        ?>">
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
                    <textarea class="form-control item-anexo8" id="obsDurante" name="obsDurante" placeholder="Ingrese Observaciones..." required><?php echo htmlspecialchars($fila['observacionesDurante'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <br>
                <div class="form-label">Descripción Durante</div>
                <div class="form-group input-container"> <!-- Aquí aplicamos el contenedor flex -->
                    <input type="text" id="inputDescripcionDurante" class="form-control item-anexo8" placeholder="Escribe una descripción durante">
                    <button class="cargar-anexo8" type="button" inputid="inputDescripcionDurante">Agregar</button>
                </div>
                <div id="descDurante" class="contenedorInputs" data-input-id="inputDescripcionDurante" data-label="Descripción durante">
                <?php 
                    // Verificar si la posición 0 existe y si es distinta de ''
                    if (isset($valoresSeparados['descripcionDurante'][0]) && $valoresSeparados['descripcionDurante'][0] != '') {
                        // Recorrer y generar el HTML solo si el primer valor no es una cadena vacía
                        foreach ($valoresSeparados['descripcionDurante'] as $valor) {
                            echo '<div class="input-container">';
                            echo '    <input type="text" disabled class="form-control anexo8 item" style ="margin-top: 25px;" value="' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '">';
                            
                            // Botón para editar/guardar el valor
                            echo '    <button type="button" class="editar-objetivo" onclick="editarValor(this, \'hiddenDescDurante\', descDurante)">Editar</button>';
                            
                            // Botón para eliminar el input
                            echo '    <button type="button" class="eliminar-objetivo" onclick="eliminarValor(this, \'hiddenDescDurante\', descDurante)">Eliminar</button>';
                            
                            echo '</div>';
                        }
                    }
                ?>
                <input type="hidden" id="hiddenDescDurante" name="inputDescripcionDurante" value="<?php echo htmlspecialchars($fila['descripcionDurante'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
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
                        <?php 
                            // Verificar si la posición 0 existe y si es distinta de ''
                            $responsablesDurante = ''; // Inicializar variable para los responsables previos

                            if (isset($valoresSeparados['responsablesDurante'][0]) && $valoresSeparados['responsablesDurante'][0] != '') {
                                // Recorrer y generar el HTML solo si el primer valor no es una cadena vacía
                                foreach ($valoresSeparados['responsablesDurante'] as $valor) {
                                    // Verificar si el valor no es igual a la concatenación de apellidoDoc y nombreDoc
                                    $responsableDoc = $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'];
                                    
                                    echo '<div class="input-container">';
                                    echo '    <input type="text" disabled class="form-control anexo8 item-anexo8-v2" value="' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '">';
                                    
                                    // Agregar el valor al campo oculto
                                    $responsablesDurante .= ($responsablesDurante ? ', ' : '') . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');

                                    // Solo agregar el botón "Eliminar" si el valor no es igual a responsableDoc
                                    if ($valor != $responsableDoc) {
                                        echo '    <button type="button" style="margin-top: 25px;"  class="eliminar-objetivo" onclick="eliminarResponsable(this.parentNode, document.querySelector(`input[name=\'responsablesDurante\']`), \'' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '\')">Eliminar</button>';
                                    }
                                    echo '</div>';
                                }
                            } else {
                                // Si no hay valores o el primer valor es una cadena vacía, mostrar el valor de la sesión
                                echo '<div class="input-container">';
                                echo '    <input type="text" disabled class="form-control anexo8 item-anexo8-v2" value="' . $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'] . '">';
                                echo '</div>';
                                $responsablesDurante = $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; // Solo asignar el valor de sesión
                            }
                        ?>

                        <!-- Campo oculto para responsables previas -->
                        <input type="hidden" name="responsablesDurante" value="<?php echo htmlspecialchars($responsablesDurante, ENT_QUOTES, 'UTF-8'); ?>">
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
                    <textarea class="form-control item-anexo8" id="obsEvaluacion" name="obsEvaluacion" placeholder="Ingrese Observaciones" required><?php echo htmlspecialchars($fila['observacionesEvaluacion'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <br>

                <div class="form-label">Descripción Evaluación</div>
                    <div class="form-group input-container"> <!-- Aquí aplicamos el contenedor flex -->
                        <input type="text" id="inputDescripcionEvaluacion" class="form-control item-anexo8" placeholder="Escribe una evaluación">
                        <button class="cargar-anexo8" type="button" inputid="inputDescripcionEvaluacion">Agregar</button>
                    </div>
                    <div id="descEvaluacion" class="contenedorInputs" data-input-id="inputDescripcionEvaluacion" data-label="Descripción evaluación">
                    <?php 
                        // Verificar si la posición 0 existe y si es distinta de ''
                        if (isset($valoresSeparados['descripcionEvaluacion'][0]) && $valoresSeparados['descripcionEvaluacion'][0] != '') {
                            // Recorrer y generar el HTML solo si el primer valor no es una cadena vacía
                            foreach ($valoresSeparados['descripcionEvaluacion'] as $valor) {
                                echo '<div class="input-container">';
                                echo '    <input type="text" disabled class="form-control anexo8 item" style="margin-top: 25px;" value="' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '">';
                                
                                // Botón para editar/guardar el valor
                                echo '    <button type="button" class="editar-objetivo" onclick="editarValor(this, \'hiddenEvaluacion\', descEvaluacion)">Editar</button>';

                                // Botón para eliminar el input
                                echo '    <button type="button" class="eliminar-objetivo" onclick="eliminarValor(this, \'hiddenEvaluacion\', descEvaluacion)">Eliminar</button>';
                                
                                echo '</div>';
                            }
                        }
                    ?>
                    <input type="hidden" id="hiddenEvaluacion" name="inputDescripcionEvaluacion" value="<?php echo htmlspecialchars($fila['descripcionEvaluacion'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>                
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
                        <?php 
                            // Verificar si la posición 0 existe y si es distinta de ''
                            $responsablesEvaluacion = ''; // Inicializar variable para los responsables previos

                            if (isset($valoresSeparados['responsablesEvaluacion'][0]) && $valoresSeparados['responsablesEvaluacion'][0] != '') {
                                // Recorrer y generar el HTML solo si el primer valor no es una cadena vacía
                                foreach ($valoresSeparados['responsablesEvaluacion'] as $valor) {
                                    // Verificar si el valor no es igual a la concatenación de apellidoDoc y nombreDoc
                                    $responsableDoc = $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'];
                                    
                                    echo '<div class="input-container">';
                                    echo '    <input type="text" disabled class="form-control anexo8 item-anexo8-v2" value="' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '">';
                                    
                                    // Agregar el valor al campo oculto
                                    $responsablesEvaluacion .= ($responsablesEvaluacion ? ', ' : '') . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');

                                    // Solo agregar el botón "Eliminar" si el valor no es igual a responsableDoc
                                    if ($valor != $responsableDoc) {
                                        echo '    <button type="button" style="margin-top: 25px;" class="eliminar-objetivo" onclick="eliminarResponsable(this.parentNode, document.querySelector(`input[name=\'responsablesEvaluacion\']`), \'' . htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') . '\')">Eliminar</button>';
                                    }
                                    echo '</div>';
                                }
                            } else {
                                // Si no hay valores o el primer valor es una cadena vacía, mostrar el valor de la sesión
                                echo '<div class="input-container">';
                                echo '    <input type="text" disabled class="form-control anexo8 item-anexo8-v2" value="' . $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc'] . '">';
                                echo '</div>';
                                $responsablesEvaluacion = $_SESSION['apellidoDoc'] . ' ' . $_SESSION['nombreDoc']; // Solo asignar el valor de sesión
                            }
                        ?>

                        <!-- Campo oculto para responsables previas -->
                        <input type="hidden" name="responsablesEvaluacion" value="<?php echo htmlspecialchars($responsablesEvaluacion, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        // Función para editar/guardar el valor
        function editarValor(button, hiddenInputId, containerId) { 
            const input = button.previousElementSibling; // Obtener el input anterior
            const contenedorInputs = containerId; // Obtener el contenedor principal de los inputs
            const hiddenInput = document.getElementById(hiddenInputId); // Obtener el input hidden correspondiente por su ID

            console.log(button, hiddenInputId, containerId);
            console.log(input, contenedorInputs, hiddenInput);
            if (input.disabled) {
                input.disabled = false; // Habilitar el input
                button.textContent = 'Guardar'; // Cambiar texto del botón a "Guardar"
            } else {
                input.disabled = true; // Deshabilitar el input
                button.textContent = 'Editar'; // Cambiar texto del botón a "Editar"

                // Actualizar el valor del campo oculto después de editar
                hiddenInput.value = Array.from(contenedorInputs.querySelectorAll('input.form-control.anexo8'))
                    .map(input => input.value)
                    .join(', '); // Reagrupar los valores
            }
        }



        function eliminarValor(button, hiddenInputId, container) {
            // Obtener el contenedor del input y el contenedor principal
            const inputContainer = button.parentNode; // Obtener el contenedor del input
            const contenedorInputs = container; // Obtener el contenedor principal de los inputs

            // Comprobar si se encuentra el contenedor
            if (!contenedorInputs) {
                alert('No se encontró el contenedor de inputs.');
                return; // Detener si no se encuentra el contenedor
            }

            
            // Actualizar el valor del campo oculto antes de eliminar el input
            const hiddenInput = document.getElementById(hiddenInputId); // Obtener el input hidden correspondiente por su ID
            
            // Eliminar el contenedor del input
            inputContainer.remove(); // Eliminar el contenedor del input

            // Actualizar nuevamente el valor del campo oculto después de eliminar el input
            hiddenInput.value = Array.from(contenedorInputs.querySelectorAll('input.form-control.anexo8'))
                .map(input => input.value)
                .join(', '); // Reagrupar los valores
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
