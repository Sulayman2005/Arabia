<script setup>
import { computed } from "vue";
import { useCartStore } from "@/stores/cart";

const cart = useCartStore();

const total = computed(() =>
  cart.items.reduce((sum, i) => sum + i.prix * i.qty, 0)
);

const imgSrc = (image) => {
  if (!image) return "";
  return new URL(`../assets/${image}`, import.meta.url).href;
};
</script>

<template>
  <main style="width:min(1000px,92vw); margin: 30px auto;">
    <h1>Mon panier</h1>

    <p v-if="cart.items.length === 0">Ton panier est vide.</p>

    <div v-else style="display:grid; gap:12px; margin-top:16px;">
      <div
        v-for="item in cart.items"
        :key="item.key"
        style="display:flex; gap:14px; align-items:center; padding:12px; border:1px solid #ddd; border-radius:12px;"
      >
        <img :src="imgSrc(item.image)" alt="" style="width:70px; height:70px; object-fit:cover; border-radius:10px;" />

        <div style="flex:1;">
          <strong>{{ item.nom }}</strong>
          <div style="opacity:.8; font-size:14px;">
            {{ item.contenance }} • {{ item.applicateur }}
          </div>
          <div style="opacity:.8; font-size:14px;">
            {{ item.prix }} € × {{ item.qty }} = <strong>{{ item.prix * item.qty }} €</strong>
          </div>
        </div>

        <button @click="cart.removeItem(item.key)" style="padding:8px 12px; border-radius:10px;">
          Supprimer
        </button>
      </div>

      <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
        <strong>Total : {{ total }} €</strong>
        <button @click="cart.clear()" style="padding:10px 14px; border-radius:10px;">
          Vider le panier
        </button>
      </div>
    </div>
  </main>
</template>
