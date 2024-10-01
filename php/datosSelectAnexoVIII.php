<?php
session_start();

$idSalida = $_SESSION['idSalida'];
include 'conexion.php';
$sqlProfesSalida = "SELECT `dni`, `apellidoNombre` FROM `anexov` WHERE fkAnexoIV = $idSalida AND cargo = 2";
$resultado = mysqli_query($conexion, $sqlProfesSalida);
$profesores = [];
while ($filaProfe = $resultado->fetch_assoc()) {
    $profesores[] = $filaProfe; // Guardamos los profesores en un array
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .etapa {
        background-color: #EDEDED;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    h2 {
        margin-bottom: 15px;
    }

    textarea {
        background-color: #e9ecef;
        color: #495057;
    }
</style>

</head>
<body>    
    <!-- Nueva sección de Objetivo -->
    <div class="mb-5">
        <label for="objetivo" class="form-label">Objetivo:</label>
        <input type="text" class="form-control" id="objetivo" name="objetivo" placeholder="Ingrese el objetivo..." 
        value="<?php echo htmlspecialchars($row['objetivo'], ENT_QUOTES, 'UTF-8'); ?>" required readonly>
    </div>

    <div class="row mb-5">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="descripcionInput" class="column-label">Ingrese la Descripción:</label>
                    <input type="text" class="form-control" id="descripcionInput" placeholder="Ingrese Descripción...">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="descripcionSelect" class="column-label">Seleccione la etapa:</label>
                    <select class="form-control" id="descripcionSelect">
                        <option value="objetivo">Objetivo</option>
                        <option value="previas">Previa</option>
                        <option value="durante">Durante</option>
                        <option value="evaluacion">Evaluación</option>
                    </select>
                </div>
            </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <button type="button" class="btn btn-primary" id="cargarDescripcion">Cargar Descripción</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <button type="button" class="btn btn-secondary" onclick="toggleEditable()">Habilitar/Deshabilitar Edición</button>
                        <label for="estadoTT" id="estadoTT">Deshabilitado</label>
                    </div>
                </div>
            </div>
    </div>
    <!-- Seleccionar responsable -->
    <div class="row mb-5">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="respSelect" class="form-label">Seleccione Responsable:</label>
                    <select class="form-control" id="respSelect">
                        <?php foreach ($profesores as $profesor): ?>
                            <option value="<?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($profesor['apellidoNombre'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="Todos los docentes participantes de la salida">Todos los docentes participantes de la salida</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="seccionSelect" class="form-label">Seleccione Sección:</label>
                    <select class="form-control" id="seccionSelect">
                        <option value="previas">Previa</option>
                        <option value="durante">Durante</option>
                        <option value="evaluacion">Evaluación</option>
                    </select>
                </div>
            </div>
                <div class="col-md-6">
                    <div class="mb-5">
                        <button type="button" class="btn btn-success" onclick="cargarResponsable()">Cargar Responsable</button>
                    </div>
                </div>
            </div>
    </div>

    <div class="etapa">
        <h2>Etapa Previa</h2>
        <div class="mb-5">
            <label for="obsPrevia" class="form-label">Observaciones (Previamente):</label>
            <textarea class="form-control" id="obsPrevia" name="obsPrevia" placeholder="Ingrese Observaciones..." required><?php echo htmlspecialchars($row['observaciones'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="mb-5">
            <label for="descPrevia" class="form-label">Descripción Previa:</label>
            <textarea class="form-control" id="descPrevia" placeholder="Ingrese la descripción más arriba..." name="descPrevia" readonly><?php echo $row['descripcionPrevias']; ?></textarea>
        </div>
        
        <div class="mb-5">
            <label for="respPrevia" class="form-label">Responsables (Previamente):</label>
            <textarea class="form-control" id="respPrevia" name="respPrevia" placeholder="Ingrese Responsables..." required readonly><?php echo htmlspecialchars($row['responsablesPrevias'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <p style="margin-top: 5px; margin-left: 2px;">Nota: Para ingresar otro docente, debe separarlo por comas.</p>    
        </div>
    </div>

    <!-- Etapa: Durante -->
    <div class="etapa">
        <h2>Etapa Durante</h2>
        <div class="mb-5">
            <label for="obsDurante" class="form-label">Observaciones (Durante):</label>
            <textarea class="form-control" id="obsDurante" name="obsDurante" placeholder="Ingrese Observaciones..." required><?php echo htmlspecialchars($row['observacionesDurante'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="mb-5">
            <label for="descDurante" class="form-label">Descripción Durante:</label>
            <textarea class="form-control" id="descDurante" placeholder="Ingrese la descripción más arriba..." name="descDurante" readonly><?php echo $row['descripcionDurante']; ?></textarea>
        </div>
        
        <div class="mb-5">
            <label for="respDurante" class="form-label">Responsables (Durante):</label>
            <textarea class="form-control" id="respDurante" name="respDurante" placeholder="Ingrese Responsables..." required readonly><?php echo htmlspecialchars($row['responsablesDurante'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <p style="margin-top: 5px; margin-left: 2px;">Nota: Para ingresar otro docente, debe separarlo por comas.</p>    
        </div>
    </div>

    <!-- Etapa: Evaluación -->
    <div class="etapa">
        <h2>Etapa de Evaluación</h2>
        <div class="mb-5">
            <label for="obsEvaluacion" class="form-label">Observaciones (Evaluación):</label>
            <textarea class="form-control" id="obsEvaluacion" name="obsEvaluacion" placeholder="Ingrese Observaciones" required><?php echo htmlspecialchars($row['observacionesEvaluacion'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="mb-5">
            <label for="descEvaluacion" class="form-label">Descripción Evaluación:</label>
            <textarea class="form-control" id="descEvaluacion" placeholder="Ingrese la descripción más arriba..." name="descEvaluacion" readonly><?php echo $row['descripcionEvaluacion']; ?></textarea>
        </div>
        
        <div class="mb-5">
            <label for="respEvaluacion" class="form-label">Responsables (Evaluación):</label>
            <textarea class="form-control" id="respEvaluacion" name="respEvaluacion" placeholder="Ingrese Responsables..." required readonly><?php echo htmlspecialchars($row['responsablesEvaluacion'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <p style="margin-top: 5px; margin-left: 2px;">Nota: Para ingresar otro docente, debe separarlo por comas.</p>    
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <script>
        $(document).on('click', '#cargarDescripcion', function() {
            cargarDescripcion();
        })

        document.getElementById('descripcionInput').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Evitar el envío de formularios si está dentro de uno
                cargarDescripcion(); // Llamar a la función
            }
        });
        // Función para cargar la descripción en el campo correspondiente
        function cargarDescripcion() {
            const descripcion = document.getElementById('descripcionInput').value;
            const etapaSeleccionada = document.getElementById('descripcionSelect').value;

            if (!descripcion) {
                alert('Debe ingresar una descripción.');
                return;
            }

            let textareaId;
            if (etapaSeleccionada === 'objetivo') {
                textareaId = 'objetivo';
            } else if (etapaSeleccionada === 'previas') {
                textareaId = 'descPrevia';
            } else if (etapaSeleccionada === 'durante') {
                textareaId = 'descDurante';
            } else if (etapaSeleccionada === 'evaluacion') {
                textareaId = 'descEvaluacion';
            }

            // Agregar la descripción en el textarea seleccionado
            const textarea = document.getElementById(textareaId);
            textarea.value += descripcion + ",";

            // Vaciar el input después de cargar
            document.getElementById('descripcionInput').value = '';
        }

        
        // Función para cargar responsables en el textarea correspondiente
        function cargarResponsable() {
        const responsableSeleccionado = document.getElementById('respSelect').value;
        const seccionSeleccionada = document.getElementById('seccionSelect').value;
    
        let textareaId;
        if (seccionSeleccionada === 'previas') {
            textareaId = 'respPrevia';
        } else if (seccionSeleccionada === 'durante') {
            textareaId = 'respDurante';
        } else if (seccionSeleccionada === 'evaluacion') {
            textareaId = 'respEvaluacion';
        }
    
        // Obtener el textarea seleccionado
        const textarea = document.getElementById(textareaId);
        let responsablesArray = textarea.value.split(',').map(item => item.trim());
    
        if (responsablesArray.includes(responsableSeleccionado)) {
            Swal.fire({
                icon: 'warning',
                title: 'Responsable ya ingresado',
                text: `El responsable "${responsableSeleccionado}" ya ha sido agregado.`,
                showCancelButton: true,
                confirmButtonText: 'Omitir',
                cancelButtonText: 'Borrar responsable'
            }).then((result) => {
                if (result.isConfirmed) {
                    return; 
                } else {
                    // Filtrar el responsable seleccionado
                    responsablesArray = responsablesArray.filter(item => item !== responsableSeleccionado);
                    textarea.value = responsablesArray.join(', ').trim();
                    Swal.fire('Borrado', `El responsable "${responsableSeleccionado}" ha sido eliminado de la lista.`, 'info');
                }
            });
            return; 
        }
    
        // Agregar el responsable en el textarea seleccionado
        textarea.value += responsableSeleccionado + ",";
    
        // Limpiar el select de responsable
        document.getElementById('respSelect').selectedIndex = 0; // Vuelve al primer elemento
    }

        // Función para habilitar o deshabilitar la edición de las áreas de texto
        function toggleEditable() {
            const textareas = document.querySelectorAll('textarea:not(#obsPrevia, #obsDurante, #obsEvaluacion)'); // Excluir los textareas de observaciones
            const objetivoInput = document.getElementById('objetivo');
            const estadoTT = document.getElementById('estadoTT');
            let allEditable = true;

            textareas.forEach(textarea => {
                textarea.readOnly = !textarea.readOnly;  // Cambia el estado de readonly
                if (textarea.readOnly) {
                    allEditable = false;  // Si al menos un textarea es readonly, no están todos habilitados
                }
            });

            // Cambiar el estado de readonly para el input de objetivo
            objetivoInput.readOnly = !objetivoInput.readOnly;
            if (objetivoInput.readOnly) {
                allEditable = false;  // Asegurarse de que la variable se actualice
            }

            // Actualizar el estado del texto
            estadoTT.textContent = allEditable ? "Habilitado" : "Deshabilitado";
        }
    </script>
</body>
</html>
