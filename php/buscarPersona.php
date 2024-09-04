<?php

include 'conexion.php';
ob_start();

$dniPersona = $_POST['dniPersona'];

if(isset($dniPersona)) {
    $sql = "SELECT dni, apellido, nombre, fechan FROM alumnos WHERE dni LIKE ?";
    $stmt = $conexion->prepare($sql);
    $dniLike = "%$dniPersona%";
    $stmt->bind_Param('s', $dniLike);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $personas = [];
    while ($row = $result->fetch_assoc()) {
        $personas[] = $row;
    }

    //limpiar cualquier posible salida previa
    ob_end_clean();
    echo json_encode($personas);
    $stmt->close();
} else {
    echo json_encode(['error' => 'No se envió el DNI']);
}
$conexion->close();

?>