<?php
include('../modulos/conexion.php');

$sql = "SELECT * FROM anexov";
$anexov = mysqli_query($conexion, $sql);

echo '<table class="table">
    <tr>
        <td>N°</td>
        <td><center>Apellido y nombre</center></td>
        <td><center>Documento</center></td>
        <td><center>Cargo</center></td>
        <td><center>Edad</center></td>
        <td>Modificar</td>
        <td>Eliminar</td>
    </tr>';

while ($resp = mysqli_fetch_assoc($anexov)) {
    echo '<tr>
        <td>' . $resp['n'] . '</td>
        <td><center>' . $resp['apellido_y_nombre'] . '</center></td>
        <td><center>' . $resp['documento'] . '</center></td>
        <td><center>' . $resp['cargo'] . '</center></td>
        <td><center>' . $resp['edad'] . '</center></td>
        <td><a href="editar.php"><button type="button" class="btn btn-info">✎</button></a></td>
        <td><a href="anexoV.php"><button class="btn btn-danger boton_eliminar" data-dni=' . $resp['n'] . '>🗑</button></a></td>
    </tr>';
}

echo '</table>';
?>

<script>
$('.boton_eliminar').click(function () {
    let n = $(this).attr('data-dni');
    $.post('delete_user.php', { n: n }, function (data) {
        console.log(data);
        // Recarga la tabla de usuarios después de eliminar
        cargarTablaUsuarios();
    });
});

function cargarTablaUsuarios() {
    location.reload();
}
</script>