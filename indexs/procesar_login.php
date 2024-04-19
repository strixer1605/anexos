<?php
// Obtener el DNI y la contraseña del formulario de inicio de sesión
$dni = $_POST['dni'];
$contrasena = $_POST['contrasena'];

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'salidaeducativa');

// Verificar la conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Prevenir la inyección SQL utilizando consultas preparadas
$sql = "SELECT tipo FROM usuarios2 WHERE usuarios_dni = ? AND password = ?";
$stmt = mysqli_prepare($conexion, $sql);

// Verificar la preparación de la consulta
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . mysqli_error($conexion));
}

// Vincular parámetros y ejecutar la consulta
mysqli_stmt_bind_param($stmt, "is", $dni, $contrasena);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verificar si la consulta fue exitosa
if ($result) {
    // Obtener el tipo de usuario
    $row = mysqli_fetch_assoc($result);
    $tipoUsuario = $row['tipo'];

    // Redirigir según el tipo de usuario
    switch ($tipoUsuario) {
        case 'Director':
            header("Location: directivos.php");
            break;
        case 'Administrador':
            header("Location: profesores.php");
            break;
        case 'Preceptor':
            header("Location: padres.php");
            break;
        default:
            echo "<script>alert('Tipo de usuario no reconocido');
             window.location.href = 'index.html';</script>";
            break;
    }
} else {
    // Error en la consulta
    echo "Error en la consulta: " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
