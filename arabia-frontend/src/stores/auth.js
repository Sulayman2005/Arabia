import { defineStore } from "pinia";

function decodeJwt(token) {
  try {
    const payloadBase64 = token.split(".")[1];
    const payloadJson = atob(payloadBase64.replace(/-/g, "+").replace(/_/g, "/"));
    return JSON.parse(payloadJson);
  } catch (e) {
    return null;
  }
}

function isJwtExpired(token) {
  const decoded = decodeJwt(token);
  if (!decoded || !decoded.exp) return true; // si on ne peut pas lire exp => on considère invalide
  const nowInSeconds = Math.floor(Date.now() / 1000);
  return decoded.exp < nowInSeconds;
}

export const useAuthStore = defineStore("auth", {
  state: () => ({
    token: localStorage.getItem("token") || null,
    user: JSON.parse(localStorage.getItem("user") || "null"),
  }),

  getters: {
    isAuthenticated: (state) => !!state.token && !isJwtExpired(state.token),
  },

  actions: {
    setAuth(token, user = null) {
      this.token = token;
      this.user = user;

      localStorage.setItem("token", token);
      if (user) localStorage.setItem("user", JSON.stringify(user));
      else localStorage.removeItem("user");
    },

    logout() {
      this.token = null;
      this.user = null;
      localStorage.removeItem("token");
      localStorage.removeItem("user");
    },

    // Appelé au lancement / navigation pour vérifier si token est ok
    checkAuth() {
      if (!this.token) return false;
      if (isJwtExpired(this.token)) {
        this.logout();
        return false;
      }
      return true;
    },
  },
});
