(function(){

  // const bodyContainer = document.querySelector('body');
  let characters = [];

  // Función para obtener los personajes de la API utilizando Axios
  async function fetchCharacters() {
    try {
      const response = await axios.get('http://wpgame.local/wp-json/eit/v1/cards');
      console.log(response)
      characters = response.data;
      renderCharacters();
    } catch (error) {
      console.error('Error al obtener los personajes:', error);
    }
  }


  // Función para mostrar los personajes en cartas
  function renderCharacters() {
    const container = document.getElementById("characters-container");
    container.innerHTML = "";

    characters.forEach(character => {
      // Obtener el template
      const template = document.getElementById("characterTemplate");

      // Clonar el contenido del template
      const clonedCard = template.content.cloneNode(true);

      // Selecciounar los elementos del clon
      const card = clonedCard.querySelector(".card");
      const titleElement = clonedCard.querySelector(".card__title");
      const infoElement = clonedCard.querySelector(".card__info");
      const combatElement = clonedCard.querySelector(".card__combat");
      const selectButton = clonedCard.querySelector(".card__select");
      const viewButton = clonedCard.querySelector(".card__view");
      const link = clonedCard.querySelector(".card__link");

      // Asignar valores
      card.setAttribute('id', `card-${character.id}`)
      titleElement.textContent = character.nombre;
      infoElement.querySelector("p").innerHTML = character.texto;
      combatElement.querySelector("span:nth-child(1)").textContent = `A:${character.ataque}`;
      combatElement.querySelector("span:nth-child(2)").textContent = `D:${character.defensa}`;
      card.style = `--background: url('${character.imagen_destacada}')`;
      link.setAttribute("href", `personaje.html?id=${character.id}`);

      // Añadir eventos a los botones
      selectButton.addEventListener("click", () => selectCharacter(character.id));
      viewButton.addEventListener("click", () => viewCharacter(character.id));

      // Añadir la tarjeta al contenedor
      container.appendChild(card);
    });
  }

  // Llama a la función para obtener los personajes al cargar la página
  window.onload = fetchCharacters;




  let character;
    // Función para obtener los personajes de la API utilizando Axios
  async function viewCharacter(id) {
    try {
      const response = await axios.get(`http://wpgame.local/wp-json/eit/v1/cards/${id}`);
      character = response.data;
      console.log(character)
      renderModal();
    } catch (error) {
      console.error('Error al obtener los personajes:', error);
    }
  }

  function renderModal() {
      // Obtener el template
      const template = document.getElementById("modalTemplate");

      // Clonar el contenido del template
      const modal = template.content.cloneNode(true);

      // Modificar los elementos del clon con los datos del personaje
      const cardModal = modal.querySelector(".card-modal");
      const titleElement = modal.querySelector(".card__title");
      const infoElement = modal.querySelector(".card__info");
      const combatElement = modal.querySelector(".card__combat");
      const img = modal.querySelector(".card__img");

      cardModal.setAttribute('id', `modal-${character.id}`)
      titleElement.textContent = character.nombre;
      infoElement.querySelector("p").innerHTML = character.texto;
      combatElement.querySelector("span:nth-child(1)").textContent = `Ataque: ${character.ataque}`;
      combatElement.querySelector("span:nth-child(2)").textContent = `Defensa: ${character.defensa}`;
      img.setAttribute("src", character.imagen_destacada);

      // Añadir evento para cerrar modal
      const closeButton = modal.querySelector(".card__close");
      closeButton.addEventListener("click", () => closeModal(`#modal-${character.id}`));

      // Añadir el modal al cuerpo del documento
      document.body.appendChild(modal);
      document.body.classList.add('modal');
  }

  function closeModal(id) {
    const target = document.querySelector(id)
    target.remove();
    document.body.classList.remove('modal')
  }


  let selectedCharacters = [];

  // Función para seleccionar un personaje
  function selectCharacter(id) {
    console.log(id);
    const target = document.querySelector(`#card-${id}`)
    target.classList.add('selected');
    const character = characters.find(char => char.id === id);
    if (selectedCharacters.length < 2 && !selectedCharacters.includes(character)) {
      selectedCharacters.push(character);
    }

    if (selectedCharacters.length === 2) {
      fight();
    }
  }

  // Función para simular la lucha entre los personajes seleccionados
  function fight() {
    const attacker = selectedCharacters[0];
    const defender = selectedCharacters[1];

    console.log(attacker)
    // console.log(attacker.acf.ataque)
    console.log(defender)
    // console.log(defender.acf.defensa)

    let resultMessage = "";

    if (parseInt(attacker.ataque) > parseInt(defender.defensa)) {
      resultMessage = `${attacker.nombre} ataca a ${defender.nombre} y gana.`;
    } else {
      resultMessage = `${defender.nombre} se defiende de ${attacker.nombre} y gana.`;
    }

    selectedCharacters = [];

    // document.getElementById("result").innerText = resultMessage;
    const template = document.getElementById("modal-result");

    // Clonar el contenido del template
    const modal = template.content.cloneNode(true);

    // Selecciounar los elementos del clon
    const msg = modal.querySelector(".result__msg");
    const btn = modal.querySelector(".result__close");

    msg.innerHTML = resultMessage;

    btn.addEventListener("click", () => closeModal(`#result-msg`));

    document.body.appendChild(modal);
    document.body.classList.add('modal')


  }


})()