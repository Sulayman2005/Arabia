import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import ProduitsView from "@/views/ProduitsView.vue";

const routes = [
  { path: "/", name: "home", component: HomeView },
  { path: "/produits", name: "produits", component: ProduitsView },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
