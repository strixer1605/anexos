document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("fechaSalida").addEventListener("change", function(){
        validarDistanciaSalida();
        verificarRequisitosYCalcular();
        validarFechas();
    });
    document.getElementById("horaSalida").addEventListener("change", function(){
        validarDistanciaSalida();
        verificarRequisitosYCalcular();
        validarFechas();
    });
    document.getElementById("fechaRegreso").addEventListener("change", function(){
        validarFechas();
        validarDistanciaSalida();
        verificarRequisitosYCalcular();
    });
    document.getElementById("horaRegreso").addEventListener("change", function(){
        verificarRequisitosYCalcular();
        validarDistanciaSalida();
        validarFechas();
    });
    
    document.querySelectorAll('input[name="distanciaSalida"]').forEach(function (radio) {
        radio.addEventListener('change', function() {
            validarDistanciaSalida();
            verificarRequisitosYCalcular();
        });
    });
    
    function verificarRequisitosYCalcular() {
        const fechaSalidaInput = document.getElementById("fechaSalida").value;
        const distanciaSeleccionada = document.querySelector('input[name="distanciaSalida"]:checked')?.value;
    
        if (fechaSalidaInput && distanciaSeleccionada) {
            calcularTiempoLimite();
        }
    }
    
    // Función que valida y habilita/oculta campos según la distancia seleccionada
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
            diasARestar = 30;
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

        const fechaSalida = new Date(fechaSalidaInput);
        const fechaLimite = restarDiasDesdeFecha(fechaSalida, diasARestar); // Fecha límite

        // Definir feriados
        const feriados = [
            "01-01", "24-03", "02-04", "01-05", 
            "25-05", "20-06", "09-07", "08-12", "25-12"
        ];

        // Función para verificar si una fecha es feriado
        function esFeriado(fecha) {
            const diaMes = dateFns.format(fecha, 'dd-MM');
            return feriados.includes(diaMes);
        }

        let fecha = fechaSalida;

        // Mientras necesitemos más fechas válidas y no hayamos alcanzado la fecha límite
        while (fechasValidas.length < diasARestar && fecha >= fechaLimite) {
            // Verificar que la fecha no sea fin de semana ni feriado
            if (!dateFns.isWeekend(fecha) && !esFeriado(fecha)) {
                // Si es un día hábil, lo agregamos
                fechasValidas.push(dateFns.format(fecha, 'yyyy-MM-dd'));
            } else {
                // Fecha excluida por ser fin de semana o feriado
                console.log(`Fecha excluida: ${dateFns.format(fecha, 'yyyy-MM-dd')}`);
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

        if (fechaSalidaInput && distanciaSeleccionada) {
            const primeraFechaValida = fechasValidas[fechasValidas.length - 1];
            const fechaLimiteInput = primeraFechaValida + "T12:00"; 
            
            document.getElementById("fechaLimite").value = fechaLimiteInput;
            console.log('Fechas válidas:', fechasValidas);
        }
        // confirmarFechaValida()
    }
    
    // function confirmarFechaValida(){
    //     const ultimaFechaValida = new Date(fechasValidas[fechasValidas.length - 1]);
    //     const fechaCalculo = new Date();

    //     if (ultimaFechaValida <= fechaCalculo) {
    //         Swal.fire({
    //             icon: 'warning',
    //             title: 'Atención',
    //             text: 'Error de cálculo: La fecha de salida que usted ha ingresado debe ser más lejana para cumplir con la Reforma Provincial.',
    //             confirmButtonText: 'Aceptar'
    //         }).then(() => {
    //             setTimeout(() => {
    //                 limpiarCampos();
    //             }, 300);
    //         });
    //         return;
    //     }
    // }

    function restarDiasDesdeFecha(fecha, diasARestar) {
        let fechaObjetivo = new Date(fecha);
        fechaObjetivo.setDate(fechaObjetivo.getDate() - diasARestar);
        return fechaObjetivo;
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

        // confirmarFechaValida()
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
        const diferenciaHoras = diferenciaMs / (1000 * 60 * 60); 
    
        // Calcular la diferencia mínima entre fecha actual y fecha de salida
        const diferenciaMinimaMs = fechaHoraSalida - fechaHoraActual;
        const diferenciaMinimaDias = Math.floor(diferenciaMinimaMs / (1000 * 60 * 60 * 24)); // Corregido
    
        const distanciaSeleccionada = document.querySelector('input[name="distanciaSalida"]:checked')?.value;
    
        const opcionesMenos24Horas = ["1", "2", "4", "6"];
    
        // Validar si la fecha de salida es al menos 5 días después de la fecha actual
        if (diferenciaMinimaDias < 5) {
            Swal.fire({
                icon: 'warning',
                title: 'Duración Inválida',
                text: 'La diferencia entre la fecha actual y la fecha de la salida debe ser de al menos 5 días.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                limpiarCampos();
            });
            return false; // Retorna falso para indicar fallo en la validación
        }
        
        // if (dateFns.isWeekend(fechaHoraActual)) {
        //     Swal.fire({
        //         icon: 'warning',
        //         title: 'Carga inhabilitada',
        //         text: 'La salidas no pueden cargarse los fines de semana, inténtelo el próximo Lunes.',
        //         confirmButtonText: 'Aceptar'
        //     }).then(() => {
        //         limpiarCampos();  // Limpiar los campos si se selecciona una fecha no válida
        //     });
        //     return false; // Fecha de salida en fin de semana, detener la validación
        // }
    
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