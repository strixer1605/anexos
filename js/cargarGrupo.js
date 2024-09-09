const buscarPersonasGrupo = function(grupo, callback) {
  $.ajax({
    method: 'POST',
    url: '../../php/buscarPersonasGrupos.php',
    data: { grupo: grupo },
    success:function(response) {
      const pasajeros = JSON.parse(response);
      console.log(pasajeros);
      callback(true, pasajeros);
    },
    error:function() {
      callback(false);
    }
  })
}

const cargarGrupos = function(personas) {
  console.log(personas);
  return $.ajax({
    method: 'POST',
    url: '../../php/agregarPersonaAnexoV.php',
    data: JSON.stringify({ personas: personas }), // Asegúrate de convertirlo a JSON
    contentType: 'application/json', // Indica que estás enviando JSON
  });
}

$('#cargarGrupo').on('click', function () {
  const idGrupo = $('#grupos').val();
  buscarPersonasGrupo(idGrupo, function(result, pasajeros) {
    if (result) {
      cargarGrupos(pasajeros).then(function(response){
        console.log(response);
        if (response.status === 'success') {
          console.log(response.message);
        } else if (response.status === 'error') {
          console.log(response.message);
        }
      }).catch(function(error) {
        console.error("Error en la carga de grupos:", error);
        alert('Ocurrió un error en la solicitud para cargar los grupos.');
      });
    } else {
      console.log("Ocurrió un error");
    }
  });
});

