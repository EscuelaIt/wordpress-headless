(async function(){
  const out = document.querySelector('#eventos-info');
  const tipos = document.querySelector('#tipos');
  

    // fetch('http://agenda.local/wp-json/wp/v2/eventos')
    await fetch('https://agenda.nemesisweb.dev/wp-json/wp/v2/eventos')
    .then( x => x.json())
    .then( eventos => {
      // let onemap = false;
      const coords = [];

      eventos.forEach(evento => {
        console.log(evento)
        const temp = document.getElementById('eventos-template');
        const clonedTemplate = temp.content.cloneNode(true);

        let card = clonedTemplate.querySelector('.evento-card');
        let title = clonedTemplate.querySelector('.evento-title');
        let info = clonedTemplate.querySelector('.evento-location');
        let date = clonedTemplate.querySelector('.evento-date');

        card.setAttribute('id', evento.id);
        title.innerHTML = evento.title.rendered;
        info.innerHTML = evento.acf.localidad;
        date.innerHTML = evento.acf.fecha;

        let latitud = evento.acf.coordenadas.latitud;
        let longitud = evento.acf.coordenadas.longitud;

        card.dataset.tipo = evento.tipo[0];

        coords.push([latitud, longitud, title]);
        out.appendChild(clonedTemplate);

      });


      var map = L.map('map').setView([coords[0][0], coords[0][1]], 15);
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);

      for (var i = 0; i < coords.length; i++) {
        marker = new L.marker([coords[i][0], coords[i][1]])
          .bindPopup(coords[i][2])
          .addTo(map);
      }

     
    })

    // fetch('http://agenda.local/wp-json/wp/v2/tipo')
    // fetch('http://localhost:8000/wp-json/wp/v2/tipus')
    fetch('https://agenda.nemesisweb.dev/wp-json/wp/v2/tipo')
    .then( x => x.json() )
    .then( tipo => {
      tipo.forEach( t => { console.log(t);
        const btn = document.createElement('button');
        btn.innerText = t.name
        btn.dataset.tax = t.id
        btn.addEventListener("click", filterTax);
        tipos.appendChild(btn);
      })

      const btn = document.createElement('button');
      btn.innerText = 'Todo'
      btn.dataset.tax = 'all'
      btn.addEventListener("click", showAll);
      tipos.appendChild(btn);
    })

    function filterTax(e) {
      const tax = e.target.dataset.tax
      const cards = document.querySelectorAll('.evento-card')
      cards.forEach(card => {
        if (card.dataset.tipo === tax) {
            card.classList.remove('eit-hidden');
        } else {
            card.classList.add('eit-hidden');
        }
      });
    }

    function showAll() {
      const cards = document.querySelectorAll('.evento-card')
      cards.forEach(card => {
        card.classList.remove('eit-hidden');
      });
    }





   
})()

