<?php
    $sqlMaterias = "SELECT `id`, `nombre` FROM `materias` WHERE estado = 'H'";
    $resultMaterias = $conexion->query($sqlMaterias);
    
    echo '<div class="form-group">
            <label for="materias" class="form-label">Seleccionar materias de la salida</label>
            <br>
            <div class="row g-2"> <!-- Añadido margen entre columnas -->
                <div class="col-md-9 col-12"> <!-- Ocupa todo el ancho en pantallas pequeñas -->
                    <select id="selectMaterias" name="selectMaterias" class="form-select item-anexo8" required style="cursor: pointer;">';
                    if ($resultMaterias === false) {
                        echo "Error en la consulta: " . $conexion->error;
                    } else {
                        if ($resultMaterias->num_rows > 0) {
                            while ($materia = $resultMaterias->fetch_assoc()) {
                                echo '<option value="'.$materia['id'].'">'.$materia['nombre'].'</option>';
                            }
                        } else {
                            echo '<option value="">No hay materias disponibles</option>';
                        }
                        $resultMaterias->close();
                    }
                    echo '
                    </select>
                </div>
                <div class="col-md-3 col-12"> <!-- Coloca el botón abajo en pantallas pequeñas -->
                    <button type="button" class="cargar w-100" id="cargarMateria">Cargar Materia</button>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="materias" class="form-label">Materias seleccionadas:</label>
            <input type="text" class="form-control item-anexo8" id="materias" name="materias" placeholder="Aquí aparecerán las materias que haya ingresado..." value="' .htmlspecialchars($row['area'], ENT_QUOTES, 'UTF-8'). '" required readonly>
        </div>
        <p class="mt-2 text-muted" style="font-size: 0.9rem;">
            Nota: En el caso de querer quitar una materia: Vuélvalo a seleccionar, haga click en "Cargar Materia" y luego en "Borrar Materia".
        </p>
        <br>';
?>
