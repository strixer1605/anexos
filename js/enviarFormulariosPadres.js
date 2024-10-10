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
        console.log(domicilio, altura, localidad);
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
                // Si el envío fue exitoso, llevar al siguiente tab
                alert("Insertado correctamente");
                // Cambiar al tab del Anexo 7
                const tabAnexo7 = new bootstrap.Tab(document.getElementById('anexo7-tab'));
                tabAnexo7.show(); // Mostrar el tab del Anexo 7
            } else {
                // Mostrar mensaje de error si no fue exitoso
                alert(data.message || 'Ocurrió un error al enviar los datos.');
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert('Ocurrió un error en la conexión. Inténtalo de nuevo más tarde.');
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

//revisar datos obligatorios, sobreescribir variables actuales
let estadoFormulario = {
    alergico: 0,
    aQue: '',
    sufrioA: 0,
    sufrioB: 0,
    sufrioC: 0,
    medicacion: 0,
    otrasInput: '',
    medicacionDetalles: '',
    indicaciones: '',
    obraSocial: 0
};

document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('formAnexoVII');

    formulario.addEventListener('submit', function(event) {
        if (!validarFormulario()) {
            event.preventDefault(); // Evitar el envío si hay errores de validación
        } else {
            obtenerDatosFormulario(); // Actualiza el estado y envía los datos
        }
    });
});

// Función de validación del formulario
function validarFormulario() {
    let esValido = true;

    const alergicoSi = document.getElementById('alergicoSi');
    const alergicoNo = document.getElementById('alergicoNo');

    // Validar que al menos uno de los radio buttons esté seleccionado
    if (!alergicoSi.checked && !alergicoNo.checked) {
        esValido = false;
        alert('Debe indicar si es alérgico o no.');
        alergicoSi.focus(); // Enfocar en el primer radio button
        alergicoSi.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return esValido;
    }

    // Si "Sí" está seleccionado, validar que el campo "aQue" no esté vacío
    if (alergicoSi.checked) {
        const aQue = document.getElementById('aQue'); // Obtener el input de "a qué es alérgico"
        
        if (aQue.value.trim() === "") {
            esValido = false;
            alert('Debe indicar a qué es alérgico.');
            aQue.focus(); // Enfocar en el campo "aQue"
            aQue.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return esValido;
        }
    } else {
        // Si "No" está seleccionado, asegurar que el campo "aQue" quede vacío
        document.getElementById('aQue').value = '';  // Limpiar el input
    }

    const problemasOtras = document.getElementById('otras');
    if (problemasOtras.checked) {
        const otrasInput = document.getElementById('otrasInput');
        if (otrasInput.value.trim() === "") {
            esValido = false;
            alert('Debe especificar los otros problemas recientes si ha marcado "d".');
            otrasInput.focus();
            otrasInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return esValido;
        }
    }

    const medicacionSi = document.getElementById('medicacionSi');
    const medicacionNo = document.getElementById('medicacionNo');

    if (!medicacionSi.checked && !medicacionNo.checked) {
        esValido = false;
        alert('Debe indicar si está tomando alguna medicación.');
        medicacionSi.focus();
        medicacionSi.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return esValido;
    }

    if (medicacionSi.checked) {
        const medicacionDetalles = document.getElementById('medicacionDetalles');
        if (medicacionDetalles.value.trim() === "") {
            esValido = false;
            alert('Debe indicar qué medicación está tomando.');
            medicacionDetalles.focus();
            medicacionDetalles.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return esValido;
        }
    }

    const obraSocialSi = document.getElementById('obraSocialSi');
    const obraSocialNo = document.getElementById('obraSocialNo');

    if (!obraSocialSi.checked && !obraSocialNo.checked) {
        esValido = false;
        alert('Debe indicar si tiene obra social.');
        obraSocialSi.focus();
        obraSocialSi.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return esValido;
    }

    return esValido;
}

// Función para obtener y actualizar los datos del formulario
function obtenerDatosFormulario() {
    const alergicoSi = document.getElementById('alergicoSi');
    const aQue = document.getElementById('aQue').value;

    // Actualizar el estado del formulario
    estadoFormulario.alergico = alergicoSi.checked ? 1 : 0;
    estadoFormulario.aQue = alergicoSi.checked ? aQue : ''; // Si no es alérgico, valor en blanco

    estadoFormulario.sufrioA = document.getElementById('inflamatorios').checked ? 1 : 0;
    estadoFormulario.sufrioB = document.getElementById('fracturas').checked ? 1 : 0;
    estadoFormulario.sufrioC = document.getElementById('enfermedades').checked ? 1 : 0;

    // Actualizar el valor de otrasInput basado en el checkbox sufrioD
    const sufrioD = document.getElementById('otras').checked;
    estadoFormulario.sufrioD = sufrioD ? 1 : 0; // Se actualiza solo para control interno, no se enviará al servidor
    estadoFormulario.otrasInput = sufrioD ? document.getElementById('otrasInput').value : ''; // Si sufrioD no está seleccionado, enviar cadena vacía

    // Actualizar medicación, si "No" está seleccionado, establecer los valores en blanco
    const medicacionSi = document.getElementById('medicacionSi').checked;
    estadoFormulario.medicacion = medicacionSi ? 1 : 0;
    estadoFormulario.medicacionDetalles = medicacionSi ? document.getElementById('medicacionDetalles').value : '';

    estadoFormulario.indicaciones = document.getElementById('indicaciones').value;

    // Actualizar obra social, si "No" está seleccionado, el valor queda en blanco
    const obraSocialSi = document.getElementById('obraSocialSi').checked;
    estadoFormulario.obraSocial = obraSocialSi ? 1 : 0;

    enviarDatos(estadoFormulario); // Llama a la función para enviar los datos
}

// Función para enviar los datos al servidor mediante AJAX
function enviarDatos(datos) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../php/insertAnexoVII.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function() {
        if (xhr.status === 200) {
            // console.log(xhr.responseText);
            alert ('Datos insertados correctamente');
        } else {
            console.error('Error en la solicitud:', xhr.statusText);
        }
    };

    xhr.send(JSON.stringify(datos));
}

// Llamada a la función cuando se hace clic en un botón
document.getElementById('cargarAnexoVII').addEventListener('click', function(event) {
    event.preventDefault(); // Evitar el envío por defecto del formulario
    if (validarFormulario()) {
        obtenerDatosFormulario(); // Obtiene los datos actualizados y los envía
    }
});
