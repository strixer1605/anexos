<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida Educativa</title>
    <link rel="stylesheet" href="../librerias/bootstrap.css">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header class="row p-1">
        <div class="col-3">
            <img src="../imagenes/eestn1.webp" alt="Logo" width="100">
        </div>
        <div class="col-6 text-center">
            <br>
            <h3>Salida Educativa</h3>
        </div>
    </header>
    
    <div class="row">
        <h2 class="col-12 text-center mt-4">VERIFICACION</h2>
        <div class="col-12 text-center mt-4"> 
            <form id="searchForm">
            <a class="btn btn-primary col-4 mt-auto"  href="directivos.php" style="border-top-left-radius: 50px; border-bottom-left-radius: 50px; border-top-right-radius: 50px; border-bottom-right-radius: 50px;" >pagina principal</a> 
                <select class="col-5 text-center mt-4 p-2" name="Bestado" style="border-top-left-radius: 50px; border-bottom-left-radius: 50px;"> 
                    <option value="pendiente">Pendiente</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="denegado">Denegado</option>
                </select>
                <input class="text-center mt-4 p-1" type="submit" value="🔍" style="border-top-right-radius: 50px; border-bottom-right-radius: 50px;">
            </form>
        </div>
    </div>
   
    <table class="table text-center">
        <thead>
            <tr>
                <th>Nombre del Proyecto</th>
                <th>Lugar a Visitar</th>
                <th>Fecha Salida</th>
                <th>Fecha Regreso</th>
                <th>Denominación Proyecto</th>
                <th>Eliminar</th>
                <th>Estado</th>
                <th>Cambiar Estado</th>
            </tr>
        </thead>
        <tbody>
          
            <?php
            include('../modulos/conexion.php');

            $sql = "SELECT * FROM anexo_iv";
            $anexoiv = mysqli_query($conexion, $sql);

            while ($resp = mysqli_fetch_assoc($anexoiv)) {
                echo '<tr class="col-12 text-center">';
                echo '<td>' . $resp['nombre_del_proyecto'] . '</td>';
                echo '<td>' . $resp['lugar_a_visitar'] . '</td>';
                echo '<td>' . $resp['fecha1'] . '</td>';
                echo '<td>' . $resp['fecha2'] . '</td>';
                echo '<td>' . $resp['denominacion_proyecto'] . '</td>';
                echo '<td><button class="btn btn-danger boton_eliminar" data-id="' . $resp['id'] . '">🗑</button></td>';
                echo '<td>' . $resp['estado'] . '</td>';
                               echo '<td class="col-4">
                    <form method="post" action="insert_usert.php" class="btn btn-success">
                        <select name="estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="aprobado">Aprobado</option>
                            <option value="denegado">Denegado</option>
                        </select>
                        <button type="button" class="cambiarEstado" data-id="' . $resp['id'] . '"> 💾</button>
                        <button type="button" class="creear_pdf" data-id="' . $resp['id'] . '"> 📄</button>

                    </form>
                </td>';

                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <style>
        footer {
            background-color: #ebebeb;
            border: 1px solid black ;
            text-align: center;
            padding: 10px;
        }
    </style>
    <footer class="row mt-5">
        <p>&copy; 2023 T.F.M COMPANY. Todos los derechos reservados.</p>
        <img class="m-auto" src="../imagenes/50años.webp" alt="50 años" height="120" width="150">
    </footer>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).on('click', '.cambiarEstado', function () {
    var id = $(this).data('id');
    var estado = $(this).parent().find('select[name="estado"]').val();

    $.post('insert_usert.php', { estado: estado, id: id }, function(data) {
        $("#estados" + id).text(estado);

        setTimeout(function() {
            location.reload();
        }, );
    });
});

    // Botón para eliminar
    $(document).on('click', '.boton_eliminar', function () {
        var id = $(this).data('id');

        $.post('delete_user.php', { id: id }, function(data) {
            location.reload();
        });
    });

    // Búsqueda
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        var estado = $('select[name="Bestado"]').val().toLowerCase();

        $('tbody tr').hide();
        $('tbody tr').each(function () {
            var estadoProyecto = $(this).find('td:eq(6)').text().toLowerCase();
            if (estadoProyecto === estado || estado === "todos") {
                $(this).show();
            }
        });
    });





    $(document).on('click', '.creear_pdf', function () {
    var id = $(this).data('id');

    // Verifica y ajusta la ruta según sea necesario
    $.get('mostrar_pdf.php', { id: id }, function(data) {
        alert("PDF generado con éxito");
    });
});

</script>