function capturarDatos() {
    let numeroRegistroArray = [];
    let fechaHabilitacionArray = [];
    let tipoHabilitacionArray = [];
    let cantidadAsientosArray = [];
    let vigenciaVTVArray = [];
    let polizaArray = [];
    let tipoSeguroArray = [];

    let nombresConductoresArray = [];
    let dnisConductoresArray = [];
    let carnetConductoresArray = [];
    let vigenciaConductoresArray = [];
    
    const cantidadConductores = document.getElementById("cantidadConductores").value;
    for (let i = 0; i < cantidadConductores; i++) {
        numeroRegistroArray.push(document.getElementById(`nroRegistro${i}`).value);
        fechaHabilitacionArray.push(document.getElementById(`fechaHabilitacion${i}`).value);
        tipoHabilitacionArray.push(document.getElementById(`tipoHabilitacion${i}`).value);
        cantidadAsientosArray.push(document.getElementById(`cantAsientos${i}`).value);
        vigenciaVTVArray.push(document.getElementById(`vigenciaVTV${i}`).value);
        polizaArray.push(document.getElementById(`nroPoliza${i}`).value);
        tipoSeguroArray.push(document.getElementById(`tipoSeguro${i}`).value);
    }

    const cantidadVehiculos = document.getElementById("cantidadVehiculos").value;
    for (let i = 0; i < cantidadVehiculos; i++) {
        nombresConductoresArray.push(document.getElementById(`nombreConductor${i}`).value);
        dnisConductoresArray.push(document.getElementById(`dniConductor${i}`).value);
        carnetConductoresArray.push(document.getElementById(`carnetConducir${i}`).value);
        vigenciaConductoresArray.push(document.getElementById(`vigenciaConductor${i}`).value);
    }

    document.getElementById("numeroRegistroArray").value = numeroRegistroArray.join(",");
    document.getElementById("fechaHabilitacionArray").value = fechaHabilitacionArray.join(",");
    document.getElementById("tipoHabilitacionArray").value = tipoHabilitacionArray.join(",");
    document.getElementById("cantidadAsientosArray").value = cantidadAsientosArray.join(",");
    document.getElementById("vigenciaVTVArray").value = vigenciaVTVArray.join(",");
    document.getElementById("polizaArray").value = polizaArray.join(",");
    document.getElementById("tipoSeguroArray").value = tipoSeguroArray.join(",");
    
    document.getElementById("nombresConductoresArray").value = nombresConductoresArray.join(",");
    document.getElementById("dnisConductoresArray").value = dnisConductoresArray.join(",");
    document.getElementById("carnetConductoresArray").value = carnetConductoresArray.join(",");
    document.getElementById("vigenciaConductoresArray").value = vigenciaConductoresArray.join(",");
}

document.addEventListener("DOMContentLoaded", function() {
    var anexoVIIIDiv = document.getElementById('anexoVIII');
    var anexoVIIIDivTab = document.getElementById('anexoVIII-tab');
    
    if (anexoVIIIHabil === "0") {
        if (anexoVIIIDiv) anexoVIIIDiv.style.display = 'none';
        if (anexoVIIIDivTab) anexoVIIIDivTab.style.display = 'none';
    }
    
    function validateAndSubmitAnexoVIII(event) {
        event.preventDefault();
        capturarDatos();
        enviarFormulario('formAnexoVIII', '../../php/insertAnexoVIII.php', 'Anexo VIII cargado correctamente!', 'planillaInfo-tab');
    }

    function validateAndSubmitAnexoPlanilla(event) {
        let firstInvalidField = null;
    
        const otrosCampos = [
            'empresas',
            'datosInfraestructura',
            'hospitalesCercanos',
            'datosInteres',
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
    
        enviarFormulario('formPlanilla', '../../php/insertPlanillaAnexo.php', 'Planilla cargada correctamente!', 'anexov-tab');
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
    document.getElementById('cargarPlanilla').addEventListener('click', validateAndSubmitAnexoPlanilla);
});
