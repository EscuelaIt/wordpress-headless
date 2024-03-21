<template>
  <form @submit.prevent="submitLoginForm">
    <label for="username">Usuari:</label><br>
    <input type="text" v-model="username" required><br>
    <label for="password">Contrasenya:</label><br>
    <input type="password" v-model="password" required><br><br>
    <button type="submit">Login</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useSessionStore } from '@/stores/session.js';
import { useGlobalStore } from '@/stores/global.js';

const globalStore = useGlobalStore();
const sessionStore = useSessionStore();
const router = useRouter();
const username = ref('');
const password = ref('');

const submitLoginForm = async () => {
  try {
    const response = await axios.post(`${globalStore.apiUrl}/jwt-auth/v1/token`, {
      username: username.value,
      password: password.value
    });

    if (response.status === 200) {
      window.sessionStorage.setItem('eit-token', response.data.token);
      // sessionStore.setAuthenticated(true);
      router.push({ path: '/form' }); // Redirige a la página deseada después de iniciar sesión
    } else {
      throw new Error('Credenciales incorrectas. Por favor, inténtalo de nuevo.');
    }
  } catch (error) {
    console.error('Error:', error);
  }
};
</script>
