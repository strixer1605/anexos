$(document).ready(function () {
  $('#cargarGrupo').on('click', function () {
    const idGrupo = $('#grupos').val();

    if (idGrupo) {
      buscarPersonasGrupo(idGrupo)
        .then(function (personas) {
          return cargarGrupos(personas);
        })
        .then(function (resultadoCarga) {
          console.log('Carga realizada correctamente:', resultadoCarga);
        })
        .catch(function (error) {
          console.error('Ocurrió un error:', error);
        });
    }
  });
});

function buscarPersonasGrupo(grupo) {
  return $.ajax({
    method: 'POST',
    url: '../../php/buscarPersonasGrupos.php',
    data: { grupo: grupo },
  }).then(function (response) {
    return JSON.parse(response);
  });
}

function cargarGrupos(personas) {
  return $.ajax({
    method: 'POST',
    url: '../../php/cargarPersonasAnexoV.php',
    data: { personas: personas },
  });
}
