// Función para validar y enviar el formulario Anexo VI
function validateAndSubmitAnexoVI(event) {
    event.preventDefault(); // Evita que el formulario se envíe antes de validar

    // Obtener los campos del formulario
    const domicilioInput = document.getElementById('domicilio');
    const localidadInput = document.getElementById('localidad');
    const alturaInput = document.getElementById('altura');

    // Obtener valores de los inputs
    const domicilio = domicilioInput.value.trim();
    const altura = alturaInput.value.trim();
    const localidad = localidadInput.value.trim();

    let isValid = true;

    // Validación de domicilio (Debe estar lleno)
    if (domicilio === '') {
        showError(domicilioInput, "El domicilio no puede estar vacío.");
        isValid = false;
    } else {
        clearError(domicilioInput);
    }

    // Validación de altura (Debe estar llena y ser numérica)
    const alturaPattern = /^\d+$/; // Solo permite números
    if (altura === '') {
        showError(alturaInput, "La altura no puede estar vacía.");
        isValid = false;
    } else if (!alturaPattern.test(altura)) {
        showError(alturaInput, "La altura debe ser un número válido.");
        isValid = false;
    } else {
        clearError(alturaInput);
    }

    // Validación de localidad (Debe estar llena)
    if (localidad === '') {
        showError(localidadInput, "La localidad no puede estar vacía.");
        isValid = false;
    } else {
        clearError(localidadInput);
    }

    // Si todo es válido, enviar el formulario por AJAX
    if (isValid) {
        const formData = new FormData();
        formData.append('domicilio', domicilio);
        formData.append('altura', altura);
        formData.append('localidad', localidad);

        // Enviar datos usando fetch
        fetch('../../php/insertAnexoVI.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json()) // Esperar a que la respuesta se convierta a JSON
        .then(data => {
            if (data.success) {
                // Si el envío fue exitoso, mostrar mensaje con SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Anexo 6 actualizado correctamente.',
                    showConfirmButton: false,
                    timer: 1500
                });
        
                // Cambiar al tab del Anexo 7 después de un breve retraso para mostrar el mensaje
                setTimeout(() => {
                    const tabAnexo7 = new bootstrap.Tab(document.getElementById('anexo7-tab'));
                    tabAnexo7.show(); // Mostrar el tab del Anexo 7
                }, 1500); // Esperar 1.5 segundos antes de cambiar de tab
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

// Mostrar mensaje de error
function showError(inputElement, message) {
    clearError(inputElement); // Limpiar errores anteriores

    // Crear elemento de error
    const errorElement = document.createElement('small');
    errorElement.classList.add('text-danger');
    errorElement.textContent = message;

    // Insertar el error debajo del input
    inputElement.parentNode.appendChild(errorElement);

    // Hacer focus en el campo inválido
    inputElement.focus();
}

// Limpiar mensaje de error
function clearError(inputElement) {
    const errorElement = inputElement.parentNode.querySelector('small');
    if (errorElement) {
        errorElement.remove();
    }
}

// Agregar la funcionalidad para detectar Enter y ejecutar la validación
function handleEnterKey(event) {
    if (event.key === "Enter") {
        validateAndSubmitAnexoVI(event); // Ejecutar la validación y el envío del formulario
    }
}

// Vincular la validación al botón de submit y al presionar Enter cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function () {
    // Validación al hacer clic en el botón
    document.getElementById('cargarAnexoVI').addEventListener('click', validateAndSubmitAnexoVI);

    // Validación al presionar Enter en cualquier campo del formulario
    const formFields = document.querySelectorAll('#domicilio, #altura, #localidad');
    formFields.forEach(field => {
        field.addEventListener('keydown', handleEnterKey);
    });
});
