document.addEventListener('DOMContentLoaded', function() {
  console.log('...eventos-filter.js')
  
  console.log(eitParams.tax);
  
  fetchEventosExt()

  const coords = [];
  
  function fetchEventosExt() {
    console.log('fetch enventos filter...')
    // fetch(`${eitParams.apiUrl}/eit/v1/eventos`)
    const params = eitParams.tax.join(',')
    console.log(`${eitParams.apiUrl}/eventos?tipo=${params}`)
    fetch(`${eitParams.apiUrl}/eventos?tipo=${params}`)
    // fetch('https://agenda.nemesisweb.dev/wp-json/wp/v2/eventos?tipo=6,4')
    .then( x => x.json())
    .then( eventos => {
      console.log('fetch eventos then...')
      console.log(eventos)
      const cardsContainer = document.getElementById('eventos-info-filtered');
      cardsContainer.innerHTML = ''; // Limpiamos el contenedor de eventos antes de agregar nuevos
      eventos.forEach(evento => {
        console.log(evento)
        createCardExt(evento);

        let latitud = evento.acf.coordenadas.latitud;
        let longitud = evento.acf.coordenadas.longitud;
        let title = evento.title.rendered;
        coords.push([latitud, longitud, title]);

      });

      var map = L.map('map').setView([coords[0][0], coords[0][1]], 15);
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);

      for (var i = 0; i < coords.length; i++) {
        marker = new L.marker([coords[i][0], coords[i][1]])
          .bindPopup(coords[i][2])
          .addTo(map);
      }
    
    })
    .catch(error => {
        console.error('Error al obtener eventos:', error);
    });
  }

  function createCardExt(evento) {
    const out = document.querySelector('#eventos-info-filtered');
    const temp = document.getElementById('eventos-template-filtered'); // seleccionar el template i guardar-lo en una variable
    const clonedTemplate = temp.content.cloneNode(true); // clonar el template

    let card = clonedTemplate.querySelector('.evento-card');
    let title = clonedTemplate.querySelector('.evento-title');
    let link = clonedTemplate.querySelector('.evento-link');
    let precio = clonedTemplate.querySelector('.evento-precio');
    let lugar = clonedTemplate.querySelector('.evento-lugar');

    card.setAttribute('id', evento.id);
    link.setAttribute('href', evento.link);
    link.innerHTML = evento.title.rendered;
    precio.innerHTML = evento.acf.precio;
    lugar.innerHTML = evento.acf.localidad;

    
    out.appendChild(clonedTemplate); // afegeix el clon amb tota la informació al section id="cards"
}

})