<?php
    $sqlMaterias = "SELECT `id`, `nombre` FROM `materias` WHERE estado = 'H'";
    $resultMaterias = $conexion->query($sqlMaterias);
    
    echo '<div class="form-group">
            <label for="materias" class="form-label">Seleccionar materias de la salida</label>
            <br>
            <div class="row">
                <div class="col-md-9 col-8">
                    <select id="selectMaterias" name="selectMaterias" class="form-control item" required style="cursor: pointer;">';
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
                <div class="col-md-3 col-4">
                    <button type="button" class="btn btn-success w-100 cargar" id="cargarMateria">Cargar Materia</button>
                </div>
            </div>
            <div class="form-group">
                <label for="materias" class="form-label">Materias seleccionadas:</label>
                <input type="text" class="form-control item" id="materias" name="materias" placeholder="Aquí aparecerán las materias que haya ingresado..." value="' .htmlspecialchars($row['area'], ENT_QUOTES, 'UTF-8'). '" required readonly>
            </div>
            <p style="margin-top: 5px; margin-left: 2px;">Nota: En el caso de querer quitar una materia: Vuélvalo a seleccionar, haga click en "Cargar Materia" y luego en "Borrar Materia".</p>
            <br>
        </div>';
?>
