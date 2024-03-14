(function(){


  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const id = urlParams.get('id')
  viewCharacter(id);

let character;
    // Función para obtener los personajes de la API utilizando Axios
  async function viewCharacter(id) {
    try {
      const response = await axios.get(`http://wpgame.local/wp-json/eit/v1/cards/${id}`);
      character = response.data;
      console.log(character)
      render();
    } catch (error) {
      console.error('Error al obtener los personajes:', error);
    }
  }

  function render() {
    console.log(character)

      // Obtener el template
      // const template = document.getElementById("modalTemplate");

      // Clonar el contenido del template
      // const modal = template.content.cloneNode(true);

      // Modificar los elementos del clon con los datos del personaje
      const cardModal = document.querySelector(".card-modal");
      const titleElement = document.querySelector(".card__title");
      const tipoElement = document.querySelector(".card__tipo a");
      const infoElement = document.querySelector(".card__info");
      const combatElement = document.querySelector(".card__combat");
      const img = document.querySelector(".card__img");

console.log(character.raza)
      // cardModal.setAttribute('id', `modal-${character.id}`)
      titleElement.innerHTML = character.nombre;
      tipoElement.innerHTML = character.raza.join(',');
      tipoElement.setAttribute("href", `razas.html?id=${character.raza_id}&name=${character.raza}`);
      infoElement.querySelector("p").innerHTML = character.texto;
      combatElement.querySelector("span:nth-child(1)").textContent = `Ataque: ${character.ataque}`;
      combatElement.querySelector("span:nth-child(2)").textContent = `Defensa: ${character.defensa}`;
      img.setAttribute("src", character.imagen_destacada);

      // Añadir evento para cerrar modal
      // const closeButton = modal.querySelector(".card__close");
      // closeButton.addEventListener("click", () => closeModal(`#modal-${character.id}`));

      // Añadir el modal al cuerpo del documento
      // document.body.appendChild(modal);
      // document.body.classList.add('modal')
  }

})()