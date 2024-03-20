document.addEventListener('DOMContentLoaded', function() {
  fetch(`http://eitagenda.local/wp-json/eit/v1/eventos`) // cambiar la url por la que se quiera hacer la consulta
  .then(response => {
      if (!response.ok) {
          throw new Error('Ocurrió un error al cargar los eventos.');
      }
      return response.json();
  })
  .then(data => {
    console.log(data);
      // Renderizar la información de los eventos en el dashboard
      if (data.length > 0) {
          var eventsList = '<ul>';
          data.forEach(evento => {
              eventsList += `<li><a href="${evento.link}">${evento.titulo}</a></li>`;
          });
          eventsList += '</ul>';
          document.getElementById('eit-eventos-externos').innerHTML = eventsList;
      } else {
          document.getElementById('eit-eventos-externos').innerHTML = '<p>No hay eventos disponibles.</p>';
      }
  })
  .catch(error => {
      console.error(error);
      document.getElementById('eit-eventos-externos').innerHTML = '<p>' + error.message + '</p>';
  });
});
