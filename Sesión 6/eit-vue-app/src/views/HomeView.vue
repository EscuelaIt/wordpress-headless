<template>
  <div>
    <h1>Página de inicio</h1>

    <section id="eventos">
      <h2>Eventos</h2>
      <div id="tipos">
        <button v-for="tipo in tipos" :key="tipo.id" @click="filterTax(tipo.id)">{{ tipo.name }}</button>
        <button @click="showAll">Todo</button>
      </div>
      <div id="eventos-info" class="eventos-info">
        <!-- <article v-for="evento in eventos" :key="evento.id" class="evento-card" :tipo="evento.tipo">
          <h2 class="evento-title">{{ evento.title.rendered }}</h2>
          <div class="info">
            <div class="evento-location">{{ evento.acf.localidad }}</div>
            <div class="evento-date">{{ evento.acf.fecha }}</div>
          </div>
        </article> -->
        <!-- <CardInfo v-for="evento in eventos" :key="evento.id" :title="evento.title.rendered" :localidad="evento.acf.localidad" :fecha="evento.acf.fecha" :tipo="evento.tipo" /> -->
        <CardInfo v-for="evento in eventos" :key="evento.id" :evento="evento" @click="$router.push({ name: 'event', params: {eventId: evento.id } })" />
      </div>
    </section>
  </div>
</template>


<script setup>

import CardInfo from '../components/CardInfo.vue'

import { ref, onMounted } from 'vue';
import axios from 'axios';
// import { useGlobalStore } from '@/stores/global.js';
import myAPI from '../services/services.js'


// const globalStore = useGlobalStore();

const eventos = ref([]);
const tipos = ref([]);
const filtro = ref('all');

const fetchEventos = async () => {
  try {
    // const response = await axios.get(`http://eitagenda.local/wp-json/wp/v2/eventos`);
    // const response = await axios.get(`${globalStore.apiUrl}/wp/v2/eventos`);
    const response = await myAPI.getEventos();

    eventos.value = response.data;
  } catch (error) {
    console.error('Error fetching eventos:', error);
  }

  // fetch(`${globalStore.apiUrl}/wp/v2/eventos`)
  // .then(x => {
  //   console.log(x)
  //   return x.json()
  // })
  // .then( x => console.log(x))
};

const fetchTipos = async () => {
  try {
    // const response = await axios.get(`https://agenda.nemesisweb.dev/wp-json/wp/v2/tipo`);
    // const response = await axios.get(`${globalStore.apiUrl}/wp/v2/tipo`);
    const response = await myAPI.getTipos();
    // console.log(response);
    tipos.value = response.data;
  } catch (error) {
    console.error('Error fetching tipos:', error);
  }
};

// const filterTax = (tax) => {
//   filtro.value = tax;
// };

const filterTax = (tax) => {
  filtro.value = tax;
  // Iterar sobre todos los elementos y actualizar su visibilidad según el tipo
  document.querySelectorAll('.evento-card').forEach(card => {
    if (tax === 'all' || card.getAttribute('tipo') === String(tax) ) {
      card.classList.remove('eit-hidden');
    } else {
      card.classList.add('eit-hidden');
    }
  });
};

const showAll = () => {
  document.querySelectorAll('.evento-card').forEach(card => {
    card.classList.remove('eit-hidden');
  });
};

//Lifecycle hook
onMounted(() => {
  fetchEventos();
  fetchTipos();
});
</script>

<style>
.eit-hidden {
  display: none;
}
.eventos-info {
  display: grid;
  gap: 1rem;
}
</style>


