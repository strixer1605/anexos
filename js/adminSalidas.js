$(document).ready(function() {
    $.ajax({
        url: '../../php/tablaAdminSalidas.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            let tabla = $('#proyectosTabla');
            // Recorrer los datos y generar las filas
            data.forEach(function(salida) {
                let fila = `
                    <tr>
                        <td>${salida.idAnexoIV}</td>
                        <td>${salida.denominacionProyecto}</td>
                        <td>${salida.tipoSolicitud}</td>
                        <td>${salida.lugarVisita}</td>
                        <td>${salida.fechaSalida}</td>
                        <td>${salida.fechaRegreso}</td>
                        <td>${salida.masDe24hs}</td>
                        <td>${salida.anexoixHabil}</td>
                        <td>${salida.anexosCompletos}</td>
                        <td>${salida.fechaLimite}</td>                        
                        <td><a href="../pdf/todoPdf.php" class="btn btn-primary">Descargar</a></td> <!-- Prevenir comportamiento -->
                        <td><button class="btn btn-success" onclick="gestionarSalida(${salida.idAnexoIV}, event)">Gestionar</button></td>
                        <td><button class="btn btn-danger" onclick="eliminarSalida(${salida.idAnexoIV}, event)">Eliminar</button></td>
                    </tr>
                `;

                tabla.append(fila);
            });
        },
        error: function(err) {
            console.log('Error al obtener los datos:', err);
        }
    });
});

function gestionarSalida(id, event) {
    event.preventDefault(); // Prevenir el comportamiento predeterminado
    // Mostrar un alert con tres botones
    Swal.fire({
        title: '¿Qué acción quiere realizar?',
        text: 'Elija si desea aprobar, desaprobar o cancelar la salida',
        icon: 'question',
        showCancelButton: true,
        showDenyButton: true, // Botón extra
        confirmButtonText: 'Aprobar',
        denyButtonText: 'Desaprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Lógica para aprobar salida
            aprobarSalida(id);
        } else if (result.isDenied) {
            // Lógica para desaprobar salida
            desaprobarSalida(id);
        } else {
            // Si se cancela, no se realiza ninguna acción.
            Swal.fire('Acción cancelada', '', 'info');
        }
    });
}

function aprobarSalida(id) {
    console.log('Aprobando salida con ID:', id);
    $.post('../../php/aprobarSalida.php', { idAnexoIV: id }, function(response) {
        console.log('Respuesta AJAX:', response); // Debug
        try {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                Swal.fire({
                    title: 'Aprobada',
                    text: res.message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        } catch (e) {
            console.log('Error al parsear respuesta:', e); // Debug
            Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
        }
    });
}

function desaprobarSalida(id) {
    console.log('Desaprobando salida con ID:', id);
    $.post('../../php/desaprobarSalida.php', { idAnexoIV: id }, function(response) {
        console.log('Respuesta AJAX:', response); // Debug
        try {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                Swal.fire({
                    title: 'Desaprobada',
                    text: res.message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        } catch (e) {
            console.log('Error al parsear respuesta:', e); // Debug
            Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
        }
    });
}

function eliminarSalida(id, event) {
    event.preventDefault(); // Prevenir el comportamiento predeterminado
    console.log('Eliminando salida con ID: ', id);
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la salida permanentemente, incluyendo todo registro asociado.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Confirmación recibida, enviando solicitud AJAX'); // Debug
            // Lógica para eliminar salida
            $.post('../../php/eliminarSalida.php', { idAnexoIV: id }, function(response) {
                console.log('Respuesta AJAX:', response); // Debug
                try {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Eliminada',
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                } catch (e) {
                    console.log('Error al parsear respuesta:', e); // Debug
                    Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
                }
            });
        }
    });
}
