<template>
  <div class="new">
    <h1>Evento</h1>
    <p>ID: {{ props.eventId }}</p>
    <!-- <CardInfo :evento="info" /> -->
    <h2>{{ info.title.rendered }}</h2>
    <h3>{{ info.acf.localidad }}</h3>
    <p v-html="info.content.rendered"></p>
    <!-- <p>{{info.content.rendered}}</p> -->
    <div>Precio: {{ info.acf.precio }}€</div>

    <div id="map" style="height: 400px;"></div>
  </div>
</template>


<script setup>

import {ref, onMounted, onBeforeMount} from 'vue' 
import myAPI from '../services/services.js'
// import CardInfo from '../components/CardInfo.vue'
import L from 'leaflet'


const props = defineProps(['eventId'])

const info = ref({});

const coords = ref([]);
// const map = ref(null);

onBeforeMount(async() => {
  myAPI.getSingleEvent( props.eventId ).then( (response) => {
    console.log(response.data)
    info.value = response.data; 
    return response.data
  })
  .then(data => {
    // coords.value.push([data.acf.coordenadas.latitud, data.acf.coordenadas.longitud, data.title]);
  })
})

onMounted(() => {
  
  const lat = info.value.acf.coordenadas.latitud;
  const lon = info.value.acf.coordenadas.longitud;

  map.value = L.map('map').setView([lat,lon], 15);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map.value);

    new L.marker([lat, lon])
      .bindPopup(info.value.title.rendered)
      .addTo(map.value);

})

</script>

<style>
@import "https://unpkg.com/leaflet/dist/leaflet.css";
.new {
  display: grid;
}
</style>
