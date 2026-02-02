<script setup>
import { RouterLink, RouterView, useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const auth = useAuthStore();

const handleLogout = () => {
  auth.logout();
  router.push("/connexion");
};
</script>

<template>
  <div>
    <div class="logo">
      <img src="@/assets/logo.png" alt="Logo Arabia" />
    </div>

    <nav class="navigation">
      <!-- ✅ Liens visibles seulement si connecté -->
      <template v-if="auth.isAuthenticated">
        <RouterLink to="/accueil">Accueil</RouterLink>
        <RouterLink to="/favoris">Favoris</RouterLink>
        <RouterLink to="/catalogue">Catalogue</RouterLink>

        <button class="nav-btn" type="button" @click="handleLogout">
          Déconnexion
        </button>
      </template>

      <!-- ✅ Si pas connecté -->
      <template v-else>
        <RouterLink to="/connexion">Se connecter</RouterLink>
      </template>
    </nav>

    <RouterView />
  </div>

  <footer class="logo_footer">
    <img src="@/assets/logo.png" alt="Logo Arabia" />
  </footer>
</template>

<style scoped>
.logo_footer {
  display: grid;
  place-items: end;
  margin-top: -79px;
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

/* ✅ Bouton déconnexion stylé comme un lien */
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
