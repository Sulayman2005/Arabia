<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import api from "@/api/axios";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const auth = useAuthStore();

const email = ref("");
const password = ref("");
const remember = ref(false);
const showPassword = ref(false);
const loading = ref(false);
const error = ref("");

const onSubmit = async () => {
  error.value = "";

  if (!email.value.trim() || !password.value.trim()) {
    error.value = "Veuillez renseigner votre email et votre mot de passe.";
    return;
  }

  loading.value = true;

  try {
    // POST /api/login (Symfony + LexikJWT)
    const res = await api.post("/login", {
      email: email.value.trim(),
      password: password.value,
    });

    const token = res.data?.token;
    if (!token) throw new Error("Token manquant dans la réponse");

    // ✅ Pinia devient la source de vérité
    auth.setAuth(token, { email: email.value.trim() });

    if (remember.value) {
      localStorage.setItem("rememberedEmail", email.value.trim());
    } else {
      localStorage.removeItem("rememberedEmail");
    }

    router.push("/accueil");
  } catch (e) {
    error.value = "Identifiants incorrects";
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <main class="auth">
    <section class="card">
      <header class="header">
        <p class="brand">ARABIA</p>
        <h1 class="title">Connexion</h1>
        <p class="subtitle">Accédez à votre espace et retrouvez vos favoris.</p>
      </header>

      <form class="form" @submit.prevent="onSubmit">
        <div v-if="error" class="alert" role="alert">
          {{ error }}
        </div>

        <label class="field">
          <span class="label">Email</span>
          <input
            v-model="email"
            class="input"
            type="email"
            placeholder="ex: you@email.com"
            autocomplete="email"
          />
        </label>

        <label class="field">
          <span class="label">Mot de passe</span>

          <div class="password">
            <input
              v-model="password"
              class="input"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Votre mot de passe"
              autocomplete="current-password"
            />
            <button
              type="button"
              class="toggle"
              @click="showPassword = !showPassword"
              :aria-label="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
            >
              {{ showPassword ? "Masquer" : "Afficher" }}
            </button>
          </div>
        </label>

        <div class="row">
          <label class="remember">
            <input v-model="remember" type="checkbox" />
            <span>Se souvenir de moi</span>
          </label>
        </div>

        <button class="btn" type="submit" :disabled="loading">
          <span v-if="!loading">Se connecter</span>
          <span v-else>Connexion...</span>
        </button>
      </form>
    </section>
  </main>
</template>

<style scoped>
.auth {
  min-height: calc(100vh - 80px);
  padding: 90px 18px 40px;
  display: grid;
  place-items: center;
  background:
    radial-gradient(900px 500px at 50% 15%, rgba(212, 175, 55, 0.12), transparent 55%),
    radial-gradient(700px 400px at 20% 60%, rgba(212, 175, 55, 0.08), transparent 60%),
    #0b0b0b;
  color: #f6f0db;
}

.card {
  width: 100%;
  max-width: 520px;
  border-radius: 22px;
  padding: 28px;
  background: rgba(16, 16, 16, 0.78);
  border: 1px solid rgba(212, 175, 55, 0.22);
  box-shadow: 0 18px 60px rgba(0, 0, 0, 0.65);
  backdrop-filter: blur(10px);
}

.header {
  text-align: center;
  margin-bottom: 18px;
}

.brand {
  letter-spacing: 4px;
  font-weight: 600;
  color: rgba(212, 175, 55, 0.85);
  margin: 0 0 6px;
}

.title {
  margin: 0;
  font-size: 34px;
  font-weight: 700;
  color: #d4af37;
}

.subtitle {
  margin: 10px auto 0;
  max-width: 360px;
  font-size: 14px;
  opacity: 0.9;
  line-height: 1.45;
}

.form {
  display: grid;
  gap: 14px;
}

.alert {
  border-radius: 14px;
  padding: 12px 12px;
  background: rgba(255, 80, 80, 0.12);
  border: 1px solid rgba(255, 80, 80, 0.28);
  color: #ffd6d6;
  font-size: 14px;
}

.field {
  display: grid;
  gap: 8px;
}

.label {
  font-size: 13px;
  color: rgba(246, 240, 219, 0.85);
}

.input {
  width: 100%;
  height: 46px;
  padding: 0 14px;
  border-radius: 14px;
  background: rgba(0, 0, 0, 0.45);
  border: 1px solid rgba(212, 175, 55, 0.22);
  color: #f6f0db;
  outline: none;
  transition: border-color 0.15s, box-shadow 0.15s, transform 0.15s;
}

.input::placeholder {
  color: rgba(246, 240, 219, 0.45);
}

.input:focus {
  border-color: rgba(212, 175, 55, 0.55);
  box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.12);
}

.password {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 10px;
  align-items: center;
}

.toggle {
  height: 46px;
  padding: 0 12px;
  border-radius: 14px;
  background: rgba(212, 175, 55, 0.12);
  border: 1px solid rgba(212, 175, 55, 0.22);
  color: rgba(246, 240, 219, 0.95);
  cursor: pointer;
  transition: transform 0.15s, background 0.15s, border-color 0.15s;
}

.toggle:hover {
  background: rgba(212, 175, 55, 0.18);
  border-color: rgba(212, 175, 55, 0.35);
}

.row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  margin-top: 2px;
}

.remember {
  display: flex;
  gap: 10px;
  align-items: center;
  font-size: 13px;
  opacity: 0.9;
}

.remember input {
  width: 16px;
  height: 16px;
  accent-color: #d4af37;
}

.btn {
  margin-top: 6px;
  height: 48px;
  border-radius: 16px;
  border: 1px solid rgba(212, 175, 55, 0.4);
  background: linear-gradient(180deg, rgba(212, 175, 55, 0.95), rgba(150, 120, 30, 0.95));
  color: #0b0b0b;
  font-weight: 700;
  letter-spacing: 0.2px;
  cursor: pointer;
  transition: transform 0.12s, filter 0.12s;
}

.btn:hover {
  transform: translateY(-1px);
  filter: brightness(1.02);
}

.btn:disabled {
  cursor: not-allowed;
  opacity: 0.75;
  transform: none;
}

@media (max-width: 520px) {
  .card {
    padding: 22px;
  }
  .title {
    font-size: 30px;
  }
  .row {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>
