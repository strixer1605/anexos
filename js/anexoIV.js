document.addEventListener("DOMContentLoaded", function() {

    document.getElementById("fechaSalida").addEventListener("change", validarFechas);
    document.getElementById("horaSalida").addEventListener("change", validarFechas);
    document.getElementById("fechaRegreso").addEventListener("change", validarFechas);
    document.getElementById("horaRegreso").addEventListener("change", validarFechas);

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
            'nombreHospedaje',
            'domicilioHospedaje',
            'telefonoHospedaje',
            'localidadHospedaje',
            'gastosEstimativos'
        ];

        let firstInvalidField = null;

        // Validación de campos vacíos
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

        const checkboxes = document.querySelectorAll(".form-check-input");
        checkboxes.forEach(function(checkbox) {
            checkbox.value = checkbox.checked ? "1" : "0";
        });

        enviarFormulario('formAnexoIV', '../../php/insertAnexoIV.php', 'Anexo 4 cargado correctamente!');
    }

    function validarFechas() {
        var fechaSalida = document.getElementById("fechaSalida").value;
        var horaSalida = document.getElementById("horaSalida").value;
        var fechaRegreso = document.getElementById("fechaRegreso").value;
        var horaRegreso = document.getElementById("horaRegreso").value;

        var fechaHoraActual = new Date();

        // Validación de fecha y hora de salida
        if (fechaSalida && horaSalida) {
            var fechaHoraSalida = new Date(fechaSalida + "T" + horaSalida);

            // Verificar si la fecha de salida es en el pasado o actual
            if (fechaHoraSalida <= fechaHoraActual) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha Inválida',
                    text: 'La fecha y hora de salida no pueden ser en el pasado o actual.',
                    confirmButtonText: 'Aceptar'
                });
                document.getElementById("fechaSalida").value = "";
                document.getElementById("horaSalida").value = "";
                return;
            }

            // Validar si la fecha de salida es más de un año en el futuro
            var unAnoEnMilisegundos = 365 * 24 * 60 * 60 * 1000;
            if (fechaHoraSalida - fechaHoraActual > unAnoEnMilisegundos) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha Inválida',
                    text: 'La fecha de salida no puede ser más de un año en el futuro.',
                    confirmButtonText: 'Aceptar'
                });
                document.getElementById("fechaSalida").value = "";
                document.getElementById("horaSalida").value = "";
                return;
            }

            document.getElementById("fechaRegreso").removeAttribute("disabled");
        }

        // Validación de fecha y hora de regreso
        if (fechaRegreso && horaRegreso) {
            var fechaHoraRegreso = new Date(fechaRegreso + "T" + horaRegreso);

            if (fechaHoraRegreso <= fechaHoraActual) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha Inválida',
                    text: 'La fecha y hora de regreso no pueden ser en el pasado o actual.',
                    confirmButtonText: 'Aceptar'
                });
                document.getElementById("fechaRegreso").value = "";
                document.getElementById("horaRegreso").value = "";
                return;
            }

            if (fechaHoraRegreso <= fechaHoraSalida) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha Inválida',
                    text: 'La fecha y hora de regreso deben ser posteriores a la fecha y hora de salida.',
                    confirmButtonText: 'Aceptar'
                });
                document.getElementById("fechaRegreso").value = "";
                document.getElementById("horaRegreso").value = "";
                return;
            }
        }

        calcularDiferencia();
    }

    function calcularDiferencia() {
        var fechaSalida = document.getElementById("fechaSalida").value;
        var horaSalida = document.getElementById("horaSalida").value;
        var fechaRegreso = document.getElementById("fechaRegreso").value;
        var horaRegreso = document.getElementById("horaRegreso").value;

        if (fechaSalida && horaSalida && fechaRegreso && horaRegreso) {
            var fechaHoraSalida = new Date(fechaSalida + "T" + horaSalida);
            var fechaHoraRegreso = new Date(fechaRegreso + "T" + horaRegreso);

            var diferenciaMs = fechaHoraRegreso - fechaHoraSalida;
            var diferenciaHoras = diferenciaMs / (1000 * 60 * 60);

            if (diferenciaHoras >= 0) {
                if (diferenciaHoras < 24) {
                    ocultarInputs();
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha y Hora Inválidas',
                    text: 'La fecha y hora de regreso deben ser posteriores a la de salida.',
                    confirmButtonText: 'Aceptar'
                });
            }
        }
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
                        window.location.href = '../../indexs/profesores/menuAdministrarSalidas.php';
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
