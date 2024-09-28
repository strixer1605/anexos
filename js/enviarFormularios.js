document.addEventListener("DOMContentLoaded", function() {

    var anexo9Div = document.getElementById('anexo9');
    var anexo9DivTab = document.getElementById('anexo9-tab');
    const nextTab = anexoIXHabil === "1" ? "anexo9-tab" : "anexo10-tab"
    
    if (anexoIXHabil === "0") {
        if (anexo9Div) anexo9Div.style.display = 'none';
        if (anexo9DivTab) anexo9DivTab.style.display = 'none';
    }

    $('#cargarCurso').on('click', function () {
        const curso = $('#selectCursos').find(':selected').text();
        var textCurso = $('#cursos').val();
        
        var cursosArray = textCurso.split(',').map(item => item.trim());
        
        if (cursosArray.includes(curso)) {
            Swal.fire({
                icon: 'warning',
                title: 'Curso ya ingresado',
                text: `El curso "${curso}" ya ha sido agregado.`,
                showCancelButton: true,
                confirmButtonText: 'Omitir',
                cancelButtonText: 'Borrar curso'
            }).then((result) => {
                if (result.isConfirmed) {
                    return; 
                } else {
                    cursosArray = cursosArray.filter(item => item !== curso);
                    $('#cursos').val(cursosArray.join(', ').trim());
                    Swal.fire('Borrado', `El curso "${curso}" ha sido eliminado de la lista.`, 'info');
                }
            });
            return; 
        }
    
        if (textCurso) {
            textCurso += ', ';
        }
    
        textCurso += curso;
        $('#cursos').val(textCurso.trim());
    });    
    
    $('#cargarMateria').on('click', function () {
        const materia = $('#selectMaterias').find(':selected').text();
        var textMateria = $('#materias').val();
        
        var materiasArray = textMateria.split(',').map(item => item.trim());
        
        if (materiasArray.includes(materia)) {
            Swal.fire({
                icon: 'warning',
                title: 'Materia ya ingresada',
                text: `La materia "${materia}" ya ha sido agregada.`,
                showCancelButton: true,
                confirmButtonText: 'Omitir',
                cancelButtonText: 'Borrar materia'
            }).then((result) => {
                if (result.isConfirmed) {
                    return; 
                } else {
                    materiasArray = materiasArray.filter(item => item !== materia);
                    $('#materias').val(materiasArray.join(', ').trim());
                    Swal.fire('Borrado', `La materia "${materia}" ha sido eliminada de la lista.`, 'info');
                }
            });
            return; 
        }
    
        if (textMateria) {
            textMateria += ', ';
        }
    
        textMateria += materia;
        $('#materias').val(textMateria.trim());
    });     


    function validateAndSubmitAnexoVIII(event) {
        const fields = [
            'institucion',
            'cursos',
            'materias',
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
                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    firstInvalidField.focus();
                }, 500);
            });
            event.preventDefault();
            return;
        }
    
        enviarFormulario('formAnexoVIII', '../../php/insertAnexoVIII.php', 'Anexo 8 cargado correctamente!', nextTab);
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
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
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
            { id: 'licenciaConductor1', nombre: 'Licencia del Conductor 1' },
            { id: 'dniConductor2', nombre: 'DNI del Conductor 2' },
            { id: 'licenciaConductor2', nombre: 'Licencia del Conductor 2' }
        ];
    
        for (let campo of camposSoloNumeros) {
            const element = document.getElementById(campo.id);
            if (!element) continue;
            const value = element.value.trim();
    
            // Verificación: permitir solo dígitos (0-9)
            if (!/^\d+$/.test(value)) {
                if (!firstInvalidField) {
                    firstInvalidField = element;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Valor Inválido',
                    text: `El campo "${campo.nombre}" debe contener solo números.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        element.focus();
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
            if (!element) continue;
            const value = element.value.trim();
    
            // Verificación: permitir solo letras y espacios.
            if (!/^[a-zA-Z\s]+$/.test(value)) {
                if (!firstInvalidField) {
                    firstInvalidField = element;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Nombre Inválido',
                    text: `El campo "${campo.nombre}" debe contener solo letras.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        element.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
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
                if (!firstInvalidField) {
                    firstInvalidField = element;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Número de Teléfono Inválido',
                    text: `El campo "${document.querySelector(`label[for=${telefono.id}]`).textContent}" debe contener solo números, con un máximo de 13.`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        element.focus();
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
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        element.focus();
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
    
            if (dniValue.length < 7 || dniValue.length > 8 || dniValue !== licenciaValue) {
                if (!firstInvalidField) {
                    firstInvalidField = dniElement;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'DNI o Licencia Inválidos',
                    text: 'El DNI y la Licencia deben tener entre 7 y 8 dígitos y deben coincidir.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    dniElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        dniElement.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
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
                if (!firstInvalidField) {
                    firstInvalidField = fechaVigenciaConductor1;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha de Vigencia Inválida',
                    text: 'La fecha de vigencia del conductor 1 debe ser posterior a hoy y no mayor a 1 de enero del 2100.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    fechaVigenciaConductor1.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        fechaVigenciaConductor1.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }
    
        if (fechaVigenciaConductor2) {
            const fechaVigenciaValue2 = new Date(fechaVigenciaConductor2.value);
            if (fechaVigenciaValue2 <= fechaActual || fechaVigenciaValue2 >= fechaLimite) {
                if (!firstInvalidField) {
                    firstInvalidField = fechaVigenciaConductor2;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha de Vigencia Inválida',
                    text: 'La fecha de vigencia del conductor 2 debe ser posterior a hoy y no mayor a 1 de enero del 2100.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    fechaVigenciaConductor2.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        fechaVigenciaConductor2.focus();
                    }, 500);
                });
                event.preventDefault();
                return;
            }
        }

        // // Verificar la carga de imágenes
        // const imagenes = [
        //     'cedulaTransporte',
        //     'certificadoAptitudTecnica',
        //     'crnt',
        //     'vtvNacion',
        //     'certificadoInspeccionVtvNacion',
        //     'registroControlModelo',
        //     'vtvProvincia',
        //     'documentacionConductores'
        // ];
    
        // for (let imagen of imagenes) {
        //     const archivo = document.getElementById(imagen).files[0];
        //     const archivoPrevio = document.querySelector(`a[data-file-for=${imagen}]`);

        //     if (!archivo && !archivoPrevio) {
        //         if (!firstInvalidField) {
        //             firstInvalidField = document.getElementById(imagen);
        //         }
        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Imagen Requerida',
        //             text: `El archivo "${document.querySelector(`label[for=${imagen}]`).textContent}" es obligatorio.`,
        //             confirmButtonText: 'Aceptar'
        //         }).then(() => {
        //             document.getElementById(imagen).scrollIntoView({ behavior: 'smooth', block: 'center' });
        //             setTimeout(() => {
        //                 document.getElementById(imagen).focus();
        //             }, 500);
        //         });
        //         event.preventDefault();
        //         return;
        //     }
        // }
    
        // Enviar el formulario si todo es válido
        enviarFormulario('formAnexoIX', '../../php/insertAnexoIX.php', 'Anexo 9 cargado correctamente!', 'anexo10-tab' );
    }
    
    function validateAndSubmitAnexoX(event) {
        const telefonos = [
            { id: 'hospitalesTelefono', maxDigits: 13 },
            { id: 'datosInteresTelefono', maxDigits: 13 }
        ];
    
        const requiredFields = [
            'localidadEmpresa',
            'hospitales',
            'hospitalesTelefono',
            'hospitalesDireccion',
            'hospitalesLocalidad'
        ];
    
        // Verificar si hay datos de interés ingresados
        const datosInteres = document.getElementById('datosInteres');
        const datosInteresValue = datosInteres ? datosInteres.value.trim() : '';
        const camposDatosInteres = [
            'datosInteresTelefono',
            'datosInteresDireccion',
            'datosInteresLocalidad'
        ];
    
        // Si hay valor en "Datos de Interés", asegurarse de que los campos relacionados sean obligatorios
        if (datosInteresValue) {
            for (let fieldId of camposDatosInteres) {
                const element = document.getElementById(fieldId);
                if (element && element.value.trim() === '') {
                    showAlertAndFocus(fieldId, 'Campo Obligatorio', `El campo "${document.querySelector(`label[for=${fieldId}]`).textContent}" es obligatorio.`);
                    event.preventDefault();
                    return;
                }
            }
        }
    
        // Validación de campos requeridos
        for (let fieldId of requiredFields) {
            const element = document.getElementById(fieldId);
            if (element && element.value.trim() === '') {
                showAlertAndFocus(fieldId, 'Campo Obligatorio', `El campo "${document.querySelector(`label[for=${fieldId}]`).textContent}" es obligatorio.`);
                event.preventDefault();
                return;
            }
        }
    
        // Validación de teléfonos
        for (let telefono of telefonos) {
            const element = document.getElementById(telefono.id);
            if (element == null) {
                continue;
            }
    
            const value = element.value.trim();
            if (value === '') {
                continue;
            }
    
            // Verifica que el número sea mayor a 0
            if (parseInt(value) <= 0) {
                showAlertAndFocus(telefono.id, 'Número de Teléfono Inválido', `El campo "${document.querySelector(`label[for=${telefono.id}]`).textContent}" debe contener solo números y ser mayor a 0.`);
                event.preventDefault();
                return;
            }
    
            // Verifica la longitud del número
            if (value.length > telefono.maxDigits) {
                showAlertAndFocus(telefono.id, 'Número de Teléfono Excedido', `El campo "${document.querySelector(`label[for=${telefono.id}]`).textContent}" no debe exceder los ${telefono.maxDigits} dígitos.`);
                event.preventDefault();
                return;
            }
        }
    
        // Descomentar la siguiente línea para enviar el formulario
        enviarFormulario('formAnexoX', '../../php/insertAnexoX.php', 'Anexo 10 cargado correctamente!', 'anexo5-tab');
    }
    
    // Función para mostrar la alerta y hacer foco en el campo correspondiente
    function showAlertAndFocus(fieldId, title, text) {
        Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            confirmButtonText: 'Aceptar'
        }).then(() => {
            const element = document.getElementById(fieldId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    element.focus();
                }, 500);
            }
        });
    }

    

    function enviarFormulario(formId, actionUrl, successMessage, nextTabId) {
        var form = document.getElementById(formId);
        console.log(form);
        if (!form) return;

        var formData = new FormData(form);
        console.log(formData);

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
