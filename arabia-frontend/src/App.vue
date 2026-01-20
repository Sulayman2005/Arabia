<template>
  <div>
    <nav>
      <RouterLink to="/">Accueil</RouterLink>
      <RouterLink to="/produits">Produits</RouterLink>
    </nav>

    <RouterView />
  </div>
</template>

<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>
