document.addEventListener("DOMContentLoaded", function() {
    var anexo8Div = document.getElementById('anexo8');
    var anexo9Div = document.getElementById('anexo9');
    var anexo10Div = document.getElementById('anexo10');

    var anexo8DivTab = document.getElementById('anexo8-tab');
    var anexo9DivTab = document.getElementById('anexo9-tab');
    var anexo10DivTab = document.getElementById('anexo10-tab');

    if (anexoVIIIHabil === "0") {
        anexo8Div.style.display = 'none';
        anexo8DivTab.style.display = 'none';
    }

    if (anexoIXHabil === "0") {
        anexo9Div.style.display = 'none';
        anexo9DivTab.style.display = 'none';
    }

    if (anexoXHabil === "0") {
        anexo10Div.style.display = 'none';
        anexo10DivTab.style.display = 'none';
    }

    document.getElementById('cargarAnexoVIII').addEventListener('click', function() {
        enviarFormulario('formAnexoVIII', '../../php/insertAnexoVIII.php', 'Anexo 8 cargado correctamente!', 'anexo9-tab');
    });
    
    document.getElementById('cargarAnexoIX').addEventListener('click', function() {
        enviarFormulario('formAnexoIX', '../../php/insertAnexoIX.php', 'Anexo 9 cargado correctamente!', 'anexo10-tab');
    });
    
    document.getElementById('cargarAnexoX').addEventListener('click', function() {
        enviarFormulario('formAnexoX', '../../php/insertAnexoX.php', 'Anexo 10 cargado correctamente!', null);  // No hay siguiente tab
    });
    
    function enviarFormulario(formId, actionUrl, successMessage, nextTabId) {
        var form = document.getElementById(formId);
        var formData = new FormData(form);
    
        fetch(actionUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: successMessage,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (nextTabId != null) {
                        document.getElementById(nextTabId).disabled = false;
                        $('#' + nextTabId).tab('show');
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al cargar el anexo',
                    text: data,
                    confirmButtonText: 'Intentar de nuevo'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error en la conexión',
                text: 'No se pudo conectar al servidor. Por favor intenta de nuevo.',
                confirmButtonText: 'Ok'
            });
        });
    }    
});