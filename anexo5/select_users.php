<?php
    include('../modulos/conexion.php');

    $id_salida = $_GET['id'];
    $sql = "SELECT * FROM anexo_v WHERE fk_anexoIV = $id_salida";
    $anexov = mysqli_query($conexion, $sql);

    echo '
        <table class="table">
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
            $cargo_lista = $resp['cargo'];
            switch ($cargo_lista){
                case 1: $cargo_lista = "Director";
                break;
                case 2: $cargo_lista = "Profesor";
                break;
                case 3: $cargo_lista = "Alumno";
                break;
                case 4: $cargo_lista = "Acompañante";
                break;
            }
            echo '
            <tr>
                <td><center>?</center></td>
                <td><center>' . $resp['apellido_y_nombre'] . '</center></td>
                <td><center>' . $resp['documento'] . '</center></td>
                <td><center>' . $cargo_lista . '</center></td>
                <td><center>' . $resp['edad'] . '</center></td>
                <td><a href="editar.php"><button type="button" class="btn btn-info">✎</button></a></td>
                <td><a href="anexoV.php"><button class="btn btn-danger boton_eliminar" data-dni="' . $resp['documento'] . '">🗑</button></a></td>
            </tr>';
        }

    echo 
        '</table>';
?>

<script>
    $('.boton_eliminar').click(function () {
        let n = $(this).attr('data-dni');
        $.post('delete_user.php', { n: n }, function (data) {
            console.log(data);
            cargarTablaUsuarios();
        });
    });


    
    function cargarTablaUsuarios() {
        location.reload();
    }
</script>

<script>
    $(document).ready(function() {
        var dni_encargo = '<?php echo $dni_encargado; ?>';
        $('.boton_eliminar').each(function() {
            if ($(this).data('dni') == dni_encargo) {
                $(this).remove();
            }
        });
    });
</script>