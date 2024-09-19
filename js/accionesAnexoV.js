$(document).ready(function(){
    cargarTablaPasajeros();
    $('#dniSearch, #agregarPersona').on('keydown', function(event){
        if (event.which === 13) {
            event.preventDefault();
            $("#agregarPersona").click();  
        }
    })

    $('#dniAcompañante, #nombreAcompañante, #edadAcompañante').on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $('#cargarAcompañante').click(); 
        }
    });
    
    $("#dniSearch").keyup(function(event) {
        var dniPersona = $("#dniSearch").val();
        $.ajax({
            type: 'POST',
            url: '../../php/buscarPersona.php',
            data: {dniPersona: dniPersona},
            success:function(response){
                // console.log(response);
                
                var select = document.getElementById('coincidenciaPersona');
                select.innerHTML = '';

                //parsear la respuesta JSON
                const personas = JSON.parse(response);

                if (personas.error) {
                    // console.log(personas.error);
                    return;
                    
                }
                //iterar sobre cada persona y agregarla al seelect
                const cargarPersona = function(persona) {
                    var option = document.createElement('option');
                    option.value = persona.dni; //asigna el valor al value
                    option.textContent = `${persona.nombre} ${persona.apellido}`; //asigna el valor del texto
                    option.setAttribute('data-cargo', persona.cargo);
                    option.setAttribute('data-fechan', persona.fechan);
                    select.appendChild(option);
                }
                //recorre el array personas y llama a la función que agrega personas al select
                for (let i = 0; i < personas.length; i++){
                    cargarPersona(personas[i]);

                }
            },
            error:function(response) {
                
            }
        })
        
    })
    
    $("#agregarPersona").click(function(){
        const select = document.getElementById('coincidenciaPersona');
        const selectedOption = select.options[select.selectedIndex];
        const dni = selectedOption.value;
        const nombreApellido = selectedOption.textContent;
        const cargo = selectedOption.getAttribute('data-cargo');
        const fechan = selectedOption.getAttribute('data-fechan');
        const idAnexoIV = salidaIDSesion;
        
        $.ajax({
            type: 'POST',
            url: '../../php/agregarPersonaAnexoV.php',
            data: {
                dni,
                nombreApellido,
                cargo,
                fechan,
                idAnexoIV,
                opcion: 'agregarPersona'
            },
            success:function(response) {
                const datos = JSON.parse(response);

                if (datos.status === 'success') {
                    cargarTablaPasajeros();
                    $('#dniSearch').val("");
                    
                } else if (datos.status === 'error') {
                    alert (datos.message);
                }
            },
            error:function(response) {
                alert ("Ocurrió un error");
            }
        })                    
    })

    $('#cargarAcompañante').click(function() {
        // Obtener los valores de los campos
        const dniAcompañante = document.getElementById('dniAcompañante').value.trim();
        const nombreAcompañante = document.getElementById('nombreAcompañante').value.trim();
        const edadAcompañante = document.getElementById('edadAcompañante').value.trim();

        // Validar que los campos no estén vacíos
        if (dniAcompañante === '' || nombreAcompañante === '' || edadAcompañante === '') {
            alert('Por favor, complete todos los campos.');
            return; // Salir de la función si hay campos vacíos
        }

        // Validar formato de DNI (debe ser un número de 8 dígitos)
        if (!/^\d{8}$/.test(dniAcompañante)) {
            alert('El DNI debe tener 8 dígitos.');
            return; // Salir de la función si el formato es incorrecto
        }

        // Enviar los datos por AJAX
        $.ajax({
            method: 'POST',
            url: '../../php/agregarPersonaAnexoV.php',
            data: {
                dniAcompañante,
                nombreAcompañante,
                edadAcompañante,
                opcion: 'agregarAcompañante'
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    cargarTablaPasajeros();
                    alert(response.message);
                } else if (response.status === 'error') {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                // console.log("Error en la solicitud:", error); // Para depurar el error si ocurre
                alert("Ocurrió un error en la comunicación con el servidor.");
            }
        });
    });

    $('#selectAll').click(function() {
        if($('.selectPersona').prop('checked') == false){
            $('.selectPersona').prop('checked', true);
        }
        else {
            $('.selectPersona').prop('checked', false);
        }
    })

    $(document).on('click', '#eliminarSeleccionados', function() {
        
        //Obtener checkboxes seleccionados
        const seleccionados = [];
        $('.selectPersona:checked').each(function() {
            seleccionados.push($(this).val());
        });

        //Deshabilita el boton eliminar temporalmente por conflicto con focus
        const eliminarBtn = $(this);
        eliminarBtn.prop('disabled', true);
        const habilitarBoton = eliminarBtn.prop('disabled', false);

        if (seleccionados.length > 0) {
            $.ajax({
                method: 'POST',
                url: '../../php/eliminarPersonaAnexoV.php',
                data: {dniList: seleccionados},
                success: function(response) {
                    Swal.fire({
                        icon: "success",
                        title: "Persona/s eliminada/s correctamente",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        cargarTablaPasajeros();
                        document.getElementById('dniSearch').focus();
                        habilitarBoton;
                    });
                },
                error: function(){
                    Swal.fire({
                        icon: "warning",
                        title: "Ocurrió un error al eliminar a las personas",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        document.getElementById('dniSearch').focus();
                        habilitarBoton;
                    });
                }
            })
        }
        habilitarBoton;
    })

    const buscarPersonasGrupo = function(grupo, callback) {
        $.ajax({
            method: 'POST',
            url: '../../php/buscarPersonasGrupos.php',
            data: { grupo: grupo },
            success:function(response) {
                const pasajeros = JSON.parse(response);
                callback(true, pasajeros);
            },
            error:function() {
                callback(false);
            }
        })
        }
        
    const cargarGrupos = function(personas) {
        return $.ajax({
            method: 'POST',
            url: '../../php/agregarPersonaAnexoV.php',
            data: JSON.stringify({ personas: personas, opcion: 'agregarGrupo' }),
            contentType: 'application/json',
        });
    }
      
    $('#cargarGrupo').on('click', function () {
        //Obtiene el value del select
        const idGrupo = $('#grupos').val();
        
        buscarPersonasGrupo(idGrupo, function(result, pasajeros) {
            if (result) {
            cargarGrupos(pasajeros).then(function(response){
                console.log(response);
                if (response.status === 'success') {
                    cargarTablaPasajeros();
                    // console.log(response.message);
                } 
                else if (response.status === 'error') {
                    // console.log(response.message);
                }

            }).catch(function(error) {
                // console.error("Error en la carga de grupos:", error);
                alert('Ocurrió un error en la solicitud para cargar los grupos.');
            });
            } else {
                // console.log("Ocurrió un error");
            }
        });
    });

    function cargarTablaPasajeros() {
        $.ajax({
            method: 'GET',
            url: '../../php/traerPersonasAnexoV.php',
            success: function(response) {
                const pasajeros = JSON.parse(response);
                let tablaHTML = '';
                
                let cantidadMenores = 0;     
                let cantidadSemiMayores = 0;
                let cantidadMayores = 0;
                let cantidadDocentes = 0;
                let indice = 0;
                
                pasajeros.forEach(function(pasajero) {
                    let pasajeroEdad = pasajero.edad;
                    let alumno = '';
                    let docente = '';
                    let noDocente = '';
            
                    // Clasificar por edad
                    if (pasajeroEdad < 16) {
                        cantidadMenores += 1;
                    } else if (pasajeroEdad >= 16 && pasajeroEdad < 18) {
                        cantidadSemiMayores += 1;
                    } else if (pasajeroEdad >= 18 && parseInt(pasajero.cargo) != 2) {
                        cantidadMayores += 1;
                    }
            
                    if (parseInt(pasajero.cargo) === 2) {
                        cantidadDocentes += 1;
                    }
            
                    indice += 1;
                    switch (parseInt(pasajero.cargo)) {
                        case 2: docente = 'X'; break;
                        case 3: alumno = 'X'; break;
                        case 4: noDocente = 'X'; break;
                    }
            
                    tablaHTML += `<tr>
                                    <td>${indice}</td>
                                    <td>${pasajero.apellidoNombre}</td>
                                    <td>${pasajero.dni}</td>
                                    <td>${alumno}</td>
                                    <td>${pasajero.edad}</td>
                                    <td>${docente}</td>
                                    <td>${noDocente}</td>
                                    <td>
                                        <input type="checkbox" class="selectPersona" value="${pasajero.dni}">
                                    </td>
                                </tr>`;
                });
            
                // Calcular docentes necesarios
                let docentesMenores = Math.ceil(cantidadMenores / 12);  // Docentes para menores de 16
                let docentesSemiMayores = Math.ceil(cantidadSemiMayores / 15);  // Docentes para 16-17 años
                let docentesMayores = cantidadMayores > 0 ? 1 : 0;  // Docentes para mayores de 18, al menos 1
            
                // Recalcular si sobran menores (si hay menos de 12)
                if (cantidadMenores % 12 !== 0 && cantidadMenores < 12) {
                    let sobrantesMenores = cantidadMenores % 12;
                    cantidadSemiMayores += sobrantesMenores;
                    docentesMenores = Math.floor(cantidadMenores / 12);
                    docentesSemiMayores = Math.ceil(cantidadSemiMayores / 15);
                }
            
                // Calcular el total de docentes necesarios
                let totalDocentesRequeridos = docentesMenores + docentesSemiMayores + docentesMayores;
            
                if (totalDocentesRequeridos > 5) {
                    alert("Se recomienda agregar más docentes debido a la cantidad de alumnos.");
                }
            
                let alertaHtml = '';
                if (cantidadDocentes < totalDocentesRequeridos) {
                    alertaHtml = '<p>Anexo 5 no aprobable</p>';
                } else {
                    alertaHtml = '<p>Anexo 5 aprobable</p>';
                }
            
                let calculoDocentes = `
                    <h5>Menores de 16: ${cantidadMenores}</h5>
                    <h5>Entre 16 y 17: ${cantidadSemiMayores}</h5>
                    <h5>Mayores de 18: ${cantidadMayores}</h5>
                    <h5>Docentes requeridos: ${totalDocentesRequeridos}</h5>
                    <h5>Docentes actuales: ${cantidadDocentes}</h5>
                `;
            
                $('#advice').html(alertaHtml + calculoDocentes);
                $('#tablaParticipantes').html(tablaHTML);
            },
            
            error: function() {
                alert("Ha ocurrido un error al obtener los pasajeros");
            }
        });
    }      
})