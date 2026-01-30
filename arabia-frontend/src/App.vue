<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <div>
    <div class="logo">
        <img src="@/assets/logo.png" alt="Logo Arabia" />
    </div>
    <nav class="navigation">
      <RouterLink to="/">Accueil</RouterLink>
      <RouterLink to="/favoris">Favoris</RouterLink>
      <RouterLink to="/catalogue">Catalogue</RouterLink>
      <RouterLink to="/connexion">Se connecter</RouterLink>
    </nav>
    <RouterView />
  </div>
  <footer class="logo_footer">
    <img src="@/assets/logo.png" alt="Logo Arabia" />
  </footer>
</template>

<style scoped>
  .logo_footer {
    display: grid;
    place-items: end;
    margin-top: -79px;
  }

  .navigation {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 130px;
    list-style: none;
    margin-top: -40px;
  }

  .navigation a {
    text-decoration: none;
  }

  .navigation a:hover {
    opacity: 0.7;
  }

  .navigation a.router-link-active {
    font-weight: bold;
  }
  
</style>