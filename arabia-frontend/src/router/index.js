import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import ProduitsView from "@/views/ProduitsView.vue";
import CatalogueView from "@/views/CatalogueView.vue";
import FavorisView from "@/views/FavorisView.vue";
import ConnexionView from "@/views/ConnexionView.vue";

const routes = [
  { path: "/", name: "home", component: HomeView },
  { path: "/favoris", name: "favoris", component: FavorisView },
  { path: "/catalogue", name: "catalogue", component: CatalogueView },
  { path: "/produit", name: "produit", component: ProduitsView },
  { path: "/connexion", name: "connexion", component: ConnexionView }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
