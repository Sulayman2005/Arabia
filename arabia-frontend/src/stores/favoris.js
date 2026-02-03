import { defineStore} from 'pinia';

export const useFavorisStore = defineStore('favoris', {
  state: () => ({
    favoris: JSON.parse(localStorage.getItem('favoris') || '[]'),
  }),
    actions: {
    addFavori(produit) {
      if (!this.favoris.find(p => p.id === produit.id)) {
        this.favoris.push(produit);
        localStorage.setItem('favoris', JSON.stringify(this.favoris));
      }
    },
    removeFavori(produitId) {
      this.favoris = this.favoris.filter(p => p.id !== produitId);
      localStorage.setItem('favoris', JSON.stringify(this.favoris));
    },
    isFavori(produitId) {
      return this.favoris.some(p => p.id === produitId);
    }
    },
});

