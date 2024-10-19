document.addEventListener("DOMContentLoaded", function() {
    const limite = document.getElementById('fechaSalida');
    limite.addEventListener('keydown', function (event) {
        event.preventDefault();
    }); 

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

    let agregarBotones = document.querySelectorAll('.cargar-anexo8');

    // Objeto para almacenar los valores
    const seccionesValores = {
        objetivos: [],
        descripcionPrevia: [],
        descripcionDurante: [],
        evaluacion: [],
        responsablesPrevia: [],
        responsablesDurante: [],
        responsablesEvaluacion: []
    };

    const responsableHardcodeado = nombreDocente;
    if (responsableHardcodeado) {
        seccionesValores.responsablesPrevia.push(responsableHardcodeado);
        seccionesValores.responsablesDurante.push(responsableHardcodeado);
        seccionesValores.responsablesEvaluacion.push(responsableHardcodeado);
    }
    
    // Recorre todos los botones y agrega el evento 'click' a cada uno
    agregarBotones.forEach(boton => {
        boton.onclick = () => {
            // console.log(1)
            let inputId = boton.getAttribute('inputid'); // Obtiene el atributo 'inputid'
            agregarValor(inputId);
            // console.log(inputId)
        };
    });
    
    // Función que toma el id del input y agrega su valor a la sección correspondiente
    function agregarValor(inputId) {
        const valor = document.getElementById(inputId).value.trim(); // Obtener y limpiar el valor del input
        if (valor) {
            const contenedorSeccion = document.querySelector(`#${inputId.replace('input', 'seccion')} .contenedorInputs`);
    
            // Verificar si el valor ya existe
            const valoresExistentes = Array.from(contenedorSeccion.querySelectorAll('input.form-control.anexo8')).map(input => input.value);
            if (valoresExistentes.includes(valor)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Texto duplicado',
                    text: 'El mismo texto ya ha sido agregado.',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Verificar si ya existe el campo oculto
            let hiddenInput = contenedorSeccion.querySelector(`input[name="${inputId}"]`);
            if (!hiddenInput) {
                // Crear el campo oculto para enviar el valor en el formulario
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = inputId; // Nombre relacionado con la sección
                hiddenInput.value = valor; // Establecer el valor del campo oculto
                contenedorSeccion.appendChild(hiddenInput); // Añadir el campo oculto a la sección
            } else {
                // Actualizar el valor del campo oculto concatenando el nuevo valor
                hiddenInput.value += (hiddenInput.value ? ', ' : '') + valor; // Agregar el nuevo valor separado por coma
            }
    
            const inputContainer = document.createElement('div'); // Crear un contenedor para el nuevo input
            inputContainer.classList.add('input-container');
    
            // Crear el input que contendrá el valor agregado
            const nuevoInput = document.createElement('input');
            nuevoInput.type = 'text';
            nuevoInput.value = valor;
            nuevoInput.disabled = true; // Deshabilitar el input por defecto
            nuevoInput.style = 'margin-top: 25px;'
            nuevoInput.classList.add('form-control');
            nuevoInput.classList.add('anexo8');
            nuevoInput.classList.add('item');

            // Botón para editar/guardar el valor
            const editarButton = document.createElement('button');
            editarButton.textContent = 'Editar';
            editarButton.setAttribute('type', 'button');
            editarButton.setAttribute('class', 'editar-objetivo');
            editarButton.onclick = function() {
                if (nuevoInput.disabled) {
                    nuevoInput.disabled = false; // Habilitar el input
                    editarButton.textContent = 'Guardar'; // Cambiar texto del botón a "Guardar"
                } else {
                    nuevoInput.disabled = true; // Deshabilitar el input
                    editarButton.textContent = 'Editar'; // Cambiar texto del botón a "Editar"

                    hiddenInput.value = Array.from(contenedorSeccion.querySelectorAll('input.form-control.anexo8'))
                        .map(input => input.value)
                        .join(', ');
                }
            };
    
            // Botón para eliminar el input
            const eliminarButton = document.createElement('button');
            eliminarButton.textContent = 'Eliminar';
            eliminarButton.setAttribute('type', 'button');
            eliminarButton.setAttribute('class', 'eliminar-objetivo');
            eliminarButton.onclick = function() {
                inputContainer.remove(); // Eliminar el contenedor
                // Actualizar el valor del campo oculto al eliminar un input
                hiddenInput.value = Array.from(contenedorSeccion.querySelectorAll('input.form-control.anexo8'))
                    .map(input => input.value)
                    .join(', '); // Reagrupar los valores
            };
    
            // Añadir el input y los botones al contenedor
            inputContainer.appendChild(nuevoInput);
            inputContainer.appendChild(editarButton);
            inputContainer.appendChild(eliminarButton);
    
            // Agregar el nuevo contenedor a la sección correspondiente
            contenedorSeccion.appendChild(inputContainer);
    
            // Limpiar el input original
            document.getElementById(inputId).value = '';
        }
    }

    function validateAndSubmitAnexoVIII(event) {
        const fields = [
            'institucion',
            'cursos',
            'materias',
            'docente',
            'fechaSalida',
            'lugaresVisitar',
            'objetivos',
            'obsPrevia',
            'descPrevia',
            'obsDurante',
            'descDurante',
            'obsEvaluacion',
            'descEvaluacion'
        ];

        let firstInvalidField = null;
        let associatedDiv = null;

        for (let field of fields) {
            const element = document.getElementById(field);

            // Verificar si es un input o textarea
            if (element && (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA')) {
                if (element.value.trim() === '') {
                    firstInvalidField = element;
                    break;
                }
            } 
            // Verificar si es un div y validar si tiene contenido
            else if (element && element.tagName === 'DIV') {
                if (element.textContent.trim() === '') {
                    associatedDiv = element;  // Guardar el div vacío

                    // Buscar el input asociado al div usando data-input-id
                    const relatedInputId = element.getAttribute('data-input-id');
                    const relatedInput = relatedInputId ? document.getElementById(relatedInputId) : null;

                    // Si existe un input asociado, hacemos foco en ese input
                    if (relatedInput) {
                        firstInvalidField = relatedInput;
                    } else {
                        firstInvalidField = element;  // Si no hay input asociado, marcar el div
                    }
                    break;
                }
            }
        }

        if (firstInvalidField) {
            let fieldLabel = '';

            // Si el campo es un div, obtenemos el label de `data-label`
            if (associatedDiv) {
                fieldLabel = associatedDiv.getAttribute('data-label') || 'Campo desconocido';
            } 
            // Si es un input o textarea, obtenemos el texto del label anterior (previousElementSibling)
            else if (firstInvalidField.tagName === 'INPUT' || firstInvalidField.tagName === 'TEXTAREA') {
                const previousElement = firstInvalidField.previousElementSibling;
                if (previousElement && previousElement.textContent) {
                    fieldLabel = previousElement.textContent;
                } else {
                    fieldLabel = 'Campo desconocido';
                }
            }

            Swal.fire({
                icon: 'warning',
                title: 'Campos Incompletos',
                text: `El campo "${fieldLabel}" es obligatorio.`,
                confirmButtonText: 'Aceptar'
            }).then(() => {
                if (firstInvalidField.tagName === 'INPUT' || firstInvalidField.tagName === 'TEXTAREA') {
                    setTimeout(() => {
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalidField.focus();
                    }, 500);
                }
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
        enviarFormulario('formAnexoIX', '../../php/insertAnexoIX.php', 'Anexo 9 cargado correctamente!', 'anexo10-tab');
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
                setTimeout(() => {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    element.focus();
                }, 500);
            }
        });
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
