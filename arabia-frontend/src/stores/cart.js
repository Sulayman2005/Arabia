import { defineStore } from "pinia";

export const useCartStore = defineStore("cart", {
  state: () => ({
    items: [], // lignes panier
  }),

  getters: {
    count: (state) => state.items.reduce((sum, i) => sum + i.qty, 0),
    total: (state) => state.items.reduce((sum, i) => sum + i.prix * i.qty, 0),
  },

  actions: {
    addItem(payload) {
      // même produit + mêmes options = même ligne
      const key = `${payload.id}_${payload.contenance}_${payload.applicateur}`;
      const existing = this.items.find((i) => i.key === key);

      if (existing) {
        existing.qty += payload.qty;
      } else {
        this.items.push({ ...payload, key });
      }
    },

    removeItem(key) {
      this.items = this.items.filter((i) => i.key !== key);
    },

    clear() {
      this.items = [];
    },
  },
});
