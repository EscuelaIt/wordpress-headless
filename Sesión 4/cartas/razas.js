(function(){

  console.log('razas')

  const title = document.querySelector('.raza-title');
  let characters = [];

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const id = urlParams.get('id')
  const name = urlParams.get('name')
  title.innerText = name;  


  fetchCharacters(id);


  // Función para obtener los personajes de la API utilizando Axios
  async function fetchCharacters(id) {
    try {
      const response = await axios.get(`http://wpgame.local/wp-json/eit/v1/byraza/${id}`);
      characters = response.data;
      console.log(characters)
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
      // const selectButton = clonedCard.querySelector(".card__select");
      // const viewButton = clonedCard.querySelector(".card__view");
      // const link = clonedCard.querySelector(".card__link");

      // Asignar valores
      card.setAttribute('id', `card-${character.id}`)
      titleElement.textContent = character.nombre;
      infoElement.querySelector("p").innerHTML = character.texto;
      combatElement.querySelector("span:nth-child(1)").textContent = `A:${character.ataque}`;
      combatElement.querySelector("span:nth-child(2)").textContent = `D:${character.defensa}`;
      card.style = `--background: url('${character.imagen_destacada}')`;
      // link.setAttribute("href", `personaje.html?id=${character.id}`);

      // Añadir eventos a los botones
      // selectButton.addEventListener("click", () => selectCharacter(character.id));
      // viewButton.addEventListener("click", () => viewCharacter(character.id));

      // Añadir la tarjeta al contenedor
      container.appendChild(card);
    });
  }


})()