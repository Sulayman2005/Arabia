import { createRouter, createWebHistory } from "vue-router";

import HomeView from "@/views/HomeView.vue";
import ProduitsView from "@/views/produit/ProduitsView.vue";
import CatalogueView from "@/views/CatalogueView.vue";
import FavorisView from "@/views/FavorisView.vue";
import ConnexionView from "@/views/ConnexionView.vue";

import MuscRoyal from "@/views/produit/MuscroyalView.vue";
import AmberTears from "@/views/produit/AmbertearsView.vue";
import BlackSaffron from "@/views/produit/BlacksaffronView.vue";
import DesertVanille from "@/views/produit/DesertvanilleView.vue";
import ImperialOud from "@/views/produit/ImperialoudView.vue";
import RoseDivine from "@/views/produit/RosedivineView.vue";

const routes = [
  { path: "/connexion", name: "connexion", component: ConnexionView },

  { path: "/", name: "home", component: HomeView, meta: { requiresAuth: true } },
  { path: "/favoris", name: "favoris", component: FavorisView, meta: { requiresAuth: true } },
  { path: "/catalogue", name: "catalogue", component: CatalogueView, meta: { requiresAuth: true } },
  { path: "/produit", name: "produit", component: ProduitsView, meta: { requiresAuth: true } },

  { path: "/produit/musc-royal", component: MuscRoyal, meta: { requiresAuth: true } },
  { path: "/produit/amber-tears", component: AmberTears, meta: { requiresAuth: true } },
  { path: "/produit/black-saffron", component: BlackSaffron, meta: { requiresAuth: true } },
  { path: "/produit/desert-vanille", component: DesertVanille, meta: { requiresAuth: true } },
  { path: "/produit/imperial-oud", component: ImperialOud, meta: { requiresAuth: true } },
  { path: "/produit/rose-divine", component: RoseDivine, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

/* 🔐 GUARD D’AUTHENTIFICATION */
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem("isAuthenticated");

  if (to.meta.requiresAuth && !isAuthenticated) {
    next("/connexion");
  } else {
    next();
  }
});

export default router;
