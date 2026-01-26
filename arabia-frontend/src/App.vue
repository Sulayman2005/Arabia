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
      <RouterLink to="/produit">Produit</RouterLink>
      <RouterLink to="/connexion">Se connecter</RouterLink>
    </nav>
    <div class="separator">
      <img src="@/assets/separator.png" alt="Séparateur" /> 
    </div>
    <RouterView />
  </div>
</template>

<style scoped>

  .separator {
    display: grid;
    place-items: end;
    margin-top: -40px;
    margin-bottom: 20px;
  }

  .navigation {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 100px;
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