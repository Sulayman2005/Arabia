import { createRouter, createWebHistory } from "vue-router";

import HomeView from "@/views/HomeView.vue";
import CatalogueView from "@/views/CatalogueView.vue";
import FavorisView from "@/views/FavorisView.vue";
import ConnexionView from "@/views/ConnexionView.vue";
import ProduitView from "@/views/ProduitView.vue";
import ProfilView from "@/views/ProfilView.vue";
import ContactView from "@/views/ContactView.vue";
import AproposView from "@/views/AproposView.vue";
import FaqView from "@/views/FaqView.vue";
import NotFoundView from "@/views/NotFoundView.vue";
import PanierView from "@/views/PanierView.vue";
import AjoutProduitView from "@/views/AjoutProduitView.vue";

const routes = [
  { path: "/", redirect: "/connexion" },

  { path: "/connexion", name: "connexion", component: ConnexionView },

  { path: "/accueil", name: "accueil", component: HomeView, meta: { requiresAuth: true } },
  { path: "/favoris", name: "favoris", component: FavorisView, meta: { requiresAuth: true } },
  { path: "/catalogue", name: "catalogue", component: CatalogueView, meta: { requiresAuth: true } },
  { path: "/produits/:id", name: "produit", component: ProduitView ,props: true, },
  { path: "/profil", name: "profil", component: ProfilView, meta: { requiresAuth: true } },
  { path: "/contact", name: "contact", component: ContactView, meta: { requiresAuth: true } },
  { path: "/apropos", name: "apropos", component: AproposView, meta: { requiresAuth: true } },
  { path: "/faq", name: "faq", component: FaqView, meta: { requiresAuth: true } },
  {path: "/panier", name: "panier", component: PanierView, meta: { requiresAuth: true } },
  // {path: "/ajoutproduit/:id", name: "ajoutproduit", component: AjoutProduitView, props: true, meta: { requiresAuth: true } },
  {path: "/ajoutproduit", name: "ajoutproduit", component: AjoutProduitView, meta: { requiresAuth: true } },

  {path: "/:pathMatch(.*)*", name: "NotFound", component: NotFoundView },

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
