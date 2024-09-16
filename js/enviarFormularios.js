document.addEventListener("DOMContentLoaded", function() {

    var anexo8Div = document.getElementById('anexo8');
    var anexo9Div = document.getElementById('anexo9');
    var anexo10Div = document.getElementById('anexo10');

    var anexo8DivTab = document.getElementById('anexo8-tab');
    var anexo9DivTab = document.getElementById('anexo9-tab');
    var anexo10DivTab = document.getElementById('anexo10-tab');

    if (anexoVIIIHabil === "0") {
        if (anexo8Div) anexo8Div.style.display = 'none';
        if (anexo8DivTab) anexo8DivTab.style.display = 'none';
    } else if (anexoVIIIHabil === "1") {
        if (anexoIXHabil === "0") {
            var nextTabVIII = "anexo10-tab";
        } else if (anexoIXHabil === "1") {
            var nextTabVIII = "anexo9-tab";
        } else if (anexoXHabil === "0") {
            var nextTabVIII = "anexo5-tab";
        }
    }

    if (anexoIXHabil === "0") {
        if (anexo9Div) anexo9Div.style.display = 'none';
        if (anexo9DivTab) anexo9DivTab.style.display = 'none';
    } else if (anexoIXHabil === "1") {
        if (anexoXHabil === "0") {
            var nextTabIX = "anexo5-tab";
        } else if (anexoXHabil === "1") {
            var nextTabIX = "anexo10-tab";
        }
    }

    if (anexoXHabil === "0") {
        if (anexo10Div) anexo10Div.style.display = 'none';
        if (anexo10DivTab) anexo10DivTab.style.display = 'none';
    } else if (anexoXHabil === "1") {
        var nextTabX = "anexo5-tab";
    }

    function validateAndSubmitAnexoVIII(event) {
        const fields = [
            'institucion',
            'anio',
            'division',
            'area',
            'docente',
            'objetivo',
            'fechaSalida',
            'lugaresVisitar',
            'descPrevia',
            'respPrevia',
            'obsPrevia',
            'descDurante',
            'respDurante',
            'obsDurante',
            'descEvaluacion',
            'respEvaluacion',
            'obsEvaluacion'
        ];

        let firstInvalidField = null;

        for (let field of fields) {
            const element = document.getElementById(field);
            if (element && element.value.trim() === '') {
                firstInvalidField = element;
                break;
            }
        }

        if (firstInvalidField) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos Incompletos',
                text: `El campo "${firstInvalidField.previousElementSibling.textContent}" es obligatorio.`,
                confirmButtonText: 'Aceptar'
            }).then(() => {
                setTimeout(() => {
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalidField.focus();
                }, 500);
            });
            event.preventDefault();
            return;
        }

        const anio = document.getElementById('anio');
        if (anio && (anio.value < 1 || anio.value > 7)) {
            Swal.fire({
                icon: 'warning',
                title: 'Año Inválido',
                text: 'El año debe estar entre 1 y 7.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                setTimeout(() => {
                    anio.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    anio.focus();
                }, 500);
            });
            event.preventDefault();
            return;
        }

        enviarFormulario('formAnexoVIII', '../../php/insertAnexoVIII.php', 'Anexo 8 cargado correctamente!', nextTabVIII);
    }

    function validateAndSubmitAnexoIX(event) {
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
            'nombreConductor2'
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
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }

        const telefonos = [
            { id: 'telefonoTransporte', maxDigits: 12, allowDashes: false },
            { id: 'telefonoResponsable', maxDigits: 12, allowDashes: false },
            { id: 'telefonoMovil', maxDigits: 12, allowDashes: true }
        ];

        for (let telefono of telefonos) {
            const element = document.getElementById(telefono.id);
            if (!element) continue;
            const value = element.value.trim();
            const regex = telefono.allowDashes ? /^\d{10,12}(-\d{10,12})*$/ : /^\d{10,12}$/;

            if (!regex.test(value)) {
                if (!firstInvalidField) {
                    firstInvalidField = element;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Número de Teléfono Inválido',
                    text: `El campo "${document.querySelector(`label[for=${telefono.id}]`).textContent}" debe contener solo números y, en el caso del teléfono móvil, puede contener guiones medios. Mínimo: 10 digitos, Máximo: ${telefono.maxDigits} dígitos.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }

            if (value.replace(/-/g, '').length > telefono.maxDigits) {
                if (!firstInvalidField) {
                    firstInvalidField = element;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Número de Teléfono Excedido',
                    text: `El campo "${document.querySelector(`label[for=${telefono.id}]`).textContent}" no debe exceder los ${telefono.maxDigits} dígitos.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }

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

            if (dniValue.length > 10 || licenciaValue.length > 10) {
                if (!firstInvalidField) {
                    firstInvalidField = dniValue.length > 10 ? dniElement : licenciaElement;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'DNI o Licencia Excedidos',
                    text: 'El DNI o la Licencia no debe exceder los 10 dígitos.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }

            if (dniValue !== licenciaValue) {
                if (!firstInvalidField) {
                    firstInvalidField = dniElement;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'DNI y Licencia No Coinciden',
                    text: 'El DNI y la Licencia deben coincidir.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }

        const fechaVigenciaConductor1 = document.getElementById('vigenciaConductor1');
        const fechaVigenciaConductor2 = document.getElementById('vigenciaConductor2');
        const fechaActual = new Date();

        if (fechaVigenciaConductor1) {
            const fechaVigenciaValue1 = new Date(fechaVigenciaConductor1.value);
            if (fechaVigenciaValue1 <= fechaActual) {
                if (!firstInvalidField) {
                    firstInvalidField = fechaVigenciaConductor1;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha de Vigencia Inválida',
                    text: 'La fecha de vigencia del conductor 1 no puede ser igual o anterior a la fecha actual.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }

        if (fechaVigenciaConductor2) {
            const fechaVigenciaValue2 = new Date(fechaVigenciaConductor2.value);
            if (fechaVigenciaValue2 <= fechaActual) {
                if (!firstInvalidField) {
                    firstInvalidField = fechaVigenciaConductor2;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha de Vigencia Inválida',
                    text: 'La fecha de vigencia del conductor 2 no puede ser igual o anterior a la fecha actual.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }

        enviarFormulario('formAnexoIX', '../../php/insertAnexoIX.php', 'Anexo 9 cargado correctamente!', nextTabIX);
    }

    function validateAndSubmitAnexoX(event) {
        const fields = [
            'infraestructura',
            'hospitales',
            'mediosAlternativos',
            'datosOpcionales'
        ];

        let firstInvalidField = null;

        for (let field of fields) {
            const element = document.getElementById(field);
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
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }

        enviarFormulario('formAnexoX', '../../php/insertAnexoX.php', 'Anexo 10 cargado correctamente!', nextTabX);
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
    document.getElementById('cargarAnexoIX').addEventListener('click', validateAndSubmitAnexoIX);
    document.getElementById('cargarAnexoX').addEventListener('click', validateAndSubmitAnexoX);
});
