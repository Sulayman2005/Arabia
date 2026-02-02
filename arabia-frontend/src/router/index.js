import { createRouter, createWebHistory } from "vue-router";

import HomeView from "@/views/HomeView.vue";
import CatalogueView from "@/views/CatalogueView.vue";
import FavorisView from "@/views/FavorisView.vue";
import ConnexionView from "@/views/ConnexionView.vue";
import ProduitView from "@/views/ProduitView.vue";

const routes = [
  { path: "/", redirect: "/connexion" },

  { path: "/connexion", name: "connexion", component: ConnexionView },

  { path: "/accueil", name: "accueil", component: HomeView, meta: { requiresAuth: true } },
  { path: "/favoris", name: "favoris", component: FavorisView, meta: { requiresAuth: true } },
  { path: "/catalogue", name: "catalogue", component: CatalogueView, meta: { requiresAuth: true } },
  { path: "/produits/:id", name: "produit", component: ProduitView ,props: true, },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem("token");


  if (to.meta.requiresAuth && !isAuthenticated) {
    next("/connexion");
  }
  else {
    next();
  }
});

export default router;
