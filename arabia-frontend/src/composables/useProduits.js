import { ref } from "vue";
import api from "@/api/axios";

export function useProduits() {

  const produits = ref([]);
  const loading = ref(false);
  const error = ref("");

  const getProduits = async () => {
    loading.value = true;
    error.value = "";

    try {
      const res = await api.get("/produits");
      console.log(res.data);

      // API Platform => liste dans hydra:member
      const items = res.data?.member;

      if (!Array.isArray(items)) {
        throw new Error("Format API inattendu (hydra:member introuvable)");
      }

      produits.value = items;
    } catch (e) {
      error.value =
        e?.response?.data?.message ||
        e?.message ||
        "Erreur lors du chargement des produits";
      produits.value = [];
    } finally {
      loading.value = false;
    }
  };

  return { produits, loading, error, getProduits };
}
