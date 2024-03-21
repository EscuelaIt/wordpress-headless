<template>
  <form @submit.prevent="submitEventForm">
    <label for="title">Nombre del evento</label>
    <input type="text" v-model="title">

    <label for="tipos">Tipo de evento</label>
    <select v-model="tipo">
      <option v-for="t in tipos" :key="t.id" :value="t.id">{{ t.name }}</option>
    </select>

    <label for="desc">Descripción</label>
    <textarea v-model="desc"></textarea>

    <label for="price">Precio</label>
    <input type="number" v-model="price">

    <label for="location">Localidad</label>
    <input type="text" v-model="location">

    <label for="date">Fecha</label>
    <input id="date" type="text" v-model="date">

    <label for="lat">Latitud</label>
    <input type="text" v-model="lat">

    <label for="lon">Longitud</label>
    <input type="text" v-model="lon">

    <input type="submit" value="Crear Evento">
  </form>
</template>

<script setup>
import { ref, onMounted, onBeforeMount } from 'vue';
import axios from 'axios';
import flatpickr from 'flatpickr';
import { useGlobalStore } from '@/stores/global.js';
import myAPI from '@/services/services.js';
import { useRouter } from 'vue-router';

const router = useRouter();

const globalStore = useGlobalStore();

let token;
const title = ref('');
const tipo = ref('');
const desc = ref('');
const price = ref('');
const location = ref('');
const date = ref('');
const lat = ref('');
const lon = ref('');
const tipos = ref([]);

onBeforeMount(() => {
  token = sessionStorage.getItem('eit-token');
  if ( !token ) {
    router.push({ path: '/login' });
  }
})

onMounted(() => {
  // Verificar si el token existe en sessionStorage
  // token = sessionStorage.getItem('eit-token');
  // if (!token) {
  //   // Si el token no existe, redirigir a la página de login
  //   window.location.href = 'login.html';
  // }

  // Inicializar Flatpickr
  flatpickr("#date", {
    enableTime: true,
    dateFormat: "Y-m-d H:i:00",
    defaultHour: 0,
    defaultMinute: 0,
    minuteIncrement: 1
  });

  // Obtener tipos de evento
  axios.get(`${globalStore.apiUrl}/wp/v2/tipo`)
    .then(response => {
      tipos.value = response.data;
    })
    .catch(error => {
      console.error('Error fetching tipos:', error);
    });
});

const submitEventForm = () => {
  const data = {
    title: title.value,
    tipo: tipo.value,
    content: desc.value,
    acf: {
      localidad: location.value,
      precio: price.value,
      fecha: date.value,
      coordenadas: {
        latitud: lat.value,
        longitud: lon.value,
      },
    },
    status: 'draft'
  };

  // Enviar los datos a la REST API de WordPress utilizando Axios
  // axios.post(`${globalStore.apiUrl}/wp/v2/eventos`, data, {
  //     headers: {
  //         'Content-Type': 'application/json',
  //         'Authorization': `Bearer ${token}`
  //     }
  // })
  myAPI.createEvento(data, token)
  .then(response => {
    console.log(response.data);
    // Haz algo con la respuesta si es necesario
  })
  .then(response => {
      alert('Evento guardado exitosamente');
  })
  .catch(error => {
      console.error('Error:', error);
      alert('Error al guardar el evento');
  });
};
</script>

<style>
  @import "https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css";
  form {
    display: grid;
    width: 700px;
    max-width: 100%;

    & input,select {
      padding: .5rem 1rem;
    }

    & input[type="submit"] {
      cursor: pointer;
      width: fit-content;
      margin: 2rem auto;
    }
  }
</style>
