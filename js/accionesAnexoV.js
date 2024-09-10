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
                idAnexoIV
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
                edadAcompañante
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    cargarTablaPasajeros(); // Llama a la función para actualizar la tabla
                    alert(response.message); // Muestra el mensaje de éxito
                } else if (response.status === 'error') {
                    alert(response.message); // Muestra el mensaje de error
                }
            },
            error: function(xhr, status, error) {
                // console.log("Error en la solicitud:", error); // Para depurar el error si ocurre
                alert("Ocurrió un error en la comunicación con el servidor.");
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
                let indice = 0;
                pasajeros.forEach(function(pasajero) {
                    let alumno = '';
                    let docente = '';
                    let noDocente = '';
                    
                    indice += 1;
                    switch(parseInt(pasajero.cargo)) {
                        case 2: docente = 'X';
                                break;
                        case 3: alumno = 'X';
                                break;
                        case 4: noDocente = 'X';
                                break;
                    }
                    tablaHTML +=`<tr>
                                    <td>${indice}</td>
                                    <td>${pasajero.apellidoNombre}</td>
                                    <td>${pasajero.dni}</td>
                                    <td>${alumno}</td>
                                    <td>${pasajero.edad}</td>
                                    <td>${docente}</td>
                                    <td>${noDocente}</td>
                                    <td>
                                        <input type = "checkbox" class = "selectPersona" value = "${pasajero.dni}">
                                    </td>
                                </tr>`;
                });

                $('#tablaParticipantes').html(tablaHTML);

            },
            error: function() {
                alert ("Ha ocurrido un error al obtener los pasajeros")
            }
        })
    }

    //seleccionar todos los integrantes de la salida
    $('#selectAll').click(function() {
        $('.selectPersona').prop('checked', true);
    })

    //eliminar integrantes de la salida seleccionados
    $(document).on('click', '#eliminarSeleccionados', function() {
        
        //obtener checkboxes seleccionados
        const seleccionados = [];
        $('.selectPersona:checked').each(function() {
            seleccionados.push($(this).val());
        });

        //deshabilita el boton eliminar temporalmente por conflicto con focus
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
            data: JSON.stringify({ personas: personas }), // se asegura de convertirlo a JSON
            contentType: 'application/json', // Indica que se está enviando JSON
        });
    }
      
    $('#cargarGrupo').on('click', function () {
        //obtiene el value del select
        const idGrupo = $('#grupos').val();
        
        buscarPersonasGrupo(idGrupo, function(result, pasajeros) {
            if (result) {
            cargarGrupos(pasajeros).then(function(response){
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
      
      
})