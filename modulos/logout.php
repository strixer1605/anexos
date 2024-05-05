<?php
// Iniciar sesión si aún no está iniciada
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir a la página de inicio o a donde desees
header("Location: ../index.php");
exit;
?>
