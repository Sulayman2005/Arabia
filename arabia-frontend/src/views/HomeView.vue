<script setup>
import { RouterLink } from "vue-router";
</script>

<template>
  <main class="home">
    <section class="hero">
      <h1 class="title">Arabia</h1>
      <p class="texte">
        Arabia est une marque de cosmétique et de parfumerie inspirée par l'élégance et la sensualité du musc.
        Elle incarne l'essence des traditions orientales tout en proposant des créations modernes raffinées et minimaliste.
        Chaque produit est conçu pour offrir une expérience unique, mêlant douceur, intensité et authenticité.
        Arabia célèbre un art de vivre où le parfum devient une signature personnelle, subtile et inoubliable.
      </p>
    </section>

    <h2 class="subtitle">Liste de nos parfums</h2>

    <section class="grid">
      <div class="card">
        <RouterLink to="/produit/musc-royal">
          <img src="@/assets/musc_royal.PNG" alt="Parfum 1" width="120px" />
        </RouterLink>
      </div>
      <div class="card">
        <RouterLink to="/produit/amber-tears">
          <img src="@/assets/amber_tears.PNG" alt="Parfum 2" width="120px" />
        </RouterLink>
      </div>
      <div class="card">
        <RouterLink to="/produit/black-saffron">
          <img src="@/assets/black_saffron.PNG" alt="Parfum 3" width="120px" />
        </RouterLink>
      </div>
      <div class="card">
        <RouterLink to="/produit/desert-vanille">
          <img src="@/assets/desert_vanille.PNG" alt="Parfum 4" width="120px" />
        </RouterLink>
      </div>
      <div class="card">
        <RouterLink to="/produit/imperial-oud">
          <img src="@/assets/imperial_oud.PNG" alt="Parfum 5" width="120px" />
        </RouterLink>
      </div>
      <div class="card">
        <RouterLink to="/produit/rose-divine">
          <img src="@/assets/rose_divine.PNG" alt="Parfum 6" width="120px" />
        </RouterLink>
      </div>
    </section>
  </main>
  <footer class="logo_footer">
    <img src="@/assets/logo.png" alt="Logo Arabia" />
  </footer>
</template>


<style scoped>
.logo_footer {
  display: grid;
  place-items: end;
  margin-top: -59px;  
}

.logo img {
    display: flex;
  }

.home {
  padding: 70px;
}

/* Section du haut */
.hero {
  max-width: 900px;
  margin: 0 auto 70px;
  text-align: center;
}

.title {
  display: flex;
  margin: 0 110px 18px;
  font-size: 48px;
  font-weight: 600;
}

.texte {
  margin: 0 auto;
  max-width: 700px;
}

/* Sous-titre */
.subtitle {
  text-align: center;
  font-weight: 600;
  margin: 80px 0 30px;
  letter-spacing: 0.4px;
}

/* Grille produits */
.grid {
  max-width: 1100px;
  display: grid;
  place-items: center;
  margin: 0 auto;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 28px;
}

/* Cards (placeholder) */
.card img {
  text-align: center;
  border-radius: 18px;
  cursor: pointer;
  transition: transform 0.2s;
}

/* Responsive */
@media (max-width: 900px) {
  .grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
  .title {
    font-size: 40px;
  }
}

@media (max-width: 600px) {
  .home {
    padding-top: 90px;
  }
  .grid {
    grid-template-columns: 1fr;
  }
  .title {
    font-size: 34px;
  }
}
</style>