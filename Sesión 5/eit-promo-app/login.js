document.getElementById("loginForm").addEventListener("submit", function(event) {
  event.preventDefault(); // Evita l'enviament del formulari per defecte

  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;

  // axios.post('http://eitagenda.local/wp-json/jwt-auth/v1/token', {
  axios.post('https://agenda.nemesisweb.dev/wp-json/jwt-auth/v1/token', {
      username: username,
      password: password
  })
  .then(response => {
    console.log(response)
      if (response.status === 200) {
          // Si las credenciales son válidas, redirige a una página segura u otras acciones
          window.sessionStorage.setItem('eit-token', response.data.token)
          // window.location.href = 'pagina_secreta.html';
          window.location.href = 'form.html';
      } else {
          throw new Error('Credenciales incorrectas. Por favor, inténtalo de nuevo.');
      }
  })
  .catch(error => console.error('Error:', error));
});