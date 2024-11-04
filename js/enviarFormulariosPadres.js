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
        
            // Agregar los teléfonos al formData
            estadoFormulario.telefonos.forEach((telefono, index) => {
                formData.append(`telefono[${index}]`, telefono);
            });
        
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
                    }).then(() => {
                        window.location.replace('hijoSalida.php');
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
    
    document.getElementById('cargarAnexoVI').addEventListener('click', function(event) {
        event.preventDefault(); // Evitar el envío por defecto del formulario
        if (validarTelefono()) {
            validateAndSubmitAnexoVI(event); // Pass the event object
        }
    });

    document.getElementById('agregarTelefono').addEventListener('click', agregarTelefono);

    // Validación al presionar Enter en cualquier campo del formulario
    const formFields = document.querySelectorAll('#domicilio, #altura, #localidad');
    formFields.forEach(field => {
        field.addEventListener('keydown', handleEnterKey);
    });
});

let estadoFormulario = {
    telefonos: []
};

function showError(input, message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        confirmButtonText: 'Aceptar'
    }).then(() => {
        // Esperar brevemente para asegurar que el desplazamiento hacia arriba esté completo
        setTimeout(() => {
            input.scrollIntoView({ behavior: "smooth", block: "center" });
            input.focus();
        }, 400); // Ajusta el tiempo según sea necesario para sincronizar el scroll
    });
}

function validarTelefono() {
    let esValido = true;
    const telefonos = document.getElementById('telefonosOculto').value;

    // Validar teléfonos (al menos uno requerido)
    if (!telefonos || telefonos.split(',').length === 0) {
        esValido = false;
        showError(telefonosOculto, 'Debe indicar al menos un teléfono.');
        return esValido;
    }
    return esValido;
}

function agregarTelefono() {
    const telefonoInput = document.getElementById('telefono');
    const telefono = telefonoInput.value.trim();

    // Validar que el número no esté vacío
    if (telefono === '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debe ingresar un número de teléfono.',
            confirmButtonText: 'Aceptar'
        });
        return;
    } else if (isNaN(telefono)) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El teléfono debe contener solamente números.',
            confirmButtonText: 'Aceptar'
        });
        return;
    } else if (estadoFormulario.telefonos.includes(telefono)) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Este número de teléfono ya está agregado.',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    // Agregar el número al estado
    estadoFormulario.telefonos.push(telefono);
    actualizarTelefonosOcultos();

    // Limpiar el input
    telefonoInput.value = '';
}

// Función para actualizar los datos ocultos de los teléfonos
function actualizarTelefonosOcultos() {
    const telefonosOculto = document.getElementById('telefonosOculto');
    const listaTelefonosDiv = document.getElementById('listaTelefonos');

    // Unir los teléfonos en una cadena separada por comas
    telefonosOculto.value = estadoFormulario.telefonos.join(',');

    // Mostrar los teléfonos en una lista con un botón para eliminar
    listaTelefonosDiv.innerHTML = estadoFormulario.telefonos.map((telefono, index) => `
        <div class="telefono-container">
            <label class="telefono-label">${telefono}</label>
            <span class="telefono-button">
                <button class="btn btn-danger" onclick="eliminarTelefono(${index})">Eliminar</button>
            </span>
        </div>
    `).join('');
}

// Función para eliminar un número de teléfono
function eliminarTelefono(index) {
    // Eliminar el teléfono de la lista
    estadoFormulario.telefonos.splice(index, 1);
    
    // Actualizar la lista visible y el input oculto
    actualizarTelefonosOcultos();
}

function cargarTelefonosIniciales() {
    const telefonosOculto = document.getElementById('telefonosOculto').value;
    // Convertir la cadena de teléfonos a un array
    estadoFormulario.telefonos = telefonosOculto.split(',')
    .map(telefono => telefono.trim())
    .filter(Boolean); // Filtrar valores vacíos
    
    // Actualizar la visualización de la lista
    actualizarTelefonosOcultos();
}
cargarTelefonosIniciales();