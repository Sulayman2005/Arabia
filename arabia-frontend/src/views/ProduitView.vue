<script setup>
import { onMounted, ref, computed, watch } from "vue";
import { useProduits } from "@/composables/useProduits";
import { useRoute, useRouter } from "vue-router";
import { useCartStore } from "@/stores/cart";

const route = useRoute();
const router = useRouter();

const { produits, getProduits } = useProduits();
const cart = useCartStore();

const produit = ref(null);

// ✅ options
const contenance = ref("10 ml");
const applicateur = ref("Roll-on");

const qty = ref(1);
const maxQty = computed(() => produit.value?.stock ?? 1);

const clampQty = (v) => {
  const n = Number(v);
  if (!Number.isFinite(n)) return 1;
  return Math.min(Math.max(Math.trunc(n), 1), maxQty.value);
};

const decrement = () => (qty.value = clampQty(qty.value - 1));
const increment = () => (qty.value = clampQty(qty.value + 1));

watch(qty, (v) => (qty.value = clampQty(v)));

const imgSrc = (image) => {
  if (!image) return "";
  return new URL(`../assets/${image}`, import.meta.url).href;
};

onMounted(async () => {
  await getProduits();
  const id = Number(route.params.id);
  produit.value = produits.value.find((p) => p.id === id) || null;

  // reset
  qty.value = 1;
  contenance.value = "10 ml";
  applicateur.value = "Roll-on";
});

// ajout panier
const addToCart = () => {
  if (!produit.value) return;

  cart.addItem({
    id: produit.value.id,
    nom: produit.value.nom,
    image: produit.value.image,
    prix: produit.value.prix,
    contenance: contenance.value,
    applicateur: applicateur.value,
    qty: qty.value,
  });
};
</script>

