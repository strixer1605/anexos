<?php
    $estado = $_POST['estadoSelect'];

    switch ($estado) {
        case 0:
            $resultados = obtenerResultadosEstado0();
            break;
        case 1:
            $resultados = obtenerResultadosEstado1();
            break;
        case 2:
            $resultados = obtenerResultadosEstado2();
            break;
        case 3:
            $resultados = obtenerResultadosEstado3();
            break;
        
        default:
            $resultados = "<tr><td colspan='7'>No se encontraron resultados para este estado.</td></tr>";
            break;
    }

    // Devolver los resultados al JavaScript
    echo $resultados;

    function obtenerResultadosEstado0() {
        include('../../modulos/conexion.php');
        $sql0 = "SELECT * FROM `anexo_iv` WHERE 1";
        $query0 = mysqli_query($conexion, $sql0);

        if ($query0) {
            $resultados = "";
            while ($resp = mysqli_fetch_assoc($query0)) {
                $resultados .= '<tr class="col-12 text-center">';
                $resultados .= '<td>' . $resp['nombre_del_proyecto'] . '</td>';
                $resultados .= '<td>' . $resp['lugar_a_visitar'] . '</td>';
                $resultados .= '<td>' . $resp['fecha1'] . '</td>';
                $resultados .= '<td>' . $resp['fecha2'] . '</td>';
                $resultados .= '<td>' . $resp['denominacion_proyecto'] . '</td>';
                
                $sql2 = "SELECT fk_anexoIV FROM anexo_v WHERE fk_anexoIV ='".$resp['id']."'";
                $anexov = mysqli_query($conexion, $sql2);

                if ($anexov -> num_rows > 1) {
                    $resultados .= '<td>Tiene alumnos inscriptos (Adjunta Anexo 5)</td>';
                }
                else{
                    $resultados .= '<td>No tiene alumnos inscriptos</td>';
                }

                $sql3 = "SELECT fk_anexoIV FROM anexo_viii WHERE fk_anexoIV ='".$resp['id']."'";
                $anexoviii = mysqli_query($conexion, $sql3);

                if ($anexoviii -> num_rows > 0) {
                    $resultados .= '<td>Tiene actividades asignadas (Adjunta Anexo 8)</td>';
                }
                else{
                    $resultados .= '<td>No tiene actividades asignadas</td>';
                }
    
                $resultados .= '<td><button class="btn btn-danger boton_eliminar" data-id="' . $resp['id'] . '">🗑</button></td>';
                $resultados .= '<td id="estados' . $resp['id'] . '">' . $resp['estado'] . '</td>';
                $resultados .= '<td>
                                    <form method="post" action="insert_usert.php">
                                        <select name="estado">
                                            <option value="pendiente">Pendiente</option>
                                            <option value="aprobado">Aprobado</option>
                                            <option value="denegado">Denegado</option>
                                        </select>
                                        <button type="button" class="cambiarEstado" data-id="' . $resp['id'] . '">💾</button>
                                    </form>
                                </td>';
                $resultados .= '</tr>';
            }
            return $resultados;
        } else {
            return "<tr><td colspan='7'>Error al ejecutar la consulta.</td></tr>";
        }
    }

    function obtenerResultadosEstado1() {
        include('../../modulos/conexion.php');
        $sql0 = "SELECT * FROM `anexo_iv` WHERE estado = 1";
        $query0 = mysqli_query($conexion, $sql0);

        if ($query0) {
            $resultados = "";
            while ($resp = mysqli_fetch_assoc($query0)) {
                $resultados .= '<tr class="col-12 text-center">';
                $resultados .= '<td>' . $resp['nombre_del_proyecto'] . '</td>';
                $resultados .= '<td>' . $resp['lugar_a_visitar'] . '</td>';
                $resultados .= '<td>' . $resp['fecha1'] . '</td>';
                $resultados .= '<td>' . $resp['fecha2'] . '</td>';
                $resultados .= '<td>' . $resp['denominacion_proyecto'] . '</td>';
                
                $sql2 = "SELECT fk_anexoIV FROM anexo_v WHERE fk_anexoIV ='".$resp['id']."'";
                $anexov = mysqli_query($conexion, $sql2);

                if ($anexov -> num_rows > 1) {
                    $resultados .= '<td>Tiene alumnos inscriptos (Adjunta Anexo 5)</td>';
                }
                else{
                    $resultados .= '<td>No tiene alumnos inscriptos</td>';
                }

                $sql3 = "SELECT fk_anexoIV FROM anexo_viii WHERE fk_anexoIV ='".$resp['id']."'";
                $anexoviii = mysqli_query($conexion, $sql3);

                if ($anexoviii -> num_rows > 0) {
                    $resultados .= '<td>Tiene actividades asignadas (Adjunta Anexo 8)</td>';
                }
                else{
                    $resultados .= '<td>No tiene actividades asignadas</td>';
                }
    
                $resultados .= '<td><button class="btn btn-danger boton_eliminar" data-id="' . $resp['id'] . '">🗑</button></td>';
                $resultados .= '<td id="estados' . $resp['id'] . '">' . $resp['estado'] . '</td>';
                $resultados .= '<td>
                                    <form method="post" action="insert_usert.php">
                                        <select name="estado">
                                            <option value="pendiente">Pendiente</option>
                                            <option value="aprobado">Aprobado</option>
                                            <option value="denegado">Denegado</option>
                                        </select>
                                        <button type="button" class="cambiarEstado" data-id="' . $resp['id'] . '">💾</button>
                                    </form>
                                </td>';
                $resultados .= '</tr>';
            }
            return $resultados;
        } else {
            return "<tr><td colspan='7'>Error al ejecutar la consulta.</td></tr>";
        }
    }

    function obtenerResultadosEstado2() {
        include('../../modulos/conexion.php');
        $sql0 = "SELECT * FROM `anexo_iv` WHERE estado = 2";
        $query0 = mysqli_query($conexion, $sql0);

        if ($query0) {
            $resultados = "";
            while ($resp = mysqli_fetch_assoc($query0)) {
                $resultados .= '<tr class="col-12 text-center">';
                $resultados .= '<td>' . $resp['nombre_del_proyecto'] . '</td>';
                $resultados .= '<td>' . $resp['lugar_a_visitar'] . '</td>';
                $resultados .= '<td>' . $resp['fecha1'] . '</td>';
                $resultados .= '<td>' . $resp['fecha2'] . '</td>';
                $resultados .= '<td>' . $resp['denominacion_proyecto'] . '</td>';
                
                $sql2 = "SELECT fk_anexoIV FROM anexo_v WHERE fk_anexoIV ='".$resp['id']."'";
                $anexov = mysqli_query($conexion, $sql2);

                if ($anexov -> num_rows > 1) {
                    $resultados .= '<td>Tiene alumnos inscriptos (Adjunta Anexo 5)</td>';
                }
                else{
                    $resultados .= '<td>No tiene alumnos inscriptos</td>';
                }

                $sql3 = "SELECT fk_anexoIV FROM anexo_viii WHERE fk_anexoIV ='".$resp['id']."'";
                $anexoviii = mysqli_query($conexion, $sql3);

                if ($anexoviii -> num_rows > 0) {
                    $resultados .= '<td>Tiene actividades asignadas (Adjunta Anexo 8)</td>';
                }
                else{
                    $resultados .= '<td>No tiene actividades asignadas</td>';
                }
    
                $resultados .= '<td><button class="btn btn-danger boton_eliminar" data-id="' . $resp['id'] . '">🗑</button></td>';
                $resultados .= '<td id="estados' . $resp['id'] . '">' . $resp['estado'] . '</td>';
                $resultados .= '<td>
                                    <form method="post" action="insert_usert.php">
                                        <select name="estado">
                                            <option value="pendiente">Pendiente</option>
                                            <option value="aprobado">Aprobado</option>
                                            <option value="denegado">Denegado</option>
                                        </select>
                                        <button type="button" class="cambiarEstado" data-id="' . $resp['id'] . '">💾</button>
                                    </form>
                                </td>';
                $resultados .= '</tr>';
            }
            return $resultados;
        } else {
            return "<tr><td colspan='7'>Error al ejecutar la consulta.</td></tr>";
        }
    }

    function obtenerResultadosEstado3() {
        include('../../modulos/conexion.php');
        $sql0 = "SELECT * FROM `anexo_iv` WHERE estado = 3";
        $query0 = mysqli_query($conexion, $sql0);

        if ($query0) {
            $resultados = "";
            while ($resp = mysqli_fetch_assoc($query0)) {
                $resultados .= '<tr class="col-12 text-center">';
                $resultados .= '<td>' . $resp['nombre_del_proyecto'] . '</td>';
                $resultados .= '<td>' . $resp['lugar_a_visitar'] . '</td>';
                $resultados .= '<td>' . $resp['fecha1'] . '</td>';
                $resultados .= '<td>' . $resp['fecha2'] . '</td>';
                $resultados .= '<td>' . $resp['denominacion_proyecto'] . '</td>';
                
                $sql2 = "SELECT fk_anexoIV FROM anexo_v WHERE fk_anexoIV ='".$resp['id']."'";
                $anexov = mysqli_query($conexion, $sql2);

                if ($anexov -> num_rows > 1) {
                    $resultados .= '<td>Tiene alumnos inscriptos (Adjunta Anexo 5)</td>';
                }
                else{
                    $resultados .= '<td>No tiene alumnos inscriptos</td>';
                }

                $sql3 = "SELECT fk_anexoIV FROM anexo_viii WHERE fk_anexoIV ='".$resp['id']."'";
                $anexoviii = mysqli_query($conexion, $sql3);

                if ($anexoviii -> num_rows > 0) {
                    $resultados .= '<td>Tiene actividades asignadas (Adjunta Anexo 8)</td>';
                }
                else{
                    $resultados .= '<td>No tiene actividades asignadas</td>';
                }
    
                $resultados .= '<td><button class="btn btn-danger boton_eliminar" data-id="' . $resp['id'] . '">🗑</button></td>';
                $resultados .= '<td id="estados' . $resp['id'] . '">' . $resp['estado'] . '</td>';
                $resultados .= '<td>
                                    <form method="post" action="insert_usert.php">
                                        <select name="estado">
                                            <option value="pendiente">Pendiente</option>
                                            <option value="aprobado">Aprobado</option>
                                            <option value="denegado">Denegado</option>
                                        </select>
                                        <button type="button" class="cambiarEstado" data-id="' . $resp['id'] . '">💾</button>
                                    </form>
                                </td>';
                $resultados .= '</tr>';
            }
            return $resultados;
        } else {
            return "<tr><td colspan='7'>Error al ejecutar la consulta.</td></tr>";
        }
    }
?>
