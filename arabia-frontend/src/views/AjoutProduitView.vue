<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import api from "@/api/axios";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const auth = useAuthStore();

const loading = ref(false);
const error = ref("");
const success = ref("");

const categories = ref([]);

const form = ref({
  nom: "",
  prix: "",
  image: "",
  description: "",
  dateAjout: "",
  stock: "",
  categorie: "",
});

const getCategorie = async () => {
  try {
    const res = await api.get("/categories");
    categories.value = res.data["hydra:member"] ?? res.data.member ?? res.data ?? [];
    console.log("categories final:", categories.value);
  } catch (e) {
    console.log("GET /categories FAILED:", e.response?.status, e.response?.data);
    categories.value = [];
  }
};


const submit = async () => {
  error.value = "";
  success.value = "";

  if (!form.value.nom.trim() || !form.value.prix) {
    error.value = "Nom et prix obligatoires.";
    return;
  }

  if (!form.value.categorie) {
    error.value = "Veuillez sélectionner une catégorie.";
    return;
  }


  loading.value = true;

  try {
    await api.post("/produits", {
      nom: form.value.nom.trim(),
      prix: String(form.value.prix),
      image: form.value.image.trim(),
      description: form.value.description.trim(),
      dateAjout: new Date().toISOString(),
      stock: form.value.stock ? Number(form.value.stock) : 0,
      categorie: form.value.categorie,
    });

    success.value = "Produit ajouté avec succès !";

    // Redirect vers HomeView après un court délai pour montrer le message de succès
    setTimeout(() => {
      router.push("/accueil");
    }, 1500);
  } catch (e) {
    console.log("API ERROR", e.response?.data);
    error.value =
    e.response?.data?.["hydra:description"] ||
    e.response?.data?.detail ||
    "Erreur lors de l'ajout.";
  } finally {
    loading.value = false;
  }
};

onMounted(async () => {
  if (!auth.isAuthenticated || !auth.isAdmin) {
    router.push("/accueil");
    return;
  }
  await getCategorie(); // on charge les catégories au chargement
});

</script>

<template>
  <main class="block">
    <section v-if="auth.isAdmin" class="card">
      <h2>Ajouter un produit</h2>

      <p v-if="error" style="color:red">{{ error }}</p>
      <p v-if="success" style="color:green">{{ success }}</p>

      <form @submit.prevent="submit" style="display:grid; gap:10px; max-width: 420px;">
        <input v-model="form.nom" placeholder="Nom du produit" />
        <input v-model="form.prix" type="text" placeholder="Prix" />
        <input v-model="form.image" placeholder="Image (ex: musc.png ou URL)" />
        <textarea v-model="form.description" placeholder="Description"></textarea>
        <input v-model="form.dateAjout" type="date" placeholder="Date d'ajout (optionnel)" />
        <input v-model="form.stock" type="number" placeholder="Stock (optionnel)" />
        <select v-model="form.categorie">
          <option value="">Sélectionner une catégorie</option>

          <option v-for="cat in categories" :key="cat.id" :value="cat['@id']">
            {{ cat.nom }}
          </option>
        </select>

        <button type="submit" :disabled="loading">
          {{ loading ? "Ajout..." : "Ajouter" }}
        </button>
      </form>
    </section>
  </main>
</template>

<style scoped>
.block {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 60px 16px;
}
.card {
  width: 100%;
  max-width: 520px;
  padding: 20px;
  border: 1px solid #c9a24d;
  border-radius: 16px;
}
input, textarea {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}
button {
  padding: 10px;
  background-color: #c9a24d;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}
button:disabled {
  background-color: #999;
  cursor: not-allowed;
}
</style>
