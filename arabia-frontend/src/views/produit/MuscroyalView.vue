<template>
  <main class="product-page">
    <section class="hero">
      <div class="media">
        <div class="main-card">
          <img
            class="main-img"
            src="@/assets/musc_royal_prix.jpg"
            alt="Musc Royal"
            title="parfum musc royal"
          />
          <div class="overlay">
            <p class="overlay-price">19,99 €</p>
            <button class="btn btn-outline">Voir le produit</button>
          </div>
        </div>

        <div class="thumbs">
          <button class="thumb" type="button" aria-label="Photo 1">
            <img src="@/assets/musc_royal.PNG" alt="musc royal" />
          </button>
          <button class="thumb" type="button" aria-label="Photo 2">
            <img src="@/assets/musc_royal.PNG" alt="musc royal" />
          </button>
        </div>
      </div>

      <div class="info">
        <h1 class="title">MUSC ROYAL</h1>
        <p class="price">19,99 €</p>

        <p class="subtitle">
          Un Parfum De Musc Raffiné, À La Fois Riche Et Envoutant
        </p>

        <div class="options">
          <label class="field">
            <span class="label">Contenance</span>
            <select class="select">
              <option>10 ml</option>
              <option>6 ml</option>
              <option>3 ml</option>
            </select>
          </label>

          <label class="field">
            <span class="label">Applicateur</span>
            <select class="select">
              <option>Roll-on</option>
              <option>Spray</option>
            </select>
          </label>
        </div>

        <button class="btn btn-primary">Ajouter au panier</button>

        <p class="short-desc">
          Un Parfum De Musc Raffiné, À La Fois Riche Et Envoutant
        </p>
      </div>
    </section>

    <section class="desc-bar" aria-label="Description">
      <div class="desc-inner">
        <h2 class="desc-title">Description</h2>
        <p class="desc-text">
          Musc Royal est un parfum de caractère révélant la sensualité du musc.
          Ses notes chaudes et basses créent une signature olfactive.
        </p>
      </div>
    </section>

    <section class="recommended">
      <p class="reco-title">Produits Recommandés</p>

      <div class="reco-grid">
        <article class="card">
          <img class="card-img" src="@/assets/Muscnoir.PNG" alt="Musc Noir" />
          <p class="card-name">MUSC NOIR</p>
          <p class="card-price">19,33 €</p>
          <button class="btn btn-outline btn-sm">Voir le produit</button>
        </article>

        <article class="card">
          <img class="card-img" src="@/assets/Muscsantal.PNG" alt="Musc Santal" />
          <p class="card-name">MUSC SANTAL</p>
          <p class="card-price">18,23 €</p>
          <button class="btn btn-outline btn-sm">Voir le produit</button>
        </article>

        <article class="card">
          <img class="card-img" src="@/assets/Muscintense.PNG" alt="Musc Intense" />
          <p class="card-name">MUSC INTENSE</p>
          <p class="card-price">19,23 €</p>
          <button class="btn btn-outline btn-sm">Voir le produit</button>
        </article>

        <article class="card">
          <img class="card-img" src="@/assets/Muscoud.PNG" alt="Musc Oud" />
          <p class="card-name">MUSC-OUD</p>
          <p class="card-price">19,53 €</p>
          <button class="btn btn-outline btn-sm">Voir le produit</button>
        </article>
      </div>
    </section>
  </main>
</template>

<style scoped>
.product-page {
  --bg: #f4efe6;
  --ink: #111;
  --muted: #5b5b5b;
  --panel: #0e0e0e;
  --gold: #b08a3a;
  --gold-2: #8b6a2a;
  --line: #d8c8a6;

  background: var(--bg);
  color: var(--ink);
  padding: 28px 0 60px;
}

.hero {
  width: min(1100px, 92vw);
  margin: 0 auto;
  display: grid;
  grid-template-columns: 420px 1fr;
  gap: 54px;
  align-items: start;
}

@media (max-width: 920px) {
  .hero {
    grid-template-columns: 1fr;
    gap: 24px;
  }
}


.media {
  display: grid;
  gap: 16px;
}

.main-card {
  position: relative;
  border-radius: 10px;
  overflow: hidden;
  background: #141414;
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
}

