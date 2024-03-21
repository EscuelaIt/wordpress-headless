import { defineStore } from 'pinia';

export const useGlobalStore = defineStore({
  id: 'global',
  state: () => ({
    // apiUrl: 'http://eitagenda.local/wp-json'
    apiUrl: 'https://agenda.nemesisweb.dev/wp-json'
  }),
  actions: {
    setApiUrl(url) {
      this.apiUrl = url;
    }
  }
});