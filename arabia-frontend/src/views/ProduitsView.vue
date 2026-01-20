<script setup>
import { ref, onMounted } from "vue";
import api from "@/api/axios";

const produits = ref([]);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const response = await api.get("/produits");
    produits.value = response.data["hydra:member"];
  } catch (e) {
    error.value = e?.message ?? "Erreur inconnue";
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div>
    <h1>Produits</h1>

    <p v-if="loading">Chargement...</p>
    <p v-else-if="error">Erreur : {{ error }}</p>

    <ul v-else>
      <li v-for="p in produits" :key="p.id">
        {{ p.nom }} — {{ p.prix }} €
      </li>
    </ul>
  </div>
</template>
<style scoped></style>
