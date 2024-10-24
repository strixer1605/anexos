document.addEventListener("DOMContentLoaded", function() {
    var anexoVIIIDiv = document.getElementById('anexoVIII');
    var anexoVIIIDivTab = document.getElementById('anexoVIII-tab');
    // const nextTab = anexoIXHabil === "1" ? "anexo9-tab" : "anexo-tab"
    
    if (anexoVIIIHabil === "0") {
        if (anexoVIIIDiv) anexoVIIIDiv.style.display = 'none';
        if (anexoVIIIDivTab) anexoVIIIDivTab.style.display = 'none';
    }
    
    function validateAndSubmitAnexoVIII(event) {
        let firstInvalidField = null;
    
        const otrosCampos = [
            'razonSocial',
            'domicilioTransporte',
            'domicilioResponsable',
            'titularidadVehiculo',
            'companiaAseguradora',
            'numeroPoliza',
            'tipoSeguro',
            'nombreConductor1',
            'dniConductor1',
            'licenciaConductor1',
            'vigenciaConductor1'
        ];

        for (let id of otrosCampos) {
            const element = document.getElementById(id);
            if (element && element.value.trim() === '') {
                if (!firstInvalidField) {
                    firstInvalidField = element;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo Obligatorio',
                    text: `El campo "${element.previousElementSibling.textContent}" es obligatorio.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        element.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }
    
        const camposSoloNumeros = [
            { id: 'numeroPoliza', nombre: 'Número de Póliza' },
            { id: 'dniConductor1', nombre: 'DNI del Conductor 1' },
            { id: 'licenciaConductor1', nombre: 'Licencia del Conductor 1' }
        ];
    
        for (let campo of camposSoloNumeros) {
            const element = document.getElementById(campo.id);
            if (!element) continue;
            const value = element.value.trim();
    
            if (!/^\d+$/.test(value)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Valor Inválido',
                    text: `El campo "${campo.nombre}" debe contener solo números.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        element.focus();
                        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }
    
        // Verificar que los nombres de conductores no contengan números.
        const camposSoloTexto = [
            { id: 'nombreConductor1', nombre: 'Nombre del Conductor 1' },
            { id: 'nombreConductor2', nombre: 'Nombre del Conductor 2' }
        ];
        
        for (let campo of camposSoloTexto) {
            const element = document.getElementById(campo.id);
            if (!element) continue; // Si el elemento no existe, salta a la siguiente iteración.
            const value = element.value.trim();
        
            // Verificar solo si el campo no está vacío.
            if (value) {
                // Verificación: permitir solo letras y espacios.
                if (!/^[a-zA-Z\s]+$/.test(value)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Nombre Inválido',
                        text: `El campo "${campo.nombre}" debe contener solo letras.`,
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        setTimeout(() => {
                            element.focus();
                            element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 500);
                    });
                    event.preventDefault();
                    return;
                }
            }
        }        
    
        // Verificación de teléfonos.
        const telefonos = [
            { id: 'telefonoTransporte', maxDigits: 13, allowDashes: false },
            { id: 'telefonoResponsable', maxDigits: 13, allowDashes: false }
        ];
    
        for (let telefono of telefonos) {
            const element = document.getElementById(telefono.id);
            if (!element) continue;
            const value = element.value.trim();
            const regex = telefono.allowDashes ? /^[\d-]{10,13}$/ : /^\d{10,13}$/;
    
            if (!regex.test(value)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Número de Teléfono Inválido',
                    text: `El campo "${document.querySelector(`label[for=${telefono.id}]`).textContent}" debe contener solo números, con un máximo de 13.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        element.focus();
                        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 500);
                });
                event.preventDefault();
                return;
            }
    
            if (value.replace(/-/g, '').length > telefono.maxDigits) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Número de Teléfono Excedido',
                    text: `El campo "${document.querySelector(`label[for=${telefono.id}]`).textContent}" no debe exceder los ${telefono.maxDigits} dígitos.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        element.focus();
                        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }
    
        // Verificación de DNI y licencia
        const dniLicencias = [
            { dni: 'dniConductor1', licencia: 'licenciaConductor1' },
            { dni: 'dniConductor2', licencia: 'licenciaConductor2' }
        ];
    
        for (let { dni, licencia } of dniLicencias) {
            const dniElement = document.getElementById(dni);
            const licenciaElement = document.getElementById(licencia);
            if (!dniElement || !licenciaElement) continue;
            const dniValue = dniElement.value.trim();
            const licenciaValue = licenciaElement.value.trim();
    
            // Solo validar si los campos están llenos
            if (dniValue && licenciaValue) {
                if (dniValue.length < 7 || dniValue.length > 8 || dniValue !== licenciaValue) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'DNI o Licencia Inválidos',
                        text: 'El DNI y la Licencia deben tener entre 7 y 8 dígitos y deben coincidir.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        setTimeout(() => {
                            dniElement.focus();
                            dniElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 500);
                    });
                    event.preventDefault();
                    return;
                }
            }
        }
    
        // Verificación de fechas
        const fechaVigenciaConductor1 = document.getElementById('vigenciaConductor1');
        const fechaVigenciaConductor2 = document.getElementById('vigenciaConductor2');
        const fechaActual = new Date();
        const fechaLimite = new Date('2100-01-01');
    
        if (fechaVigenciaConductor1) {
            const fechaVigenciaValue1 = new Date(fechaVigenciaConductor1.value);
            if (fechaVigenciaValue1 <= fechaActual || fechaVigenciaValue1 >= fechaLimite) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha de Vigencia Inválida',
                    text: 'La fecha de vigencia del Conductor 1 debe ser posterior a hoy y no mayor a 1 de enero del 2100.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        fechaVigenciaConductor1.focus();
                        fechaVigenciaConductor1.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }
    
        if (fechaVigenciaConductor2) {
            const fechaVigenciaValue2 = new Date(fechaVigenciaConductor2.value);
            if (fechaVigenciaValue2 && (fechaVigenciaValue2 <= fechaActual || fechaVigenciaValue2 >= fechaLimite)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha de Vigencia Inválida',
                    text: 'La fecha de vigencia del Conductor 2 debe ser posterior a hoy y no mayor a 1 de enero del 2100.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        fechaVigenciaConductor2.focus();
                        fechaVigenciaConductor2.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }

        const conductor2 = [
            'nombreConductor2',
            'dniConductor2',
            'licenciaConductor2',
            'vigenciaConductor2'
        ];
        
        // Variable para controlar campo lleno
        let hayCampoLleno = false;
        
        // Primer bucle para verificar si hay algún campo lleno
        for (let idCon2 of conductor2) {
            const element = document.getElementById(idCon2);
            if (element && element.value.trim() !== '') {
                hayCampoLleno = true;
                break;
            }
        }
        
        if (hayCampoLleno) {
            for (let idCon2 of conductor2) {
                const element = document.getElementById(idCon2);
                if (element && element.value.trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campo Obligatorio',
                        text: `El campo "${element.previousElementSibling.textContent}" es obligatorio.`,
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        setTimeout(() => {
                            element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            element.focus();
                        }, 500);
                    });
                    event.preventDefault();
                    return;
                }
            }
        }
        
        // Verificar la carga de imágenes
        const imagenes = [
            'cedulaTransporte',
            'certificadoAptitudTecnica',
            'crnt',
            'vtvNacion',
            'certificadoInspeccionVtvNacion',
            'registroControlModelo',
            'vtvProvincia',
            'documentacionConductores'
        ];
    
        for (let imagen of imagenes) {
            const archivo = document.getElementById(imagen).files[0];
            const archivoPrevio = document.querySelector(`a[data-file-for=${imagen}]`);
    
            if (!archivo && !archivoPrevio) {
                if (!firstInvalidField) {
                    firstInvalidField = document.getElementById(imagen);
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Imagen Requerida',
                    text: `El archivo "${document.querySelector(`label[for=${imagen}]`).textContent}" es obligatorio.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    document.getElementById(imagen).scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        document.getElementById(imagen).focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }
    
        // Enviar el formulario si todo es válido
        enviarFormulario('formAnexoVIII', '../../php/insertAnexoVIII.php', 'Anexo VIII cargado correctamente!', 'anexo5-tab');
    }

    function enviarFormulario(formId, actionUrl, successMessage, nextTabId) {
        var form = document.getElementById(formId);
        if (!form) return;

        var formData = new FormData(form);

        fetch(actionUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'success') {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                Swal.fire({
                    icon: 'success',
                    title: successMessage,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (nextTabId) {
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

    document.getElementById('cargarAnexoVIII').addEventListener('click', validateAndSubmitAnexoVIII);
});
