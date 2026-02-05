<style setup>
</style>

<template>
  <div class="not-found">
    <h1>404 - Page non trouvée</h1>
    <p>Désolé, la page que vous recherchez n'existe pas.</p>
    <router-link to="/">Retour à l'accueil</router-link>
  </div>
</template>

<style scoped>
.not-found {
  text-align: center;
  margin-top: 50px;
}
.not-found h1 {
  font-size: 2em;
  margin-bottom: 20px;
}
.not-found p {
  font-size: 1.2em;
  margin-bottom: 30px;
}
.not-found a {
  color: #42b983;
  text-decoration: none;
  font-weight: bold;
}
.not-found a:hover {
  text-decoration: underline;
}
</style>
