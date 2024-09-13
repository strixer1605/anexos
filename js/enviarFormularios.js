document.addEventListener("DOMContentLoaded", function() {

    var anexo8Div = document.getElementById('anexo8');
    var anexo9Div = document.getElementById('anexo9');
    var anexo10Div = document.getElementById('anexo10');

    var anexo8DivTab = document.getElementById('anexo8-tab');
    var anexo9DivTab = document.getElementById('anexo9-tab');
    var anexo10DivTab = document.getElementById('anexo10-tab');

    if (anexoVIIIHabil == "0") {
        anexo8Div.style.display = 'none';
        anexo8DivTab.style.display = 'none';
    } else if (anexoVIIIHabil == "1") {
        if (anexoIXHabil == "0") {
            var nextTabVIII = "anexo10-tab";
        } else if (anexoIXHabil == "1") {
            var nextTabVIII = "anexo9-tab";
        } else if (anexoXHabil == "0" && anexoXHabil == "0") {
            var nextTabVIII = "anexo5-tab";
        }
    }

    if (anexoIXHabil === "0") {
        anexo9Div.style.display = 'none';
        anexo9DivTab.style.display = 'none'; 
    } else if (anexoIXHabil == "1") {
        if (anexoXHabil == "0") {
            var nextTabIX = "anexo5-tab";
        } else if (anexoXHabil == "1") {
            var nextTabIX = "anexo10-tab";
        }
    }

    if (anexoXHabil === "0") {
        anexo10Div.style.display = 'none';
        anexo10DivTab.style.display = 'none';
    } else if (anexoXHabil == "1"){
        var nextTabX = "anexo5-tab";
    }

    // // Función para autocompletar los datos cargados
    // function cargarDatosAnexo(tabId) {
    //     fetch(`../../php/traerDatosAnexosJS.php?tabId=${tabId}`)
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //             Object.keys(data.fields).forEach(fieldId => {
    //                 const field = document.getElementById(fieldId);
    //                 if (field) {
    //                     field.value = data.fields[fieldId];
    //                 }
    //             });
    //         } else {
    //             console.error("No se pudieron cargar los datos del anexo.");
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Error:', error);
    //     });
    // }

    // document.addEventListener('DOMContentLoaded', function() {
    //     $('#anexo8-tab').on('shown.bs.tab', function() {
    //         if (anexoVIIIHabil === "1") {
    //             cargarDatosAnexo('anexo8');
    //         }
    //     });
    
    //     $('#anexo9-tab').on('shown.bs.tab', function() {
    //         if (anexoIXHabil === "1") {
    //             cargarDatosAnexo('anexo9');
    //         }
    //     });
    
    //     $('#anexo10-tab').on('shown.bs.tab', function() {
    //         if (anexoXHabil === "1") {
    //             cargarDatosAnexo('anexo10');
    //         }
    //     });
    // });

    document.getElementById('cargarAnexoVIII').addEventListener('click', function(event) {
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

        // Validar campos vacíos
        for (let field of fields) {
            const element = document.getElementById(field);
            if (element.value.trim() === '') {
                firstInvalidField = element;
                break;
            }
        }

        // Validar si hay campos vacíos
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

        // Validar año
        const anio = document.getElementById('anio').value;
        if (anio < 1 || anio > 7) {
            Swal.fire({
                icon: 'warning',
                title: 'Año Inválido',
                text: 'El año debe estar entre 1 y 7.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                setTimeout(() => {
                    document.getElementById('anio').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    document.getElementById('anio').focus();
                }, 500);
            });
            event.preventDefault();
            return;
        }

        enviarFormulario('formAnexoVIII', '../../php/insertAnexoVIII.php', 'Anexo 8 cargado correctamente!', nextTabVIII);
    });

    document.getElementById('cargarAnexoIX').addEventListener('click', function(event) {
        const telefonos = [
            'telefonoTransporte',
            'telefonoResponsable',
            'telefonoMovil'
        ];

        let firstInvalidField = null;

        // Validar campos de teléfono
        for (let telefono of telefonos) {
            const value = document.getElementById(telefono).value;
            if (!/^\d{10}$/.test(value)) {
                if (!firstInvalidField) {
                    firstInvalidField = document.getElementById(telefono);
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Número de Teléfono Inválido',
                    text: `El campo "${document.querySelector(`label[for=${telefono}]`).textContent}" debe contener exactamente 10 dígitos.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    setTimeout(() => {
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 10);
                });
                event.preventDefault();
                return;
            }
        }

        // Validar otros campos
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

        for (let campo of otrosCampos) {
            const element = document.getElementById(campo);
            if (element.value.trim() === '') {
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
                    }, 10);
                });
                event.preventDefault();
                return;
            }
        }

        enviarFormulario('formAnexoIX', '../../php/insertAnexoIX.php', 'Anexo 9 cargado correctamente!', nextTabIX);
    });

    document.getElementById('cargarAnexoX').addEventListener('click', function(event) {
        const fields = [
            'infraestructura',
            'hospitales',
            'mediosAlternativos',
            'datosOpcionales'
        ];

        let firstInvalidField = null;

        // Validar campos vacíos
        for (let field of fields) {
            const element = document.getElementById(field);
            if (element.value.trim() === '') {
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
                    }, 10);
                });
                event.preventDefault();
                return;
            }
        }

        enviarFormulario('formAnexoX', '../../php/insertAnexoX.php', 'Anexo 10 cargado correctamente!', nextTabX);
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
