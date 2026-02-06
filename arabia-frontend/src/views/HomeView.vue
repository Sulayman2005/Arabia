<script setup>
import { onMounted, ref, computed } from "vue";
import { useProduits } from "@/composables/useProduits";
import { RouterLink } from "vue-router";
import { useFavorisStore } from "@/stores/favoris";

const { produits, loading, error, getProduits } = useProduits();
const favorisStore = useFavorisStore();

const props = defineProps({
  product: Object
})

const search = ref("");

const produitsFiltres = computed(() => {
  const q = search.value.trim().toLowerCase();
  if (!q) return produits.value;
  return produits.value.filter((p) => p.nom?.toLowerCase().includes(q));
});

const imgSrc = (image) => {
  return new URL(`../assets/${image}`, import.meta.url).href;
};


onMounted(() => {
  getProduits();
});

</script>


<template>
  <div class="search-container">
    <input
      v-model="search"
      type="text"
      placeholder="Rechercher un parfum..."
      class="search-input"
    />
  </div>

  <main class="home">
    <section class="hero">
      <h1 class="title">Arabia</h1>

      
      <p class="texte">
        Arabia est une marque de cosmétique et de parfumerie inspirée par l'élégance et la sensualité du musc.
        Elle incarne l'essence des traditions orientales tout en proposant des créations modernes raffinées et minimaliste.
        Chaque produit est conçu pour offrir une expérience unique, mêlant douceur, intensité et authenticité.
        Arabia célèbre un art de vivre où le parfum devient une signature personnelle, subtile et inoubliable.
      </p>
    </section>
    
    <h2 class="subtitle">Liste de nos parfums</h2>

    <div class="erreur_load">
      <p v-if="loading" class="info">Chargement...</p>
      <p v-else-if="error" class="error">Erreur lors du chargement: {{ error }}</p>
    </div>
    
    <section v-if="!loading && !error && produitsFiltres.length" class="grid">
      <article v-for="p in produitsFiltres" :key="p.id" class="card">
        <RouterLink :to="`/produits/${p.id}`">
          <img class="img" :src="imgSrc(p.image)" :alt="p.nom" />
        </RouterLink>
        <div class="add_favoris">
          <button @click="favorisStore.addFavori(p)">Ajoutez aux favoris</button>
        </div>
      </article>
    </section>

    <p v-else-if="!loading && !error" class="no-results">
      Aucun parfum trouvé.
    </p>
  </main>
</template>



<style scoped>
.erreur_load {
  text-align: center;
  margin-bottom: 20px;
}

.search-container {
  margin-left: auto;
  margin-top: -40px;
  margin-bottom: 20px;
  background-color: #0f0f0f;
  border: 1px solid #c9a24d;
  border-radius: 30px;
  width: 220px;
  transition: box-shadow 0.3s ease, border-color 0.3s ease;
}

.search-container:focus-within {
  border-color: #e3c77a;
  box-shadow: 0 0 10px rgba(201, 162, 77, 0.4);
}

.search-input {
  width: 100%;
  background: transparent;
  border: none;
  outline: none;
  color: #f5f5f5;
  font-size: 14px;
  padding: 8px 10px;
  font-family: "Poppins", sans-serif;
}

.search-input::placeholder {
  color: #b5b5b5;
}

.no-results {
  text-align: center;
  opacity: 0.8;
  margin: 10px 0 20px;
}

.product-name {
  text-align: center;
  margin-top: 10px;
  font-size: 14px;
  letter-spacing: 0.3px;
}

/* .logo_footer {
  display: grid;
  place-items: end;
  margin-top: -59px;
} */


.hero {
  max-width: 900px;
  margin: 0 auto 70px;
  text-align: center;
}

.title {
  display: flex;
  margin: 0 30px 18px;
  font-size: 48px;
  font-weight: 600;
}

.texte {
  margin: 0 auto;
}

.subtitle {
  text-align: center;
  font-weight: 600;
  margin: -10px 0px 0px;
  letter-spacing: 0.4px;
}

.grid {
  max-width: 1500px;
  display: grid;
  place-items: center;
  margin: 0 auto;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 28px;
}

.card img {
  width: 150px;
  height: 180px;
  text-align: center;
  border-radius: 18px;
  cursor: pointer;
  transition: transform 0.2s;
}

.add_favoris button {
  display: flex;
}

@media (max-width: 900px) {
  .grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
  .title {
    font-size: 40px;
  }
}

@media (max-width: 600px) {
  .home {
    padding-top: 90px;
  }
  .grid {
    grid-template-columns: 1fr;
  }
  .title {
    font-size: 34px;
  }
}
</style>