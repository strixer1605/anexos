document.addEventListener("DOMContentLoaded", function() {

    document.getElementById("fechaSalida").addEventListener("change", validarFechas);
    document.getElementById("horaSalida").addEventListener("change", validarFechas);
    document.getElementById("fechaRegreso").addEventListener("change", validarFechas);
    document.getElementById("horaRegreso").addEventListener("change", validarFechas);

    document.querySelectorAll('input[name="distanciaSalida"]').forEach(function (radio) {
        radio.addEventListener('change', validarDistanciaSalida);
    });

    function validarDistanciaSalida() {
        const distanciaSeleccionada = document.querySelector('input[name="distanciaSalida"]:checked').value;

        if (["1", "2", "4", "6"].includes(distanciaSeleccionada)) {
            ocultarInputs();
        } else {
            mostrarInputs();
        }
    }

    function validateAndSubmitAnexoIV(event) {
        
        event.preventDefault();

        const tipoSalida = document.querySelector('input[name="tipoSalida"]:checked');
        if (!tipoSalida) {
            const tipoSalidaContainer = document.querySelector('input[name="tipoSalida"]').closest('div');
        
            Swal.fire({
                icon: 'warning',
                title: 'Campo no seleccionado',
                text: 'Por favor selecciona una opción para el tipo de salida.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                setTimeout(() => {
                    tipoSalidaContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    document.querySelector('input[name="tipoSalida"]').focus();
                }, 300);
            });
            return;
        }

        const distanciaSalida = document.querySelector('input[name="distanciaSalida"]:checked');
        if (!distanciaSalida) {
            const distSalidaContainer = document.querySelector('input[name="distanciaSalida"]').closest('div');
            Swal.fire({
                icon: 'warning',
                title: 'Campo no seleccionado',
                text: 'Por favor selecciona una opción para la distancia de la salida.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                setTimeout(() => {
                    distSalidaContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    document.querySelector('input[name="distanciaSalida"]').focus();
                }, 300);
            });
            return;
        }

        const esValido = validarFechas();
        if (!esValido) return;

        const fields = [
            'denominacionProyecto',
            'localidadViaje',
            'lugarVisitar',
            'fechaSalida',
            'lugarSalida',
            'horaSalida',
            'fechaRegreso',
            'lugarRegreso',
            'horaRegreso',
            'itinerario',
            'actividades',
            'gastosEstimativos'
        ];

        let firstInvalidField = null;

        // Validación de campos vacíos obligatorios
        for (let field of fields) {
            const element = document.getElementById(field);
            if (element && element.value.trim() === '') {
                firstInvalidField = element;
                break;
            }
        }

        // Validación de campos de hospedaje solo si están visibles
        if (document.getElementById("nombreHospedaje").style.display !== "none") {
            const hospedajeFields = [
                'nombreHospedaje',
                'domicilioHospedaje',
                'telefonoHospedaje',
                'localidadHospedaje'
            ];

            for (let field of hospedajeFields) {
                const element = document.getElementById(field);
                if (element && element.value.trim() === '') {
                    firstInvalidField = element;
                    break;
                }
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
                }, 300);
            });
            return;
        }

        // Validación del nombre encargado
        var nombreEncargado = document.getElementById("nombreEncargado").value;
        var nombrePattern = /^[A-Za-z\s]+$/;
        if (!nombrePattern.test(nombreEncargado)) {
            Swal.fire({
                icon: 'warning',
                title: 'Nombre Inválido',
                text: "El nombre del encargado no debe contener números.",
                confirmButtonText: 'Aceptar'
            }).then(() => {
                setTimeout(() => {
                    document.getElementById("nombreEncargado").scrollIntoView({ behavior: 'smooth', block: 'center' });
                    document.getElementById("nombreEncargado").focus();
                }, 300);
            });
            return;
        }

        // Validación de telefonoHospedaje
        var telefonoHospedaje = document.getElementById("telefonoHospedaje").value;
        var telefonoPattern = /^[\d\-\+\(\)\s]+$/;
        if (telefonoHospedaje && !telefonoPattern.test(telefonoHospedaje)) {
            Swal.fire({
                icon: 'warning',
                title: 'Teléfono Inválido',
                text: 'El teléfono del hospedaje solo puede contener números y los siguientes caracteres: +, -, (, ), espacio.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                setTimeout(() => {
                    document.getElementById("telefonoHospedaje").scrollIntoView({ behavior: 'smooth', block: 'center' });
                    document.getElementById("telefonoHospedaje").focus();
                }, 300);
            });
            return;
        }
    
        // Validación de gastos estimativos (solo números y punto decimal)
        var gastosEstimativos = document.getElementById("gastosEstimativos").value;
        var gastosPattern = /^\d+(\.\d{1,2})?$/;
        if (gastosEstimativos && !gastosPattern.test(gastosEstimativos)) {
            Swal.fire({
                icon: 'warning',
                title: 'Gastos Estimativos Inválidos',
                text: 'El campo de gastos estimativos solo puede contener números',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                setTimeout(() => {
                    document.getElementById("gastosEstimativos").value = "";
                    document.getElementById("gastosEstimativos").scrollIntoView({ behavior: 'smooth', block: 'center' });
                    document.getElementById("gastosEstimativos").focus();
                }, 300);
            });
            return;
        }

        const checkboxes = document.querySelectorAll(".form-check-input");
        checkboxes.forEach(function(checkbox) {
            checkbox.value = checkbox.checked ? "1" : "0";
        });

        enviarFormulario('formAnexoIV', '../../php/insertAnexoIV.php', 'Anexo 4 cargado correctamente!');
    }

    function validarFechas() {
        const fechaSalida = document.getElementById("fechaSalida").value;
        const horaSalida = document.getElementById("horaSalida").value;
        const fechaRegreso = document.getElementById("fechaRegreso").value;
        const horaRegreso = document.getElementById("horaRegreso").value;
    
        // Si alguna fecha o hora está vacía, retornamos true para permitir el envío
        if (!fechaSalida || !horaSalida || !fechaRegreso || !horaRegreso) return true;
    
        const fechaHoraActual = new Date();
        const fechaHoraSalida = new Date(`${fechaSalida}T${horaSalida}`);
        const fechaHoraRegreso = new Date(`${fechaRegreso}T${horaRegreso}`);
    
        // Calcular la diferencia en horas
        const diferenciaMs = fechaHoraRegreso - fechaHoraSalida;
        const diferenciaHoras = diferenciaMs / (1000 * 60 * 60);  // Convertir a horas
    
        // Validación de las opciones de distancia seleccionada
        const distanciaSeleccionada = document.querySelector('input[name="distanciaSalida"]:checked').value;
    
        // Opciones de salida de menos de 24 horas
        const opcionesMenos24Horas = ["1", "2", "4", "6"];
    
        if (opcionesMenos24Horas.includes(distanciaSeleccionada)) {
            // Si la diferencia es mayor a 24 horas, mostrar advertencia
            if (diferenciaHoras >= 24) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Duración Inválida',
                    text: 'Has seleccionado una salida de menos de 24 horas, pero la diferencia es mayor a 24 horas. ATENCION: Las fechas se borraran, ingrese fechas válidas.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    limpiarCampos();
                });
                return false;
            }
        } else {
            // Opciones que permiten más de 24 horas
            if (diferenciaHoras < 24) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Duración Inválida',
                    text: 'Has seleccionado una salida de más de 24 horas, pero la diferencia es menor a 24 horas. ATENCION: Las fechas se borraran, ingrese fechas válidas.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    limpiarCampos();
                });
                return false;
            }
        }
    
        const distanciaSeleccionadaCheck = document.querySelector('input[name="distanciaSalida"]:checked');
        if (!distanciaSeleccionadaCheck) {
            Swal.fire({
                icon: 'warning',
                title: 'Selección Requerida',
                text: 'Por favor, selecciona una opción de distancia para continuar.',
                confirmButtonText: 'Aceptar'
            });
            return false;
        }
    
        // Validación de fecha y hora de salida
        if (isNaN(fechaHoraSalida.getTime()) || fechaHoraSalida <= fechaHoraActual) {
            Swal.fire({
                icon: 'warning',
                title: 'Fecha Inválida',
                text: 'La fecha y hora de salida no pueden ser en el pasado, actuales o muy lejanas. ATENCION: Las fechas se borraran, ingrese fechas válidas.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                limpiarCampos();
            });
            return false; // Salida inválida
        }
    
        const unAnoEnMilisegundos = 365 * 24 * 60 * 60 * 1000;
        if (fechaHoraSalida - fechaHoraActual > unAnoEnMilisegundos || 
            fechaHoraSalida.getFullYear() < 2024 || fechaHoraSalida.getFullYear() > 2100) {
            Swal.fire({
                icon: 'warning',
                title: 'Fecha Inválida',
                text: 'La fecha de salida no puede ser más de un año en el futuro y debe estar entre 2024 y 2100. ATENCION: Las fechas se borraran, ingrese fechas válidas.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                limpiarCampos();
            });
            return false; // Salida inválida
        }
    
        // Validación de fecha y hora de regreso
        if (isNaN(fechaHoraRegreso.getTime()) || fechaHoraRegreso <= fechaHoraActual) {
            Swal.fire({
                icon: 'warning',
                title: 'Fecha Inválida',
                text: 'La fecha y hora de regreso no pueden ser en el pasado, actuales o muy lejanas. ATENCION: Las fechas se borraran, ingrese fechas válidas.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                limpiarCampos();
            });
            return false; // Regreso inválido
        }
    
        if (fechaHoraRegreso <= fechaHoraSalida) {
            Swal.fire({
                icon: 'warning',
                title: 'Fecha Inválida',
                text: 'La fecha y hora de regreso deben ser posteriores a la fecha y hora de salida. ATENCION: Las fechas se borraran, ingrese fechas válidas.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                limpiarCampos();
            });
            return false; // Regreso no posterior a salida
        }
    
        return true; // Todo está bien
    }    
    
    function limpiarCampos() {
        document.getElementById("fechaSalida").value = "";
        document.getElementById("horaSalida").value = "";
        document.getElementById("fechaRegreso").value = "";
        document.getElementById("horaRegreso").value = "";
    }

    function ocultarInputs() {
        var elementos = [
            document.getElementById("nombreHospedaje"),
            document.getElementById("domicilioHospedaje"),
            document.getElementById("telefonoHospedaje"),
            document.getElementById("localidadHospedaje"),
            document.getElementById("nH"),
            document.getElementById("dH"),
            document.getElementById("tH"),
            document.getElementById("lH")
        ];

        elementos.forEach(function(elemento) {
            if (elemento) {
                elemento.style.display = "none";
                elemento.disabled = true;
            }
        });
    }
        
    function mostrarInputs() {
        var elementos = [
            document.getElementById("nombreHospedaje"),
            document.getElementById("domicilioHospedaje"),
            document.getElementById("telefonoHospedaje"),
            document.getElementById("localidadHospedaje"),
            document.getElementById("nH"),
            document.getElementById("dH"),
            document.getElementById("tH"),
            document.getElementById("lH")
        ];

        elementos.forEach(function(elemento) {
            if (elemento) {
                elemento.style.display = "";  // Asegura que los inputs se muestran correctamente
                elemento.disabled = false;
            }
        });
    }

    function enviarFormulario(formId, actionUrl, successMessage) {
        var form = document.getElementById(formId);
        if (!form) return;
    
        var formData = new FormData(form);
    
        fetch(actionUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log("Response from server:", data);  // Log respuesta
            if (data.trim() === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: successMessage,
                    showConfirmButton: false,
                    timer: 1000
                }).then(() => {
                    setTimeout(() => {
                        window.location.replace('../../indexs/profesores/menuAdministrarSalidas.php');
                    }, 500);
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

    document.getElementById('cargarAnexoIV').addEventListener('click', validateAndSubmitAnexoIV);
});