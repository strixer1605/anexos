document.getElementById('cargar').addEventListener('click', function() {
    
    enviarFormulario('formAnexo8', '../../php/insertAnexoVIII.php');
    enviarFormulario('formularioSalidaIX', '../../php/insertAnexoIX.php');
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
