import axios from 'axios'


const base = 'https://agenda.nemesisweb.dev/wp-json/wp/v2';
// const base = 'http://eitagenda.local/wp-json/wp/v2';

const myAPI = axios.create({
  baseURL: base,
  withCredentials: false,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json'
  }
})

export default {
  getEventos() {
    return myAPI.get('/eventos');
  },

  getTipos() {
    return myAPI.get('/tipo');
  },

  getSingleEvent( id ) {
    return myAPI.get(`/eventos/${id}`);
  },

  createEvento(data, token) {
    return myAPI.post('/eventos', data, {
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`
      }
    });
  }
}