<template>
  <main class="product-page">
    <section class="hero">
      <!-- MEDIA / GALLERY -->
      <div class="media">
        <!-- <div class="badge">Best-seller</div> -->

        <div class="main_card" v-if="produit">
            <img :src="imgSrc(produit.image)" :alt="produit.nom" class="main_img" />
        </div>


        <div class="thumbs" v-if="produit">
          <button class="thumb is-active" type="button">
            <img :src="imgSrc(produit.image)" alt="" />
          </button>
          <button class="thumb" type="button">
            <img :src="imgSrc(produit.image)" alt="" />
          </button>
          <button class="thumb" type="button">
            <img :src="imgSrc(produit.image)" alt="" />
          </button>
        </div>

        <div class="trustbar">
          <div class="trust">
            <span class="dot"></span>
            <p><strong>Livraison 48–72h</strong><br /><span>France & Europe</span></p>
          </div>
          <div class="trust">
            <span class="dot"></span>
            <p><strong>Paiement sécurisé</strong><br /><span>CB • PayPal</span></p>
          </div>
          <div class="trust">
            <span class="dot"></span>
            <p><strong>Retour facile</strong><br /><span>14 jours</span></p>
          </div>
        </div>
      </div>

      <div class="info">
        <div class="kicker">Arabia • Collection Musc</div>

        <h1 class="title">{{ produit?.nom }}</h1>

        <div class="meta">
          <div class="stars" aria-label="Note 4.8 sur 5">
            ★★★★★ <span class="stars-sub">4,8 (128)</span>
          </div>
          <span class="sep">•</span>
          <span class="tag">Extrait de parfum</span>
          <span class="sep">•</span>
          <span class="tag">Longue tenue</span>
        </div>

        <p class="subtitle">
          Un musc raffiné, doux et chaleureux — une signature élégante qui sublime la peau.
        </p>

        <div class="buybox">
          <div class="buy-top">
            <div class="price-wrap">
              <p class="price">{{ produit?.prix }} €</p>
              <p class="tax">Taxes incluses</p>
            </div>

            <div class="stock">
              <span class="pill pill-ok">{{ produit?.stock > 0 ? ` ${produit.stock} unités disponibles` : '' }}</span>
              <span class="pill pill-hot">Dernières pièces</span>
            </div>
          </div>

          <div class="options">
            <label class="field">
              <span class="label">Contenance</span>
              <select class="select" v-model="contenance">
                <option>10 ml</option>
                <option>6 ml</option>
                <option>3 ml</option>
              </select>
            </label>

            <label class="field">
              <span class="label">Applicateur</span>
              <select class="select" v-model="applicateur">
                <option>Roll-on</option>
                <option>Spray</option>
              </select>
            </label>

            <!-- <label class="field qty">
              <span class="label">Quantité</span>
              <div class="qty-ctrl" role="group" aria-label="Quantité">
                <button class="qty-btn" type="button" aria-label="Diminuer">−</button>
                <input class="qty-input" value="1" inputmode="numeric" />
                <button class="qty-btn" type="button" aria-label="Augmenter">+</button>
              </div>
            </label> -->
            <label class="field_qty">
              <span class="label">Quantité</span>
              <button class="qty-btn" type="button" aria-label="Diminuer" @click="decrement">−</button>
              <input class="qty-input" v-model.number="qty" inputmode="numeric" />
              <button class="qty-btn" type="button" aria-label="Augmenter" @click="increment">+</button>
            </label>

          </div>

          <div class="cta">
            <button class="btn btn-primary" @click="addToCart">Ajouter au panier</button>
            <!-- <button class="btn btn-ghost">Acheter maintenant</button> -->
          </div>

          <p class="micro">
            Conseil Arabia : appliquez sur les points de pulsation (poignets, cou) pour révéler toute la richesse du musc.
          </p>
        </div>

        <div class="chips" aria-label="Caractéristiques">
          <span class="chip">Musc blanc</span>
          <span class="chip">Accord ambré</span>
          <span class="chip">Boisé doux</span>
          <span class="chip">Sillage élégant</span>
        </div>
      </div>
    </section>

    <!-- DETAILS -->
    <section class="details">
      <div class="panel">
        <h2>Description</h2>
        <p>
          {{ produit?.description }}
        </p>
      </div>

      <div class="panel">
        <h2>Notes olfactives</h2>
        <ul class="notes">
          <li><span>Notes de tête</span><strong>Accords poudrés</strong></li>
          <li><span>Notes de cœur</span><strong>Musc blanc</strong></li>
          <li><span>Notes de fond</span><strong>Ambre • Bois doux</strong></li>
        </ul>
      </div>

      <div class="panel">
        <h2>Conseils d’application</h2>
        <p>
          Appliquez par touches sur le cou, derrière les oreilles et les poignets. Évitez de frotter :
          laissez le parfum se développer naturellement sur la peau.
        </p>
      </div>
    </section>

    <!-- RECO -->
    <section class="teaser">
    <div class="teaser-card">
        <p class="teaser-kicker">Arabia • Bientôt</p>
        <h3 class="teaser-title">Sorties plus tard… pour les curieux</h3>
        <p class="teaser-text">
        De nouvelles créations arrivent : muscs rares, notes ambrées, oud noble et accords gourmands.
        Inscris-toi pour être prévenu en avant-première.
        </p>

        <form class="teaser-form" @submit.prevent>
        <input class="teaser-input" type="email" placeholder="Ton email" />
        <button class="btn btn-primary" type="submit">Être prévenu</button>
        </form>

        <p class="teaser-micro">Zéro spam. Juste les nouveautés Arabia.</p>
    </div>
    </section>

  </main>
</template>

<style scoped>
/* ====== THEME ====== */
.product-page {
  --sand: #f5efe6;
  --sand-2: #efe3d2;
  --ink: #0c0c0c;
  --muted: #5f5a52;
  --black: #0e0e0e;
  --gold: #b08a3a;
  --gold-2: #8b6a2a;
  --line: rgba(176, 138, 58, 0.28);

  color: var(--ink);
  padding: 30px 0 80px;
  background:
    radial-gradient(1200px 600px at 20% 10%, rgba(176, 138, 58, 0.12), transparent 60%),
    radial-gradient(900px 500px at 80% 0%, rgba(14, 14, 14, 0.10), transparent 55%),
    linear-gradient(180deg, var(--sand), var(--sand-2));
}

