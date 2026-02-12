<script setup>
import { RouterLink, RouterView, useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useCartStore } from "@/stores/cart";
import { ref } from "vue";

const cart = useCartStore();
const router = useRouter();
const auth = useAuthStore();

const isMenuOpen = ref(false);

const handleLogout = () => {
  auth.logout();
  isMenuOpen.value = false;
  router.push("/connexion");
};

const closeMenu = () => {
  isMenuOpen.value = false;
};
</script>

<template>
  <div class="layout">
    <!-- HEADER = logo + nav (desktop) / burger (mobile) -->
    <header class="header">
      <div class="logo">
        <RouterLink to="/accueil">
          <img src="@/assets/logo.png" alt="Logo Arabia" />
        </RouterLink>
      </div>

      <!-- Bouton burger (s’affiche quand ça "déborde") -->
      <button
        v-if="auth.isAuthenticated"
        class="burger"
        type="button"
        :aria-expanded="isMenuOpen ? 'true' : 'false'"
        aria-label="Ouvrir le menu"
        @click="isMenuOpen = !isMenuOpen"
      >
        <span></span><span></span><span></span>
      </button>

      <!-- NAV DESKTOP (inchangée) -->
      <nav class="navigation navigation--desktop">
        <template v-if="auth.isAuthenticated">
          <RouterLink to="/accueil">Accueil</RouterLink>
          <RouterLink to="/favoris">Favoris</RouterLink>
          <RouterLink to="/contact">Contact</RouterLink>
          <RouterLink to="/apropos">À propos</RouterLink>
          <RouterLink to="/faq">FAQ</RouterLink>

          <button class="nav-btn" type="button" @click="handleLogout">
            Déconnexion
          </button>

          <RouterLink to="/panier" class="cart-link">
            <img src="@/assets/panier.png" alt="ajout au panier" width="30" />
            <span v-if="cart.count > 0">({{ cart.count }})</span>
          </RouterLink>

          <div class="admin_section" v-if="auth.isAdmin">
            <button type="button" @click="router.push('/ajoutproduit')">
              Ajouter un produit
            </button>
          </div>
        </template>

        <template v-else>
          <RouterLink to="/connexion">Se connecter</RouterLink>
        </template>
      </nav>
    </header>

    <!-- OVERLAY + MENU BURGER (mobile) -->
    <div
      class="overlay"
      :class="{ open: isMenuOpen }"
      @click="closeMenu"
      aria-hidden="true"
    ></div>

    <nav class="navigation navigation--mobile" :class="{ open: isMenuOpen }">
      <template v-if="auth.isAuthenticated">
        <RouterLink to="/accueil" @click="closeMenu">Accueil</RouterLink>
        <RouterLink to="/favoris" @click="closeMenu">Favoris</RouterLink>
        <RouterLink to="/contact" @click="closeMenu">Contact</RouterLink>
        <RouterLink to="/apropos" @click="closeMenu">À propos</RouterLink>
        <RouterLink to="/faq" @click="closeMenu">FAQ</RouterLink>

        <RouterLink to="/panier" class="cart-link" @click="closeMenu">
          <img src="@/assets/panier.png" alt="ajout au panier" width="30" />
          <span v-if="cart.count > 0">({{ cart.count }})</span>
        </RouterLink>

        <div class="admin_section" v-if="auth.isAdmin">
          <button
            type="button"
            @click="router.push('/ajoutproduit'); closeMenu()"
          >
            Ajouter un produit
          </button>
        </div>

        <button class="nav-btn" type="button" @click="handleLogout">
          Déconnexion
        </button>
      </template>

      <template v-else>
        <RouterLink to="/connexion" @click="closeMenu">Se connecter</RouterLink>
      </template>
    </nav>

    <main class="page">
      <RouterView />
    </main>

    <footer class="logo_footer">
      <img src="@/assets/logo.png" alt="Logo Arabia" />
    </footer>
  </div>
</template>

<style scoped>
/* ======= ton design gardé ======= */
.admin_section {
  display: grid;
  place-content: center;
}

.layout {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.page {
  flex: 1;
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

/* ======= header wrapper ======= */
.header {
  position: relative;
}

/* Desktop nav EXACT (comme toi) */
.navigation--desktop {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 80px;
  border-bottom: 1px solid #c9a24d;
  list-style: none;
  margin-top: -40px;
  padding-bottom: 10px; /* petit confort */
}

/* logo pareil */
.logo img {
  display: block;
  max-width: 160px;
  height: auto;
}

/* ======= Burger + mobile ======= */
.burger {
  display: none; /* visible seulement au breakpoint */
  position: absolute;
  right: 16px;
  top: 18px;
  width: 44px;
  height: 44px;
  border: none;
  background: #c9a24d;
  cursor: pointer;
  padding: 10px;
}

.burger span {
  display: block;
  height: 2px;
  margin: 6px 0;
  background: #000;
  border-radius: 2px;
}

.cart-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

/* overlay pour fermer au clic */
.overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.35);
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.2s ease;
  z-index: 50;
}

.overlay.open {
  opacity: 1;
  pointer-events: auto;
}

/* menu mobile (dropdown sous le header) */
.navigation--mobile {
  display: none;
  position: fixed;
  left: 12px;
  right: 12px;
  top: 110px;              /* ajuste si ton logo/header est plus haut */
  z-index: 60;
  background: #fff;
  border: 1px solid #c9a24d;
  border-radius: 12px;
  padding: 14px;
  gap: 12px;
  transform: translateY(-8px);
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.navigation--mobile.open {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}

.navigation--mobile a,
.navigation--mobile .nav-btn,
.navigation--mobile .admin_section button {
  display: block;
  text-align: left;
}

/* ======= BREAKPOINT: quand ça commence à déborder =======
   Tu peux changer 1100px selon ton besoin */
@media (max-width: 1500px) {
  .navigation--desktop {
    display: none;
  }

  .burger {
    display: inline-block;
  }

  .navigation--mobile {
    display: grid;
  }

  /* évite le -40px sur mobile */
  .header {
    padding-bottom: 10px;
  }
}
</style>
