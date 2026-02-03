<script setup>
import { useFavorisStore } from "@/stores/favoris";

const favorisStore = useFavorisStore();

const imgSrc = (image) => {
  return new URL(`../assets/${image}`, import.meta.url).href;
};


</script>

<template>
  <div class="favoris">
    <h1>Nos Favoris</h1>
    
    <p v-if="favorisStore.favoris.length === 0">
      Aucun favori pour le moment
    </p>

    <div v-else class="container_favoris">
      <div v-for="product in favorisStore.favoris" :key="product.id">
        <img :src="imgSrc(product.image)" :alt="product.nom" width="150px" />
        <button @click="favorisStore.removeFavori(product.id)" class="add_favoris">Retirer des favoris</button>
      </div>
    </div>

  </div>
</template>

<style scoped>
.favoris {
  display: grid;
  place-items: center;
  flex-direction: column;
  margin-top: 120px;
}

.container_favoris {
  max-width: 1100px;
  display: grid;
  place-items: center;
  margin: 50px auto;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 28px;
}

.add_favoris {
  display: flex;
  gap: 2em;
}
</style>