/* petit grain subtil */
.product-page::before {
  content: "";
  position: fixed;
  inset: 0;
  pointer-events: none;
  opacity: 0.06;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='140' height='140'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='140' height='140' filter='url(%23n)' opacity='.35'/%3E%3C/svg%3E");
}

/* ====== LAYOUT ====== */
.hero {
  width: min(1120px, 92vw);
  margin: 0 auto;
  display: grid;
  grid-template-columns: 460px 1fr;
  gap: 56px;
  align-items: start;
}

@media (max-width: 980px) {
  .hero {
    grid-template-columns: 1fr;
    gap: 26px;
  }
}

.media {
  position: relative;
  display: grid;
  gap: 16px;
}

.badge {
  position: absolute;
  top: 14px;
  left: 14px;
  z-index: 2;
  padding: 8px 12px;
  border-radius: 999px;
  font-size: 12px;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  background: rgba(14, 14, 14, 0.86);
  color: #f1e5cf;
  border: 1px solid var(--line);
  backdrop-filter: blur(8px);
}

.main-card {
  position: relative;
  border-radius: 20px;
  width: 100%;
  background: var(--black);
  border: 1px solid rgba(0,0,0,0.18);
  box-shadow: 0 22px 50px rgba(0, 0, 0, 0.18);
}

.main-card::after {
  content: "";
  position: absolute;
  inset: 0;
  background: radial-gradient(600px 300px at 25% 20%, rgba(176, 138, 58, 0.22), transparent 60%);
  pointer-events: none;
}

.main-img {
  display: block;
  width: 100%;
  height: auto;
  transform: scale(1.01);
}

.main_img {
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 20px;
  margin-left: 110px;
  margin-top: 12px;
}

.thumbs {
  display: flex;
  margin-right: -12px;
  gap: 12px;
  justify-content: center;
}

.thumb {
  width: 74px;
  height: 74px;
  border-radius: 999px;
  border: 1px solid var(--line);
  background: rgba(14, 14, 14, 0.95);
  overflow: hidden;
  cursor: pointer;
  box-shadow: 0 12px 26px rgba(0, 0, 0, 0.12);
  transition: transform 0.12s ease, opacity 0.2s ease;
  opacity: 0.9;
}

.thumb:hover { transform: translateY(-1px); opacity: 1; }
.thumb.is-active { outline: 2px solid rgba(176, 138, 58, 0.45); }

.thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.trustbar {
  display: grid;
  margin-top: 14px;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
  padding: 14px;
  border-radius: 16px;
  border: 1px solid rgba(0,0,0,0.10);
  /* background: rgba(255, 255, 255, 0.55); */
  backdrop-filter: blur(10px);
}

@media (max-width: 520px) {
  .trustbar { grid-template-columns: 1fr; }
}

.trust {
  display: grid;
  place-items: center;
  grid-template-columns: 12px 1fr;
  gap: 10px;
  align-items: start;
}

.dot {
  width: 10px;
  height: 10px;
  border-radius: 999px;
  margin-top: 4px;
  background: var(--gold);
  box-shadow: 0 0 0 4px rgba(176, 138, 58, 0.18);
}

.trust p {
  margin: 0;
  line-height: 1.2;
  font-size: 12.5px;
  color: #1b1b1b;
}

.trust span { color: rgba(0,0,0,0.55); }

/* ====== INFO ====== */
.info {
  padding-top: 8px;
}

.kicker {
  font-size: 12px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: rgba(0,0,0,0.55);
  margin-bottom: 10px;
}

.title {
  margin: 0;
  font-size: 40px;
  letter-spacing: 0.02em;
}

@media (max-width: 520px) {
  .title { font-size: 32px; }
}

.meta {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 10px;
  margin: 10px 0 18px;
  color: rgba(0,0,0,0.65);
  font-size: 13px;
}

.stars { letter-spacing: 0.06em; }
.stars-sub { margin-left: 8px; letter-spacing: normal; opacity: 0.75; }
.sep { opacity: 0.35; }

