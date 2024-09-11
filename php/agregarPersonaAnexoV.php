<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
include 'conexion.php';

//leer el cuerpo de la solicitud
$input = file_get_contents('php://input');
$data = json_decode($input, true);
// si se leyó será true, sino recibe por post
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
            
            //consulta para verificar que no se repitan los datos
            $sqlVerificar = "SELECT fkAnexoIV, dni FROM `anexov` WHERE dni = ? AND fkAnexoIV = ?";
            $stmtVerificar = $conexion->prepare($sqlVerificar);
            if ($stmtVerificar) {
                $stmtVerificar->bind_param('ii', $dni, $idAnexoIV);
                $stmtVerificar->execute();
                $resultVerificar = $stmtVerificar->get_result();
                if ($resultVerificar->num_rows > 0) {
                    echo json_encode(['status' => 'error', 'message' => 'La persona cargada ya está registrada en la salida']);
                } else {
                    // Preparar y ejecutar la consulta de inserción
                    $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conexion->prepare($sqlInsert);
                    if ($stmt) {
                        // Bindear los parámetros: 'i' para integer, 's' para string
                        $stmt->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);
                        if ($stmt->execute()) {
                            // Obtener todos los participantes después de la inserción
                            $sqlSelect = "SELECT dni, apellidoNombre, edad, cargo FROM anexov WHERE fkAnexoIV = ?";
                            $stmtSelect = $conexion->prepare($sqlSelect);
                            $stmtSelect->bind_param('i', $idAnexoIV);
                            $stmtSelect->execute();
                            $result = $stmtSelect->get_result();
                            $participantes = [];
                            while ($row = $result->fetch_assoc()) {
                                $participantes[] = $row; // Guardar cada participante en el array
                            }
                            // Devolver la respuesta JSON con el estado y los participantes
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
                    // Preparar y ejecutar la consulta de inserción
                    $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES (?, ?, ?, ?, ?)";
                    $stmtInsert = $conexion->prepare($sqlInsert);

                    if ($stmtInsert) {
                        // Asignar un cargo correspondiente, puedes modificarlo según tu lógica
                        $cargo = 4; // Por ejemplo, 4 para acompañante

                        $stmtInsert->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);

                        if ($stmtInsert->execute()) {
                            // Obtener todos los participantes después de la inserción
                            $sqlSelect = "SELECT dni, apellidoNombre, edad, cargo FROM anexov WHERE fkAnexoIV = ?";
                            $stmtSelect = $conexion->prepare($sqlSelect);
                            $stmtSelect->bind_param('i', $idAnexoIV);
                            $stmtSelect->execute();
                            $result = $stmtSelect->get_result();

                            $participantes = [];
                            while ($row = $result->fetch_assoc()) {
                                $participantes[] = $row; // Guardar cada participante en el array
                            }

                            // Devolver la respuesta JSON con el estado y los participantes
                            echo json_encode(['status' => 'success', 'message' => 'Acompañante registrado correctamente', 'participantes' => $participantes]);

                            $stmtSelect->close();
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'Error al insertar el registro: ' . $stmtInsert->error]);
                        }

                        $stmtInsert->close();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta de inserción: ' . $conexion->error]);
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
                
                if($resultVerificar->num_rows > 0) {
                    $personasDuplicadas[] = $dni;
                }
                
                $stmtVerificar->close();
            }
            if (count($personasDuplicadas) > 0) {
                echo json_encode(['status' => 'error', 'message' =>'Algunas personas ya están registradas en la salida.']);
                exit;
            }
            $consultaExitosa = true;
            foreach ($personas as $persona) {
                // Validar y extraer datos
                $dni = intval($persona['dni']);
                $nombreApellido = trim($persona['nombre'] . ' ' . $persona['apellido']);
                $fechan = $persona['fechan'];
                if (!$fechan || !DateTime::createFromFormat('Y-m-d', $fechan)) {
                    continue; // Saltar si la fecha no es válida
                }
                //calculo de edad
                $fechaActual = date("Y-m-d");
                $fechaNacimiento = new DateTime($fechan);
                $fechaHoy = new DateTime($fechaActual);
                $edad = $fechaHoy->diff($fechaNacimiento)->y;
                $sqlInsert = "INSERT INTO anexov (`fkAnexoIV`, `dni`, `apellidoNombre`, `edad`, `cargo`) VALUES (?, ?, ?, ?, ?)";
                $stmtInsert = $conexion->prepare($sqlInsert);
                $cargo = 3; // Asignar el cargo correspondiente
                if ($stmtInsert === false) {
                    $consultaExitosa = false;
                    break;
                }
                $stmtInsert->bind_param('iisii', $idAnexoIV, $dni, $nombreApellido, $edad, $cargo);
                
                if (!$stmtInsert->execute()) {
                    $consultaExitosa = false;
                    break;
                }
                $stmtInsert->close();
                
            }
            if ($consultaExitosa) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Todas las personas procesadas correctamente.']);
            }
        }    else {
            echo json_encode(['status' => 'error', 'message' => 'No se recibieron personas.']);
        }
    break;
}
?>