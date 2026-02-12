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
  if (!decoded || !decoded.exp) return true;
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
    isAdmin: (state) => state.user?.roles?.includes("ROLE_ADMIN") ?? false,
  },

  actions: {
    setAuth(token, user = null) {
      const decoded = decodeJwt(token);

      const finalUser = user ?? {
        email: decoded?.username || decoded?.email || null,
        roles: decoded?.roles || [],
      };

      this.token = token;
      this.user = finalUser;

      localStorage.setItem("token", token);
      localStorage.setItem("user", JSON.stringify(finalUser));
    },

    logout() {
      this.token = null;
      this.user = null;
      localStorage.removeItem("token");
      localStorage.removeItem("user");
    },

    checkAuth() {
      if (!this.token) return false;

      if (isJwtExpired(this.token)) {
        this.logout();
        return false;
      }

      if (!this.user) {
        const decoded = decodeJwt(this.token);
        this.user = {
          email: decoded?.username || decoded?.email || null,
          roles: decoded?.roles || [],
        };
        localStorage.setItem("user", JSON.stringify(this.user));
      }

      return true;
    },
  },
});
