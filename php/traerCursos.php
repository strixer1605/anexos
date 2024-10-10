<?php
    $sqlCursos = "SELECT * FROM `cursos` ORDER BY ano ASC, division ASC";
    $resultCursos = $conexion->query($sqlCursos);

    echo '<div class="form-group">
            <label for="cursos" class="form-label">Seleccionar cursos de la salida</label>
            <br>
            <div class="row">
                <div class="col-md-8 col-8">
                    <select id="selectCursos" name="selectCursos" class="form-control item" required style="cursor: pointer;">';
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
                <div class="col-md-4 col-4">
                    <button type="button" class="btn btn-success w-100" id="cargarCurso">Cargar Curso</button>
                </div>
            </div>
            <div class="form-group">
                <label for="cursos" class="form-label">Cursos seleccionados:</label>
                <input type="text" class="form-control item" id="cursos" name="cursos" placeholder="Aquí aparecerán los cursos que haya ingresado..." value="' .htmlspecialchars($row['cursos'], ENT_QUOTES, 'UTF-8'). '" required readonly>
            </div>
            <p style="margin-top: 5px; margin-left: 2px;">Nota: En el caso de querer quitar un curso: Vuélvalo a seleccionar, haga click en "Cargar Curso" y luego en "Borrar curso".</p>
          </div>';
?>