.tag {
  padding: 6px 10px;
  border-radius: 999px;
  border: 1px solid rgba(0,0,0,0.10);
  background: rgba(255,255,255,0.55);
}

.subtitle {
  margin: 0 0 18px;
  color: rgba(0,0,0,0.72);
  max-width: 560px;
  line-height: 1.6;
}

/* ====== BUY BOX ====== */
.buybox {
  border-radius: 20px;
  padding: 18px;
  background: rgba(14, 14, 14, 0.92);
  color: #f3e7d1;
  border: 1px solid rgba(176, 138, 58, 0.22);
  box-shadow: 0 20px 44px rgba(0, 0, 0, 0.18);
  max-width: 560px;
}

.buy-top {
  display: flex;
  justify-content: space-between;
  align-items: start;
  gap: 12px;
  margin-bottom: 14px;
}

.price-wrap { display: grid; gap: 2px; }
.price {
  margin: 0;
  font-size: 26px;
  font-weight: 750;
  letter-spacing: 0.02em;
}
.tax { margin: 0; opacity: 0.72; font-size: 12px; }

.stock { display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end; }
.pill {
  padding: 6px 10px;
  border-radius: 999px;
  font-size: 12px;
  border: 1px solid rgba(176, 138, 58, 0.28);
  background: rgba(176, 138, 58, 0.10);
}
.pill-hot { border-color: rgba(255,255,255,0.16); background: rgba(255,255,255,0.06); }

.options {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

@media (max-width: 520px) {
  .options { grid-template-columns: 1fr; }
}

.field { 
  display: flex; 
  flex-direction: column; 
  gap: 6px; 
}
.field_qty { display: flex; gap: 6px; align-items: start; }
.label {
  font-size: 12px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: rgba(241, 229, 207, 0.78);
}

.select {
  height: 42px;
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.06);
  color: #f3e7d1;
  padding: 0 12px;
  outline: none;
}

.select option { color: #111; }

.qty-ctrl {
  display: grid;
  grid-template-columns: 42px 1fr 42px;
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.14);
  overflow: hidden;
  background: rgba(255,255,255,0.06);
}

.qty-btn {
  background: transparent;
  border: none;
  color: #f3e7d1;
  cursor: pointer;
  font-size: 18px;
  transition: background 0.2s ease;
}
.qty-btn:hover { background: rgba(255,255,255,0.08); }

.qty-input {
  background: transparent;
  border: none;
  color: #f3e7d1;
  text-align: center;
  outline: none;
}

