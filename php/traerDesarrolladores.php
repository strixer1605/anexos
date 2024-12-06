<?php

include 'conexion.php';
// Consulta SQL
$sql = "SELECT * FROM desarrolladores";
$result = $conexion->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Iterar sobre cada resultado
    while ($row = $result->fetch_assoc()) {
        // Asignar valores desde la base de datos
        $nombre = $row['nombre']; // Campo 'nombre'
        $nombreCompleto = $row['nombreCompleto']; // Campo 'nombreCompleto'
        $foto = $row['foto']; // Campo 'foto' (ruta de la imagen)
        $rol = $row['rol']; // Campo 'rol' (descripción del desarrollador)
        $descripcion = $row['descripcion']; // Campo 'descripcion' (detalle del desarrollador)
        $linkedin = $row['linkedin']; // Campo 'linkedin' (contacto con el desarrollador)

        // Generar la tarjeta
        echo "
        <div class=\"card\">
            <img src=\"$foto\" alt=\"Foto de $nombreCompleto\">
            <div class=\"card-body\">
                <h5 class=\"card-title\">$nombreCompleto</h5>
                <p class=\"card-text\">$rol</p>
                <button class=\"btn btn-primary\" onclick=\"showInfo('$nombre', '$descripcion', '$linkedin')\">Más sobre $nombre</button>
            </div>
        </div>
        ";
    }
} else {
    echo "<p>No hay desarrolladores registrados.</p>";
}

// Cerrar conexión
$conexion->close();
?>
