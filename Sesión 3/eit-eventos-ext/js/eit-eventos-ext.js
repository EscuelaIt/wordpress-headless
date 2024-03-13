document.addEventListener('DOMContentLoaded', function() {
  console.log('...eventos-ext.js')

fetchEventosExt()

function fetchEventosExt() {
    console.log('fetch enventos ext...')
    fetch('https://agenda.nemesisweb.dev/wp-json/eit/v1/eventos')
    .then( x => x.json())
    .then( eventos => {
      console.log('fetch eventos then...')
      console.log(eventos)
      const cardsContainer = document.getElementById('eventos-info-ext');
      cardsContainer.innerHTML = ''; // Limpiamos el contenedor de eventos antes de agregar nuevos
      eventos.forEach(evento => {
        console.log(evento)
        createCardExt(evento);
      });
    
    })
    .catch(error => {
        console.error('Error al obtener eventos:', error);
    });
  }

  function createCardExt(evento) {
    const out = document.querySelector('#eventos-info-ext');
    const temp = document.getElementById('eventos-template-ext'); // seleccionar el template i guardar-lo en una variable
    const clonedTemplate = temp.content.cloneNode(true); // clonar el template

    let card = clonedTemplate.querySelector('.evento-card');
    let title = clonedTemplate.querySelector('.evento-title');
    let info = clonedTemplate.querySelector('.evento-content');
    let img = clonedTemplate.querySelector('.evento-img');
    let link = clonedTemplate.querySelector('.evento-link');
    let tipo = clonedTemplate.querySelector('.evento-tipo');
    let precio = clonedTemplate.querySelector('.evento-precio');
    let lugar = clonedTemplate.querySelector('.evento-lugar');

    card.setAttribute('id', evento.id);
    info.innerHTML = evento.excerpt; 
    title.innerHTML = evento.titulo;
    img.setAttribute('src', evento.imagen_destacada);
    link.setAttribute('href', evento.link);
    tipo.innerHTML = evento.tipo.join(',');
    precio.innerHTML = evento.precio;
    lugar.innerHTML = evento.lugar;

    
    out.appendChild(clonedTemplate); // afegeix el clon amb tota la informació al section id="cards"
}

})