.cta {
  margin-top: 14px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

@media (max-width: 520px) {
  .cta { grid-template-columns: 1fr; }
}

.btn {
  border-radius: 14px;
  padding: 12px 14px;
  font-weight: 700;
  cursor: pointer;
  border: 1px solid transparent;
  transition: transform 0.06s ease, opacity 0.2s ease, filter 0.2s ease;
}
.btn:active { transform: translateY(1px); }

.btn-primary {
  background: linear-gradient(180deg, rgba(176, 138, 58, 1), rgba(139, 106, 42, 1));
  color: #111;
}
.btn-primary:hover { filter: brightness(1.02); }

.btn-ghost {
  background: rgba(255,255,255,0.06);
  border-color: rgba(255,255,255,0.14);
  color: #f3e7d1;
}
.btn-ghost:hover { opacity: 0.95; }

.btn-outline {
  background: transparent;
  border-color: rgba(176, 138, 58, 0.55);
  color: #ead8b7;
}
.btn-sm { padding: 9px 12px; font-size: 13px; border-radius: 12px; }

.micro {
  margin: 12px 0 0;
  opacity: 0.78;
  line-height: 1.5;
  font-size: 12.5px;
}

.chips {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 16px;
}

.chip {
  padding: 8px 12px;
  border-radius: 999px;
  border: 1px solid rgba(0,0,0,0.12);
  background: rgba(255,255,255,0.55);
  color: rgba(0,0,0,0.72);
  font-size: 13px;
}

/* ====== DETAILS ====== */
.details {
  width: min(1120px, 92vw);
  margin: 28px auto 0;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}

@media (max-width: 980px) {
  .details { grid-template-columns: 1fr; }
}

.panel {
  border-radius: 18px;
  padding: 18px;
  background: rgba(255,255,255,0.62);
  border: 1px solid rgba(0,0,0,0.10);
  box-shadow: 0 18px 40px rgba(0,0,0,0.08);
}

.panel h2 {
  margin: 0 0 10px;
  letter-spacing: 0.04em;
}

.panel p { margin: 0; color: rgba(0,0,0,0.72); line-height: 1.6; }

.notes {
  list-style: none;
  padding: 0;
  margin: 0;
  display: grid;
  gap: 10px;
}

.notes li {
  display: flex;
  justify-content: space-between;
  gap: 10px;
  padding: 10px 12px;
  border-radius: 14px;
  background: rgba(14,14,14,0.06);
  border: 1px solid rgba(0,0,0,0.08);
}
.notes span { color: rgba(0,0,0,0.62); }
.notes strong { color: rgba(0,0,0,0.84); }

/* ====== RECO ====== */
.recommended {
  width: min(1120px, 92vw);
  margin: 34px auto 0;
}

.reco-head {
  text-align: center;
  margin-bottom: 16px;
}

.reco-head h3 {
  margin: 0;
  letter-spacing: 0.04em;
}

.reco-head p {
  margin: 6px 0 0;
  color: rgba(0,0,0,0.65);
}

.reco-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}

@media (max-width: 980px) {
  .reco-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 520px) {
  .reco-grid { grid-template-columns: 1fr; }
}

.reco-card {
  display: grid;
  justify-items: center;
  gap: 8px;
  padding: 16px;
  border-radius: 18px;
  background: rgba(14,14,14,0.90);
  border: 1px solid rgba(176, 138, 58, 0.20);
  box-shadow: 0 18px 40px rgba(0,0,0,0.16);
  color: #f3e7d1;
}

.reco-img {
  width: 100%;
  height: 150px;
  border-radius: 14px;
  background: radial-gradient(220px 120px at 30% 20%, rgba(176, 138, 58, 0.35), transparent 60%),
              linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02));
  border: 1px solid rgba(255,255,255,0.10);
}

.reco-name {
  margin: 8px 0 0;
  font-weight: 800;
  letter-spacing: 0.10em;
  text-transform: uppercase;
  font-size: 12px;
}

.reco-price {
  margin: 0;
  opacity: 0.82;
  font-size: 13px;
}
.teaser {
  width: min(1120px, 92vw);
  margin: 34px auto 0;
}

.teaser-card {
  border-radius: 20px;
  padding: 22px;
  background: rgba(14, 14, 14, 0.92);
  color: #f3e7d1;
  border: 1px solid rgba(176, 138, 58, 0.22);
  box-shadow: 0 20px 44px rgba(0, 0, 0, 0.18);
  text-align: center;
}

.teaser-kicker {
  margin: 0 0 8px;
  font-size: 12px;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  opacity: 0.78;
}

.teaser-title {
  margin: 0;
  letter-spacing: 0.04em;
}

.teaser-text {
  margin: 10px auto 0;
  max-width: 720px;
  line-height: 1.6;
  opacity: 0.88;
}

.teaser-form {
  margin: 16px auto 0;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 10px;
  max-width: 520px;
}

@media (max-width: 520px) {
  .teaser-form {
    grid-template-columns: 1fr;
  }
}

.teaser-input {
  height: 44px;
  border-radius: 14px;
  border: 1px solid rgba(255, 255, 255, 0.14);
  background: rgba(255, 255, 255, 0.06);
  color: #f3e7d1;
  padding: 0 14px;
  outline: none;
}

.teaser-input::placeholder {
  color: rgba(243, 231, 209, 0.6);
}

.teaser-micro {
  margin: 10px 0 0;
  font-size: 12.5px;
  opacity: 0.72;
}

</style>