.main-img {
  display: block;
  width: 100%;
  height: auto;
}

.overlay {
  position: absolute;
  left: 18px;
  right: 18px;
  bottom: 18px;
  display: grid;
  gap: 10px;
  justify-items: center;
  text-align: center;
}

.overlay-title {
  margin: 0;
  letter-spacing: 0.12em;
  font-size: 14px;
  color: #ead8b7;
  text-transform: uppercase;
}

.overlay-price {
  margin: 0;
  font-weight: 600;
  color: #ead8b7;
  opacity: 0.95;
}

.thumbs {
  display: flex;
  gap: 14px;
  justify-content: center;
}

.thumb {
  width: 108px;
  height: 108px;
  border-radius: 999px;
  border: 1px solid rgba(176, 138, 58, 0.35);
  background: #141414;
  overflow: hidden;
  cursor: pointer;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
}

.thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.info {
  padding-top: 10px;
}

.title {
  margin: 0;
  font-size: 34px;
  letter-spacing: 0.02em;
}

.price {
  margin: 10px 0 18px;
  font-size: 20px;
  color: #2b2b2b;
}

.subtitle {
  margin: 0 0 18px;
  color: #2f2f2f;
  max-width: 520px;
  line-height: 1.5;
}

.options {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  margin-bottom: 18px;
  max-width: 420px;
}

@media (max-width: 520px) {
  .options {
    grid-template-columns: 1fr;
  }
}

.field {
  display: grid;
  gap: 8px;
}

.label {
  font-size: 12px;
  color: var(--muted);
}

.select {
  height: 36px;
  border-radius: 6px;
  border: 1px solid rgba(0, 0, 0, 0.25);
  background: #fff;
  padding: 0 10px;
  outline: none;
}

.short-desc {
  margin: 14px 0 0;
  color: #2f2f2f;
  max-width: 520px;
}


.btn {
  border-radius: 6px;
  padding: 10px 16px;
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.06s ease, opacity 0.2s ease;
  border: 1px solid transparent;
}

.btn:active {
  transform: translateY(1px);
}

.btn-primary {
  background: var(--gold);
  border-color: var(--gold-2);
  color: #111;
  width: min(420px, 100%);
}

.btn-primary:hover {
  opacity: 0.92;
}

.btn-outline {
  background: transparent;
  border-color: rgba(176, 138, 58, 0.55);
  color: #ead8b7;
}

.btn-outline:hover {
  opacity: 0.9;
}

.btn-sm {
  padding: 8px 12px;
  font-size: 13px;
}


.desc-bar {
  width: min(1100px, 92vw);
  margin: 38px auto 0;
  background: var(--panel);
  border-radius: 8px;
  border: 1px solid rgba(176, 138, 58, 0.25);
  box-shadow: 0 12px 26px rgba(0, 0, 0, 0.14);
}

.desc-inner {
  padding: 20px 22px;
}

.desc-title {
  margin: 0 0 8px;
  color: #d8c8a6;
  font-weight: 700;
  letter-spacing: 0.04em;
}

.desc-text {
  margin: 0;
  color: #cdbb96;
  line-height: 1.6;
}


.recommended {
  width: min(1100px, 92vw);
  margin: 26px auto 0;
  padding-top: 6px;
}

.reco-title {
  text-align: center;
  color: var(--gold);
  margin: 0 0 18px;
  font-size: 14px;
  letter-spacing: 0.06em;
  text-transform: none;
}

.reco-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 26px;
  align-items: start;
}

@media (max-width: 980px) {
  .reco-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 520px) {
  .reco-grid {
    grid-template-columns: 1fr;
  }
}

.card {
  background: transparent;
  display: grid;
  justify-items: center;
  gap: 8px;
}

.card-img {
  width: 150px;
  height: auto;
  border-radius: 8px;
  background: #141414;
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.14);
}

.card-name {
  margin: 6px 0 0;
  font-weight: 700;
  letter-spacing: 0.08em;
  font-size: 12px;
  color: #1a1a1a;
  text-transform: uppercase;
}

.card-price {
  margin: 0;
  color: #2b2b2b;
  font-size: 13px;
}
</style>
