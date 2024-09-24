<?php
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    include ('conexion.php');

    //Leer el cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    // Si se leyó será true, sino recibe por post
    $opcion = $data['opcion'] ?? $_POST['opcion'] ?? null;

    switch($opcion){
        case 'agregarPersona':
            if (isset($_POST['idAnexoIV'], $_POST['dni'], $_POST['nombreApellido'], $_POST['fechan'], $_POST['cargo'])) {
                $idAnexoIV = $_POST['idAnexoIV'];
                $dni = $_POST['dni'];
                $nombreApellido = $_POST['nombreApellido'];
                $fechan = $_POST['fechan'];
                $fechaActual = date("Y-m-d");
                
                // Convertir las fechas en objetos DateTime
                $fechaNacimiento = new DateTime($fechan);
                $fechaHoy = new DateTime($fechaActual);
                
                // Calcular la diferencia entre las dos fechas
                $diferencia = $fechaHoy->diff($fechaNacimiento);
                
                // Obtener la edad en años
                $edad = $diferencia->y;
                $cargo = $_POST['cargo'];
                
                $sqlVerificar = "SELECT fkAnexoIV, dni FROM `anexov` WHERE dni = ? AND fkAnexoIV = ?";
                $stmtVerificar = $conexion->prepare($sqlVerificar);
                if ($stmtVerificar) {
                    $stmtVerificar->bind_param('ii', $dni, $idAnexoIV);
                    $stmtVerificar->execute();
                    $resultVerificar = $stmtVerificar->get_result();
                    if ($resultVerificar->num_rows > 0) {
                        echo json_encode(['status' => 'error', 'message' => 'La persona cargada ya está registrada en la salida']);
                    } else {
                        $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conexion->prepare($sqlInsert);
                        if ($stmt) {
                            $stmt->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);
                            if ($stmt->execute()) {
                                $campoActualizar = ($cargo == 2) ? 'cantidadDocentes' : 'cantidadAlumnos';  // cargo 2 para docente, otro valor para alumno
                                
                                $sqlUpdate = "UPDATE anexoIV SET $campoActualizar = $campoActualizar + 1 WHERE idAnexoIV = ?";
                                $stmtUpdate = $conexion->prepare($sqlUpdate);
                                $stmtUpdate->bind_param('i', $idAnexoIV);
                                $stmtUpdate->execute();
                                $stmtUpdate->close();
                                
                                $sqlSelect = "SELECT dni, apellidoNombre, edad, cargo FROM anexov WHERE fkAnexoIV = ?";
                                $stmtSelect = $conexion->prepare($sqlSelect);
                                $stmtSelect->bind_param('i', $idAnexoIV);
                                $stmtSelect->execute();
                                $result = $stmtSelect->get_result();
                                $participantes = [];
                                while ($row = $result->fetch_assoc()) {
                                    $participantes[] = $row; // Guardar cada participante en el array
                                }
                                echo json_encode(['status' => 'success', 'message' => 'Registro insertado correctamente', 'participantes' => $participantes]);
                                
                                $stmtSelect->close();
                            } else {
                                echo json_encode(['status' => 'error', 'message' => 'Error al insertar el registro: ' . $stmt->error]);
                            }
                            $stmt->close();
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta: ' . $conexion->error]);
                        }                        
                    }
                    $stmtVerificar->close();
                }
                $conexion->close();
            }
        break;

        case 'agregarAcompañante':
            
            if (isset($_POST['dniAcompañante'], $_POST['nombreAcompañante'], $_POST['edadAcompañante'])) {
                session_start();
                $idAnexoIV = $_SESSION['idSalida'];
                $dni = $_POST['dniAcompañante'];
                $nombreApellido = $_POST['nombreAcompañante'];
                $edad = intval($_POST['edadAcompañante']);

                // Verificar si el acompañante ya existe en las tablas
                $sqlVerificar = "
                    SELECT 'anexov' AS source FROM `anexov` WHERE dni = ? AND fkAnexoIV = ?
                    UNION
                    SELECT 'alumnos' AS source FROM `alumnos` WHERE dni = ?
                    UNION
                    SELECT 'personal' AS source FROM `personal` WHERE dni = ?
                ";

                $stmtVerificar = $conexion->prepare($sqlVerificar);
                if ($stmtVerificar) {
                    $stmtVerificar->bind_param('iiii', $dni, $idAnexoIV, $dni, $dni);
                    $stmtVerificar->execute();
                    $resultVerificar = $stmtVerificar->get_result();

                    if ($resultVerificar->num_rows > 0) {
                        echo json_encode(['status' => 'error', 'message' => 'El acompañante ya está registrado en una de las tablas.']);
                    } else {
                        $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES (?, ?, ?, ?, ?)";
                        $stmtInsert = $conexion->prepare($sqlInsert);
                        
                        if ($stmtInsert) {
                            $cargo = 4; // Acompañante
                        
                            $stmtInsert->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);
                        
                            if ($stmtInsert->execute()) {
                                // Actualizar la cantidad de acompañantes en anexoIV
                                $sqlUpdate = "UPDATE anexoIV SET cantidadAcompañantes = cantidadAcompañantes + 1 WHERE idAnexoIV = ?";
                                $stmtUpdate = $conexion->prepare($sqlUpdate);
                                $stmtUpdate->bind_param('i', $idAnexoIV);
                                $stmtUpdate->execute();
                                $stmtUpdate->close();
                        
                                // Obtener todos los participantes después de la inserción
                                $sqlSelect = "SELECT dni, apellidoNombre, edad, cargo FROM anexov WHERE fkAnexoIV = ?";
                                $stmtSelect = $conexion->prepare($sqlSelect);
                                $stmtSelect->bind_param('i', $idAnexoIV);
                                $stmtSelect->execute();
                                $result = $stmtSelect->get_result();
                        
                                $participantes = [];
                                while ($row = $result->fetch_assoc()) {
                                    $participantes[] = $row;
                                }
                        
                                echo json_encode(['status' => 'success', 'message' => 'Acompañante registrado correctamente', 'participantes' => $participantes]);
                                $stmtSelect->close();
                            } else {
                                echo json_encode(['status' => 'error', 'message' => 'Error al insertar el registro: ' . $stmtInsert->error]);
                            }
                            $stmtInsert->close();
                        }                        
                    }
                    $stmtVerificar->close();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta de verificación: ' . $conexion->error]);
                }
                $conexion->close();
            } 
        break;

        case 'agregarGrupo':
            session_start();
            header('Content-Type: application/json');
        
            if (isset($data['personas']) && $data['opcion'] === 'agregarGrupo') {
                $personas = $data['personas'];
                $idAnexoIV = $_SESSION['idSalida'];
                $personasDuplicadas = [];
                
                // --------- Fase de verificación (antes de cualquier inserción) ---------
                foreach ($personas as $persona) {
                    $dni = intval($persona['dni']);
                    // Verificar duplicados
                    $sqlVerificar = "SELECT fkAnexoIV FROM `anexov` WHERE dni = ? AND fkAnexoIV = ?";
                    $stmtVerificar = $conexion->prepare($sqlVerificar);
                    $stmtVerificar->bind_param('ii', $dni, $idAnexoIV);
                    $stmtVerificar->execute();
                    $resultVerificar = $stmtVerificar->get_result();
                    
                    if ($resultVerificar->num_rows > 0) {
                        $personasDuplicadas[] = $dni;
                    }
                    
                    $stmtVerificar->close();
                }
                
                // Si hay personas duplicadas
                if (count($personasDuplicadas) > 0) {
                    echo json_encode(['status' => 'error', 'message' => 'Algunas personas ya están registradas en la salida.']);
                    exit;
                }
        
                $consultaExitosa = true;
                $cantidadInsertada = 0;

                foreach ($personas as $persona) {
                    $dni = intval($persona['dni']);
                    $nombreApellido = trim($persona['nombre'] . ' ' . $persona['apellido']);
                    $fechan = $persona['fechan'];

                    if (!$fechan || !DateTime::createFromFormat('Y-m-d', $fechan)) {
                        continue; 
                    }

                    $fechaActual = date("Y-m-d");
                    $fechaNacimiento = new DateTime($fechan);
                    $fechaHoy = new DateTime($fechaActual);
                    $edad = $fechaHoy->diff($fechaNacimiento)->y;

                    $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES (?, ?, ?, ?, ?)";
                    $stmtInsert = $conexion->prepare($sqlInsert);
                    $cargo = 3;

                    if ($stmtInsert === false) {
                        $consultaExitosa = false;
                        break;
                    }

                    $stmtInsert->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);

                    if ($stmtInsert->execute()) {
                        $cantidadInsertada++;
                    } else {
                        $consultaExitosa = false;
                        break;
                    }

                    $stmtInsert->close();
                }

                if ($consultaExitosa) {
                    // Actualizar la cantidad de alumnos en anexoIV
                    $sqlUpdate = "UPDATE anexoIV SET cantidadAlumnos = cantidadAlumnos + ? WHERE idAnexoIV = ?";
                    $stmtUpdate = $conexion->prepare($sqlUpdate);
                    $stmtUpdate->bind_param('ii', $cantidadInsertada, $idAnexoIV);
                    $stmtUpdate->execute();
                    $stmtUpdate->close();

                    echo json_encode(['status' => 'success', 'message' => 'Todas las personas procesadas correctamente.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error al insertar las personas.']);
                }

            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se recibieron personas o la opción no es válida.']);
            }
        break;    
    }
?>