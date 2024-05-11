<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salidas Educativas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../../librerias/bootstrap.css">
        <link rel="stylesheet" href="../../css/salidasMenu.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-dark" style="color: white; padding: 10px;">
            <div class="container-fluid">
                <img src="../../imagenes/eest.webp" alt="" id="logo">
                <a class="navbar-brand" id="title" style="color: white;">Salidas Educativas</a>
                <a href="profesores.php" class="btn btn-warning" style="color: white;">Atrás</a>
            </div>
        </nav>
        <br>
        <div class="container">
            <header class="row p-3 bg-primary text-white">
                <div class="col-12 text-center">
                    <h3 class="my-0">Aprobar Salidas Educativas</h3>
                </div>
            </header>
        
            <div class="row mt-4">
                <div class="col-md-6 offset-md-3 text-center mt-4 d-flex align-items-end justify-content-center">
                    <form id="searchForm" class="d-flex">
                        <select class="form-select mb-2 me-2" name="Bestado" style="width: 200px;">
                            <option value="todos">Todos</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="aprobado">Aprobado</option>
                            <option value="denegado">Denegado</option>
                        </select>
                        <button class="btn btn-primary mb-2" type="submit">🔍</button>
                    </form>
                </div>
            </div>
    
            <div class="row mt-4">
                <div class="col-12">
                    <table class="table table-striped text-center">
                        <thead class="bg-primary text-white">
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
                        <tbody id="proyectosTabla">
                            <?php
                                include('../../modulos/conexion.php');

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
                                        echo '<td id="estados' . $resp['id'] . '">' . $resp['estado'] . '</td>';
                                        echo '<td class="col-4">
                                                <form method="post" action="insert_usert.php" class="btn btn-success">
                                                    <select name="estado">
                                                        <option value="pendiente">Pendiente</option>
                                                        <option value="aprobado">Aprobado</option>
                                                        <option value="denegado">Denegado</option>
                                                    </select>
                                                    <button type="button" class="cambiarEstado" data-id="' . $resp['id'] . '">💾</button>
                                                    <button type="button" class="creear_pdf" data-id="' . $resp['id'] . '"> 📄</button>
                                                </form>
                                            </td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

        <script>
            $(document).on('click', '.cambiarEstado', function () {
                var id = $(this).data('id');
                var estado = $(this).parent().find('select[name="estado"]').val();

                $.post('insert_usert.php', { estado: estado, id: id }, function(data) {
                    $("#estados" + id).text(estado);

                    setTimeout(function() {
                        location.reload();
                    });
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
                $.get('mostrar_pdf.php', { id: id }, function(data) {
                    alert("PDF generado con éxito");
                });
            });
        </script>
    </body>
</html>