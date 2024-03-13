
document.addEventListener('DOMContentLoaded', function() {
  // Realizar una solicitud a la REST API para obtener la información de los eventos
  // Toma los parámetros indicados en la función eit-eventos.php -> eit_custom_dashboard_script()
  fetch(customDashboardParams.apiUrl, {
      method: 'GET',
      headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': customDashboardParams.nonce // Agrega un nonce si es necesario
      },
  })
  
  // fetch('http://eitagenda.local/wp-json/eit/v1/eventos') // también se puede hacer el fetch directamente hacia la url indicada
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
              // eventsList += '<li><a href="' + evento.link + '">' + evento.titulo + '</a></li>';
              eventsList += `<li><a href="${evento.link}">${evento.titulo}</a></li>`;
          });
          eventsList += '</ul>';
          document.getElementById('eit-events').innerHTML = eventsList;
      } else {
          document.getElementById('eit-events').innerHTML = '<p>No hay eventos disponibles.</p>';
      }
  })
  .catch(error => {
      console.error(error);
      document.getElementById('eit-events').innerHTML = '<p>' + error.message + '</p>';
  });
});
