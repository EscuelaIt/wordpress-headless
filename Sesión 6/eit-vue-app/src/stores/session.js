import { defineStore } from 'pinia';

export const useSessionStore = defineStore({
  id: 'session',
  state: () => ({
    isAuthenticated: !!window.sessionStorage.getItem('eit-token')
  }),
  actions: {
    setAuthenticated(value) {
      this.isAuthenticated = value;
    },
    logout() {
      window.sessionStorage.removeItem('eit-token');
      this.isAuthenticated = false;
    }
  }
});