document.addEventListener("DOMContentLoaded", function() {
    let timeoutId;  // ID del timeout

    // Función para activar la validación con retraso (debouncing)
    function activarValidacionConRetraso() {
        clearTimeout(timeoutId);

        timeoutId = setTimeout(() => {
            verificarRequisitosYCalcular();
            validarFechas();
        }, 2500);
    }

    document.getElementById("fechaSalida").addEventListener("blur", function(){
        console.log("Hola")
        if (this.value.length === 10) {  
            activarValidacionConRetraso();
        }
    });
    
    document.getElementById("horaSalida").addEventListener("change", function(){
        activarValidacionConRetraso();
    });

    document.getElementById("fechaRegreso").addEventListener("input", function(){
        if (this.value.length === 10) {
            activarValidacionConRetraso();
        }
    });

    document.getElementById("horaRegreso").addEventListener("change", function(){
        activarValidacionConRetraso();
    });

    document.querySelectorAll('input[name="distanciaSalida"]').forEach(function (radio) {
        radio.addEventListener('change', function() {
            validarDistanciaSalida();
        });
    });

    function verificarRequisitosYCalcular() {
        const fechaSalidaInput = document.getElementById("fechaSalida").value;
        const distanciaSeleccionada = document.querySelector('input[name="distanciaSalida"]:checked')?.value;
    
        if (fechaSalidaInput && distanciaSeleccionada) {
            calcularTiempoLimite();
        }
    }
    
    function validarDistanciaSalida() {
        const distanciaSeleccionada = document.querySelector('input[name="distanciaSalida"]:checked').value;
        
        document.getElementById("fechaSalida").disabled = false;
        document.getElementById("horaSalida").disabled = false;
        document.getElementById("fechaRegreso").disabled = false;
        document.getElementById("horaRegreso").disabled = false;
    
        if (["1", "2", "4", "6"].includes(distanciaSeleccionada)) {
            ocultarInputs();
        } else {
            mostrarInputs();
        }
    }

    let fechasValidas = [];
    
    function calcularTiempoLimite() {
        const fechaSalidaInput = document.getElementById('fechaSalida').value;
        const distanciaSeleccionada = document.querySelector('input[name="distanciaSalida"]:checked').value;
        let diasARestar = 0;
    
        // Asignación de los días a restar según la distancia seleccionada
        if (distanciaSeleccionada == 1) {
            diasARestar = 5;
        } else if (distanciaSeleccionada == 2) {
            diasARestar = 15;
        } else if (distanciaSeleccionada > 2 && distanciaSeleccionada <= 7) {
            diasARestar = 20;
        } else if (distanciaSeleccionada == 8 || distanciaSeleccionada == 9) {
            diasARestar = 45;
        }
    
        // Validar que se haya seleccionado una fecha de salida
        if (!fechaSalidaInput) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor ingrese una fecha de salida.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }
    
        // Parsear la fecha de salida desde el input (en formato YYYY-MM-DD)
        const fechaSalida = dateFns.parseISO(fechaSalidaInput);
        const fechaActual = new Date();
    
        const fechaLimite = dateFns.subDays(fechaSalida, diasARestar); // Fecha límite
    
        const feriados = [
            "01-01", "24-03", "02-04", "01-05", 
            "25-05", "20-06", "09-07", "08-12", "25-12"
        ];
    
        // Función para verificar si una fecha es feriado
        function esFeriado(fecha) {
            const diaMes = dateFns.format(fecha, 'dd-MM');
            return feriados.includes(diaMes);
        }
    
        fechasValidas = [];
        let fecha = fechaSalida;
    
        // Mientras necesitemos más fechas válidas y no hayamos alcanzado la fecha límite
        while (fechasValidas.length < diasARestar && fecha >= fechaLimite) {
            // Verificar que la fecha no sea fin de semana ni feriado
            if (!dateFns.isWeekend(fecha) && !esFeriado(fecha)) {
                fechasValidas.push(dateFns.format(fecha, 'yyyy-MM-dd'));
            } else {
                console.log(`Fecha excluida: ${dateFns.format(fecha, 'yyyy-MM-dd')}`);
                console.log(fechasValidas)
            }
            // Retroceder un día
            fecha = dateFns.subDays(fecha, 1);
        }   
    
        // Si no hay suficientes fechas válidas, seguir retrocediendo
        while (fechasValidas.length < diasARestar) {
            fecha = dateFns.subDays(fecha, 1);
            if (!dateFns.isWeekend(fecha) && !esFeriado(fecha)) {
                fechasValidas.push(dateFns.format(fecha, 'yyyy-MM-dd'));
            }
        }

        const primeraFechaValida = fechasValidas[fechasValidas.length - 1];
        const fechaPrimeraValida = dateFns.parseISO(primeraFechaValida);
        
        if (fechaPrimeraValida < new Date()) {
            Swal.fire({
                icon: 'warning',
                title: 'Fecha de salida muy cercana',
                text: 'Ha ingresado una fecha de salida que no cumple con la Resolución Provincial (Días de entrega previos). Por favor, seleccione una fecha de salida más lejana. ATENCION: Las fechas se borraran.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                limpiarCampos();
            });
            return;
        }

        if (fechaSalidaInput && distanciaSeleccionada) {
            const fechaLimiteInput = primeraFechaValida + "T12:00"; 
            
            document.getElementById("fechaLimite").value = fechaLimiteInput;
            console.log('Fechas válidas:', fechasValidas);
        }
    }

    function restarDiasDesdeFecha(fecha, diasARestar) {
        // Utilizar la función de date-fns para restar días
        return dateFns.subDays(fecha, diasARestar);
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
        var telefonoHospedaje = document.getElementById("telefonoHospedaje");
        var telefonoValue = telefonoHospedaje.value.trim();
        var allowDashes = telefonoHospedaje.dataset.allowDashes === "true";
        const regex = allowDashes ? /^[\d-]{10,13}$/ : /^\d{10,13}$/;
        
        if (telefonoValue && !regex.test(telefonoValue)) {
            Swal.fire({
                icon: 'warning',
                title: 'Número de Teléfono Inválido',
                text: `El campo "${document.querySelector(`label[for=${telefonoHospedaje.id}]`).textContent}" debe contener solo números, con un máximo de 13 caracteres.`,
                confirmButtonText: 'Aceptar'
            }).then(() => {
                setTimeout(() => {
                    telefonoHospedaje.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    telefonoHospedaje.focus();
                }, 300);
            });
            event.preventDefault();
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
    
        if (!fechaSalida || !horaSalida || !fechaRegreso || !horaRegreso) return true;
    
        const fechaHoraActual = new Date();
        const fechaHoraSalida = new Date(`${fechaSalida}T${horaSalida}`);
        const fechaHoraRegreso = new Date(`${fechaRegreso}T${horaRegreso}`);
    
        // Calcular la diferencia en horas
        const diferenciaMs = fechaHoraRegreso - fechaHoraSalida;
        const diferenciaHoras = diferenciaMs / (1000 * 60 * 60); 
    
        // Calcular la diferencia mínima entre fecha actual y fecha de salida
        const diferenciaMinimaMs = fechaHoraSalida - fechaHoraActual;
        const diferenciaMinimaDias = Math.floor(diferenciaMinimaMs / (1000 * 60 * 60 * 24)); // Corregido
    
        const distanciaSeleccionada = document.querySelector('input[name="distanciaSalida"]:checked')?.value;
    
        // Validar si la fecha de salida es al menos 5 días después de la fecha actual
        // if (diferenciaMinimaDias < 5) {
        //     Swal.fire({
        //         icon: 'warning',
        //         title: 'Duración Inválida',

        //         confirmButtonText: 'Aceptar'
        //     }).then(() => {
        //         limpiarCampos();
        //     });
        //     return false; // Retorna falso para indicar fallo en la validación
        // }

        const opcionesMenos24Horas = ["1", "2", "4", "6"];
    
        // Validaciones de tiempo de salida y regreso
        if (opcionesMenos24Horas.includes(distanciaSeleccionada)) {
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
    
        // Validación de fecha y hora de salida
        if (isNaN(fechaHoraSalida.getTime()) || fechaHoraSalida <= fechaHoraActual) {
            Swal.fire({
                icon: 'warning',
                title: 'Fecha Inválida',
                text: 'La fecha y hora de salida no pueden ser en el pasado, muy cercanas (min 5 días) o muy lejanas. ATENCION: Las fechas se borraran, ingrese fechas válidas.',
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
                text: 'La fecha de salida no puede ser más de un año en el futuro. ATENCION: Las fechas se borraran, ingrese fechas válidas.',
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
                text: 'La fecha y hora de regreso no pueden ser en el pasado o muy lejanas. ATENCION: Las fechas se borraran, ingrese fechas válidas.',
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
        document.getElementById("fechaLimite").value = "";
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
                elemento.style.display = "";
                elemento.disabled = false;
            }
        });
    }

    function enviarFormulario(formId, actionUrl, successMessage) {
        var form = document.getElementById(formId);
        if (!form) return;
    
        var formData = new FormData(form);
        var fechaAlert = document.getElementById("fechaLimite").value;
        
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
                    text: `Tiene hasta ${fechaAlert} para completar y enviar el proyecto entero.`,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.replace('../../indexs/profesores/menuAdministrarSalidas.php');
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