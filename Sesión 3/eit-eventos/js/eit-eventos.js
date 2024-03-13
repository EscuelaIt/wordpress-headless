(function(){
  console.log('eit-eventos')
  const out = document.querySelector('#eventos-info');
  const tipos = document.querySelector('#tipos');

  const pagination = document.getElementById('eventos').dataset.perpage;
  const perPage = pagination ? pagination : 2;
  // perPage = 1;

  console.log(`%c Per page: ${perPage}`, 'background: #222; color: #bada55');





  let currentPage = 1; // Variable para controlar la página actual
  let totalPages = 1; // Variable para almacenar el total de páginas disponibles

  console.log(out);

  // fetchEventos();
  fetchPagedEventos();


    // fetch('http://eitagenda.local/wp-json/wp/v2/eventos')
    // .then( x => x.json())
    // .then( eventos => {
    //   eventos.forEach(evento => {
    //     createCard(evento);
    //   });
     
    // })
    // .catch(error => {
    //     console.error('Error al obtener eventos:', error);
    // });

  fetch('http://eitagenda.local/wp-json/wp/v2/tipo')
  .then( x => x.json() )
  .then( tipo => {
    tipo.forEach( t => { console.log(t);
      const btn = document.createElement('button');
      btn.innerText = t.name
      btn.dataset.tax = t.id
      // btn.addEventListener("click", filterTax);
      // btn.addEventListener("click", filterTaxFetch);
      btn.addEventListener("click", fetchPagedFilteredTax);

      tipos.appendChild(btn);
    })

    const btn = document.createElement('button');
    btn.innerText = 'Todo'
    btn.dataset.tax = 'all'
    // btn.addEventListener("click", showAll);
    // btn.addEventListener("click", fetchEventos);
    btn.addEventListener("click", fetchPagedEventos);
    tipos.appendChild(btn);
  })

  // Función para filtrar taxonomías por tipo usando CSS
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

  // Función para mostrar todos los eventos usando CSS
  function showAll() {
    const cards = document.querySelectorAll('.evento-card')
    cards.forEach(card => {
      card.classList.remove('eit-hidden');
    });
  }

  function createCard(evento) {
    const temp = document.getElementById('eventos-template'); // seleccionar el template i guardar-lo en una variable
    const clonedTemplate = temp.content.cloneNode(true); // clonar el template

    let card = clonedTemplate.querySelector('.evento-card');
    let title = clonedTemplate.querySelector('.evento-title'); // seleccionar el p i guardar-lo en una variable
    let info = clonedTemplate.querySelector('.evento-content'); // seleccionar el p i guardar-lo en una variable

    card.setAttribute('id', evento.id); // assigna l'id rebut de la API
    info.innerHTML = evento.excerpt.rendered; // assigna el text rebut de la API
    title.innerHTML = evento.title.rendered;
    card.dataset.tipo = evento.tipo[0];
    
    out.appendChild(clonedTemplate); // afegeix el clon amb tota la informació al section id="cards"
  }



  /**
   * Filtrar eventos por tipo con nuevo Fetch
  */

  // Función para obtener eventos filtrados por tipo, no paginados.
  function filterTaxFetch(e) {
    const tax = e.target.dataset.tax;
    if (tax === 'all') {
      fetchEventos();
    } else {
      fetch(`http://eitagenda.local/wp-json/wp/v2/eventos?tipo=${tax}`)
      .then(response => response.json())
      .then(eventos => {
          const cardsContainer = document.getElementById('eventos-info');
          cardsContainer.innerHTML = ''; // Limpiamos el contenedor de eventos antes de agregar nuevos
          eventos.forEach(evento => {
              createCard(evento);
          });
      })
      .catch(error => {
          console.error('Error al obtener eventos:', error);
      });
    }
  }
  
  // Función para obtener eventos no paginados. Devuelve todos los eventos.
  function fetchEventos() {
    fetch('http://eitagenda.local/wp-json/wp/v2/eventos')
    .then( x => x.json())
    .then( eventos => {
      const cardsContainer = document.getElementById('eventos-info');
      cardsContainer.innerHTML = ''; // Limpiamos el contenedor de eventos antes de agregar nuevos
      eventos.forEach(evento => {
        createCard(evento);
      });
    
    })
    .catch(error => {
        console.error('Error al obtener eventos:', error);
    });
  }
  









  /**
   * Paginación para eventos generales sin filtrar
  */




  // Función para obtener eventos paginados
  function fetchPagedEventos() {

    initializePagination();


    // const perPage = 2; // Cantidad de eventos por página
    const offset = (currentPage - 1) * perPage; // Calcular el desplazamiento
    const url = `http://eitagenda.local/wp-json/wp/v2/eventos?per_page=${perPage}&offset=${offset}`;

    fetch( url )
    // .then( x => x.json())
    .then(response => {
      console.log(response);
      const totalItems = response.headers.get('X-WP-Total');
      totalPages = Math.ceil(totalItems / perPage); // Calcular el total de páginas disponibles
      return response.json();
    })
    .then( eventos => {
      const cardsContainer = document.getElementById('eventos-info');
      cardsContainer.innerHTML = ''; // Limpiar el contenedor de eventos antes de agregar nuevos
      eventos.forEach(evento => {
        createCard(evento);
      });
      togglePaginationButtons(); // Actualizar la visibilidad de los botones de paginación
    
    })
    .catch(error => {
        console.error('Error al obtener eventos:', error);
    });
  }

    // Función para crear un botón de paginación
    function createPaginationButton(text, id, clickHandler) {
      const button = document.createElement('button');
      button.innerText = text;
      button.id = id;
      button.addEventListener('click', clickHandler);
      return button;
  }
  
  // Función para inicializar la paginación
  function initializePagination() {
      const paginationContainer = document.getElementById('pagination-container');
      paginationContainer.innerHTML = ''; // Limpiar contenedor de paginación
  
      const prevButton = createPaginationButton('Anterior', 'prev-page', () => {
          if (currentPage > 1) {
              currentPage--;
              fetchPagedEventos();
          }
      });
  
      const nextButton = createPaginationButton('Siguiente', 'next-page', () => {
          if (currentPage < totalPages) {
              currentPage++;
              fetchPagedEventos();
          }
      });
  
      paginationContainer.appendChild(prevButton);
      paginationContainer.appendChild(nextButton);
  
      togglePaginationButtons(); // Actualizar la visibilidad de los botones de paginación
  }
  
  // Llamar a la función para inicializar la paginación al cargar la página
  // initializePagination();

// Función para controlar la visibilidad de los botones de paginación
function togglePaginationButtons() {
  const prevButton = document.getElementById('prev-page');
  const nextButton = document.getElementById('next-page');
  if (currentPage === 1) {
      prevButton.style.display = 'none';
  } else {
      prevButton.style.display = 'inline-block';
  }
  if (currentPage === totalPages) {
      nextButton.style.display = 'none';
  } else {
      nextButton.style.display = 'inline-block';
  }
}











  /**
   * Paginación para eventos filtrados por taxonomía
  */




  // let currentTax = 'all'; // Variable para controlar la taxonomía actual


  function fetchPagedFilteredTax(e) {
    console.log(e);

    initializeTaxPagination(e.target.dataset.tax);

    // const tax = e.target.dataset.tax ? e.target.dataset.tax : currentTax;
    const tax = e.target.dataset.tax;
    // const perPage = 1; // Cantidad de eventos por página
    const offset = (currentPage - 1) * perPage; // Calcular el desplazamiento
    const url = `http://eitagenda.local/wp-json/wp/v2/eventos?tipo=${tax}&per_page=${perPage}&offset=${offset}`;

    if (tax === 'all') {
      fetchPagedEventos();
    } else {
      fetch(url)
      // .then(response => response.json())
      .then(response => {
        const totalItems = response.headers.get('X-WP-Total');
        totalPages = Math.ceil(totalItems / perPage); // Calcular el total de páginas disponibles
        return response.json();
      })
      .then(eventos => {
          const cardsContainer = document.getElementById('eventos-info');
          cardsContainer.innerHTML = ''; // Limpiamos el contenedor de eventos antes de agregar nuevos
          eventos.forEach(evento => {
              createCard(evento);
          });
          togglePaginationButtons(); // Actualizar la visibilidad de los botones de paginación
      })
      .catch(error => {
          console.error('Error al obtener eventos:', error);
      });
    }
  }



  function createPaginationTaxButton(tax, text, id, clickHandler) {
    console.log('create tax button', tax)
    const button = document.createElement('button');
    button.innerText = text;
    button.id = id;
    button.dataset.tax = tax;
    button.addEventListener('click', clickHandler);
    return button;
  }

  function initializeTaxPagination(tax) {
    const paginationContainer = document.getElementById('pagination-container');
    paginationContainer.innerHTML = ''; // Limpiar contenedor de paginación

    const prevButton = createPaginationTaxButton(tax,'Tax Anterior', 'prev-page', (e) => {
        if (currentPage > 1) {
            currentPage--;
            fetchPagedFilteredTax(e);
        }
    });

    const nextButton = createPaginationTaxButton(tax,'Tax Siguiente', 'next-page', (e) => {
        if (currentPage < totalPages) {
            currentPage++;
            fetchPagedFilteredTax(e);
        }
    });

    paginationContainer.appendChild(prevButton);
    paginationContainer.appendChild(nextButton);

    togglePaginationButtons(); // Actualizar la visibilidad de los botones de paginación
  }



   
})()