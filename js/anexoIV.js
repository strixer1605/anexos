document.getElementById("formularioSalidas").addEventListener("submit", function(event) {

    var inputs = document.querySelectorAll("input[required], textarea[required]");
    for (var input of inputs) {
        if (input.value.trim() === "") {
            alert("Por favor, complete todos los campos obligatorios.");
            event.preventDefault(); // Evita el envío del formulario
            return;
        }
    }
    
    var telefono = document.getElementById("telefonoInstitucion").value;
    var telefonoPattern = /^\d{10}$/;
    if (!telefonoPattern.test(telefono)) {
        alert("El número de teléfono debe contener exactamente 10 dígitos.");
        event.preventDefault();
        return;
    }

    var numero = document.getElementById("numero").value;
    var numeroPattern = /^\d+$/;
    if (!numeroPattern.test(numero)) {
        alert("El campo 'N°' solo debe contener números.");
        event.preventDefault();
        return;
    }

    const checkboxes = document.querySelectorAll(".form-check-input");
    checkboxes.forEach(function(checkbox) {
        checkbox.value = checkbox.checked ? "1" : "0";
    });
    
    if (!confirm("¿Está seguro de que desea enviar el formulario con estos datos?")) {
        event.preventDefault();
    }
});

document.getElementById("fechaSalida").addEventListener("change", validarFechas);
document.getElementById("horaSalida").addEventListener("change", validarFechas);
document.getElementById("fechaRegreso").addEventListener("change", validarFechas);
document.getElementById("horaRegreso").addEventListener("change", validarFechas);

function validarFechas() {
    var fechaSalida = document.getElementById("fechaSalida").value;
    var horaSalida = document.getElementById("horaSalida").value;
    var fechaRegreso = document.getElementById("fechaRegreso").value;
    var horaRegreso = document.getElementById("horaRegreso").value;

    var fechaHoraActual = new Date();
    var fechaHoraSalida = new Date(fechaSalida + "T" + horaSalida);
    var fechaHoraRegreso = new Date(fechaRegreso + "T" + horaRegreso);

    // Validar que la fecha y hora de salida no estén en el pasado
    if (fechaHoraSalida < fechaHoraActual) {
        alert("La fecha y hora de salida no pueden ser en el pasado.");
        document.getElementById("fechaSalida").value = "";
        document.getElementById("horaSalida").value = "";
        return;
    }

    // Validar que la fecha de salida no sea más de un año en el futuro
    var unAnoEnMilisegundos = 365 * 24 * 60 * 60 * 1000; // Un año en milisegundos
    if (fechaHoraSalida - fechaHoraActual > unAnoEnMilisegundos) {
        alert("La fecha de salida no puede ser más de un año en el futuro.");
        document.getElementById("fechaSalida").value = "";
        document.getElementById("horaSalida").value = "";
        return;
    }

    // Validar que la fecha de regreso sea posterior a la fecha de salida
    if (fechaHoraRegreso <= fechaHoraSalida) {
        alert("La fecha y hora de regreso deben ser posteriores a la fecha y hora de salida.");
        document.getElementById("fechaRegreso").value = "";
        document.getElementById("horaRegreso").value = "";
        return;
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
            diferenciaHoras.toFixed(2) + " horas";
            if (diferenciaHoras < 24){
                ocultarInputs();
            }
        } else {
            document.getElementById("diferenciaHoras").value = "La fecha y hora de regreso debe ser posterior a la de salida";
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