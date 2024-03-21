<!-- <template>
  <article class="evento-card" :tipo="tipo">
    <h2 class="evento-title">{{ title }}</h2>
    <div class="info">
      <div class="evento-location">{{ localidad }}</div>
      <div class="evento-date">{{ fecha }}</div>
    </div>
  </article>
</template> -->

<template>
  <article class="evento-card" :tipo="evento.tipo">
    <h2 class="evento-title">{{ evento.title.rendered }}</h2>
    <div class="info">
      <div class="evento-location">{{ evento.acf.localidad }}</div>
      <div class="evento-date">{{ evento.acf.fecha }}</div>
    </div>
  </article>
</template>


<script setup>
// import { defineProps } from 'vue'; // no necesario con script setup

import { onMounted } from "vue";

// const { title, localidad, fecha, tipo } = defineProps(['title', 'localidad', 'fecha', 'tipo']);

const props = defineProps({
  evento: {
    type: Object,
    required: true
  }
});

// onMounted(()=>{
// console.log(props.evento)
// })
</script>

<style scoped>
.evento-card {
  border: 2px solid hsla(160, 100%, 37%, 1);
  border-radius: 6px;
  padding: .5rem;
  cursor: pointer;
}
.evento-title {
  color: hsla(160, 100%, 37%, 1);
}
</style>