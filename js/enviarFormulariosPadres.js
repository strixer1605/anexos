document.addEventListener('DOMContentLoaded', function () {
    function validateAndSubmitAnexoVI(event) {
        event.preventDefault();

        let esValido = true;
        const obraSi = document.getElementById('obraSi');
        const obraNo = document.getElementById('obraNo');

        // Validación: Debe seleccionar si tiene obra social
        if (!obraSi.checked && !obraNo.checked) {
            esValido = false;
            
            Swal.fire({
                icon: 'error',
                title: 'Campo obligatorio',
                text: 'Debe indicar si el alumno tiene Obra Social.',
            }).then(() => {
                setTimeout(() => {
                    obraSi.focus();
                    obraSi.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 500);
            });
            return esValido;  // Detiene el envío si no es válido
        }

        // Validación: Si seleccionó "Sí" en obra social, debe completar nombre y número
        if (obraSi.checked) {
            const nombreObra = document.getElementById('nomObra');
            const nroObra = document.getElementById('nroObra');

            if (nombreObra.value.trim() === "" || nroObra.value.trim() === "") {
                esValido = false;

                Swal.fire({
                    icon: 'error',
                    title: 'Campo obligatorio',
                    text: 'Debe indicar nombre de Obra social / Prepaga y su n° de socio obligatoriamente.',
                }).then(() => {
                    setTimeout(() => {
                        nombreObra.focus();
                        nombreObra.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 500);
                });
                return esValido;  // Detiene el envío si no es válido
            }
        }

        if (esValido) {
            // Crear FormData para enviar al servidor
            const formData = new FormData();
            formData.append('constancia', document.getElementById('constancia').value);
            formData.append('obraSocial', obraSi.checked ? 1 : 0);  // 1 si tiene obra social, 0 si no
            formData.append('nombreObra', document.getElementById('nomObra').value);
            formData.append('nroObra', document.getElementById('nroObra').value);

            // Enviar datos usando fetch
            fetch('../../php/insertAnexoVI.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())  // Esperar respuesta en JSON
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Anexo 6 cargado correctamente.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    // Mostrar mensaje de error si no fue exitoso
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Ocurrió un error al enviar los datos.'
                    });
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'Ocurrió un error en la conexión. Inténtalo de nuevo más tarde.'
                });
            });
        }
    }

    document.getElementById('cargarAnexoVI').addEventListener('click', validateAndSubmitAnexoVI);

    // Validación al presionar Enter en cualquier campo del formulario
    const formFields = document.querySelectorAll('#domicilio, #altura, #localidad');
    formFields.forEach(field => {
        field.addEventListener('keydown', handleEnterKey);
    });
});
