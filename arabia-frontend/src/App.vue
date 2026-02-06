<script setup>
import { RouterLink, RouterView, useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useCartStore } from "@/stores/cart";


const cart = useCartStore();
const router = useRouter();
const auth = useAuthStore();

const handleLogout = () => {
  auth.logout();
  router.push("/connexion");
};
</script>

<template>
  <div class="layout">
    <div class="logo">
      <img src="@/assets/logo.png" alt="Logo Arabia" />
    </div>

    <nav class="navigation">
      <template v-if="auth.isAuthenticated">
        <RouterLink to="/accueil">Accueil</RouterLink>
        <RouterLink to="/favoris">Favoris</RouterLink>
        <!-- <RouterLink to="/catalogue">Catalogue</RouterLink> -->
        <RouterLink to="/contact">Contact</RouterLink>
        <RouterLink to="/apropos">À propos</RouterLink>
        <RouterLink to="/faq">FAQ</RouterLink>

        <button class="nav-btn" type="button" @click="handleLogout">
          Déconnexion
        </button>
        <RouterLink to="/panier">
          <img src="@/assets/panier.png" alt="ajout au panier" width="30px">
          <span v-if="cart.count > 0">({{ cart.count }})</span>
        </RouterLink>
      </template>

      <template v-else>
        <RouterLink to="/connexion">Se connecter</RouterLink>
      </template>
    </nav>

    <!-- le contenu prend l'espace -->
    <main class="page">
      <RouterView />
    </main>

    <footer class="logo_footer">
      <img src="@/assets/logo.png" alt="Logo Arabia" />
    </footer>
  </div>
</template>


<style scoped>
.layout {
  min-height: 100vh;      
  display: flex;
  flex-direction: column; 
}

.page {
  flex: 1; /* pousse le footer en bas */
}

.logo_footer {
  margin-top: auto; 
  display: flex;
  justify-content: end;
}

.logo_footer img {
  display: block;
  max-width: 160px;
}

.navigation {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 130px;
  list-style: none;
  margin-top: -40px;
}

.navigation a {
  text-decoration: none;
}

.navigation a:hover {
  opacity: 0.7;
}

.navigation a.router-link-active {
  font-weight: bold;
}

.nav-btn {
  background: transparent;
  border: none;
  cursor: pointer;
  font: inherit;
  padding: 0;
}

.nav-btn:hover {
  opacity: 0.7;
}
</style>
