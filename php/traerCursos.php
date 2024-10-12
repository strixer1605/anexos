<?php
    $sqlCursos = "SELECT * FROM `cursos` ORDER BY ano ASC, division ASC";
    $resultCursos = $conexion->query($sqlCursos);

    echo '
        <div class="form-group">
            <label for="cursos" class="form-label">Seleccionar cursos de la salida</label>
            <br>
            <div class="row g-2"> <!-- Ajuste con margen entre columnas -->
                <div class="col-md-9 col-12"> <!-- Ocupa todo el ancho en pantallas pequeñas -->
                    <select id="selectCursos" name="selectCursos" class="form-select item-anexo8" required style="cursor: pointer;">';
                    if ($resultCursos === false) {
                        echo "Error en la consulta: " . $conexion->error;
                    } else {
                        if ($resultCursos->num_rows > 0) {
                            while ($curso = $resultCursos->fetch_assoc()) {
                                echo '<option value="'.$curso['id'].'">'.$curso['ano'].'º'.$curso['division'].'</option>';
                            }
                        } else {
                            echo '<option value="">No hay grupos disponibles</option>';
                        }
                        $resultCursos->close();
                    }
                    echo '
                    </select>
                </div>
                <div class="col-md-3 col-12"> <!-- Coloca el botón abajo en pantallas pequeñas -->
                    <button type="button" class="cargar w-100" id="cargarCurso">Cargar Curso</button>
                </div>                        
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="cursos" class="form-label">Cursos seleccionados:</label>
            <input type="text" class="form-control item-anexo8" id="cursos" name="cursos" placeholder="Aquí aparecerán los cursos que haya ingresado..." value="' .htmlspecialchars($row['cursos'], ENT_QUOTES, 'UTF-8'). '" required readonly>
        </div>
        <p class="mt-2 text-muted" style="font-size: 0.9rem;">
            Nota: En el caso de querer quitar un curso: Vuélvalo a seleccionar, haga click en "Cargar Curso" y luego en "Borrar curso".
        </p>
    ';
?>
