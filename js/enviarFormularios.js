document.getElementById('cargarAnexoV').addEventListener('click', function() {
    enviarFormulario('formAnexo8', '../../php/insertAnexoVIII.php');
});

document.getElementById('cargarAnexoIX').addEventListener('click', function() {
    enviarFormulario('formularioSalidaIX', '../../php/insertAnexoIX.php');
});

document.getElementById('cargarAnexoX').addEventListener('click', function() {
    enviarFormulario('formularioSalidaX', '../../php/insertAnexoX.php');
});

function enviarFormulario(formId, actionUrl) {
    var form = document.getElementById(formId);

    var formData = new FormData(form);

    fetch(actionUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
