# arabia-frontend

This template should help get you started developing with Vue 3 in Vite.

## Recommended IDE Setup

[VS Code](https://code.visualstudio.com/) + [Vue (Official)](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur).

## Recommended Browser Setup

- Chromium-based browsers (Chrome, Edge, Brave, etc.):
  - [Vue.js devtools](https://chromewebstore.google.com/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd) 
  - [Turn on Custom Object Formatter in Chrome DevTools](http://bit.ly/object-formatters)
- Firefox:
  - [Vue.js devtools](https://addons.mozilla.org/en-US/firefox/addon/vue-js-devtools/)
  - [Turn on Custom Object Formatter in Firefox DevTools](https://fxdx.dev/firefox-devtools-custom-object-formatters/)

## Customize configuration

See [Vite Configuration Reference](https://vite.dev/config/).

## Project Setup

```sh
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

### Compile and Minify for Production

```sh
npm run build
```










📌 Description du projet

Arabia est une application web e-commerce dédiée à la vente de parfums orientaux (musc, oud, ambre, coffrets, huiles parfumées).

Le projet est composé de :

🔹 Backend : API REST développée avec Symfony 7.3 + API Platform

🔹 Frontend : Application SPA développée avec Vue.js 3 + Vite

🔹 Authentification sécurisée : JWT (LexikJWTAuthenticationBundle)

🔹 Base de données : MySQL

🔹 Conteneurisation : Docker

🏗️ Architecture du projet
Arabia/
│
├── arabia-backend/     → API Symfony 7.3
├── arabia-frontend/    → Application Vue.js
├── docker/             → Configuration Nginx
├── docker-compose.yml
⚙️ Technologies utilisées
🔹 Backend

PHP 8.4

Symfony 7.3

API Platform

Doctrine ORM

MySQL

JWT (LexikJWTAuthenticationBundle)

PHPUnit (tests automatisés)

Docker

🔹 Frontend

Vue.js 3

Vite

Vue Router

Composition API

Fetch API

Docker

🚀 Installation du projet
1️⃣ Cloner le projet
git clone <url-du-repo>
cd Arabia
2️⃣ Lancer avec Docker
docker compose up --build

Accès :

Frontend : http://localhost

Backend API : http://localhost:8080/api

Documentation Swagger : http://localhost:8080/api/docs

🔐 Authentification

Le projet utilise JWT (JSON Web Token).

Endpoint login
POST /api/login

Body :

{
  "email": "admin@test.com",
  "password": "password"
}

Retour :

{
  "token": "JWT_TOKEN"
}

Ensuite utiliser dans les requêtes protégées :

Authorization: Bearer TOKEN
📦 Fonctionnalités principales
👤 Utilisateurs

Inscription

Connexion JWT

Gestion des rôles (ROLE_USER / ROLE_ADMIN)

🛍 Produits

Affichage du catalogue

Détail d’un produit

Création / modification / suppression (admin)

Validation des données

📂 Catégories

Création

Modification

Liaison avec produits

🛒 Panier

Ajout produit

Modification quantité

Suppression

❤️ Favoris

Ajout / suppression

📦 Commandes

Création

Consultation

🧪 Tests
✅ Backend – PHPUnit

Les tests couvrent :

Authentification (JWT)

Sécurité (rôles, accès endpoints)

CRUD minimum sur entités critiques (Produit + Catégorie)

Validation des données (erreurs 422)

Vérification des codes HTTP

Lancer les tests backend :
docker exec -it arabia_backend_dev php bin/phpunit

Résultat attendu :

OK (tests passed)
🖥️ Frontend

Tests fonctionnels validés sur :

Navigation entre les pages

Connexion / Déconnexion

Catalogue produits

Détail produit

Gestion panier

Gestion favoris

(Possibilité d’ajouter Vitest ou Cypress en amélioration future.)

🗄️ Base de données

Configuration utilisée en environnement test :

DATABASE_URL="mysql://app:app@mysql:3306/arabia_test?serverVersion=8.0&charset=utf8mb4"
🔑 Génération des clés JWT
php bin/console lexik:jwt:generate-keypair --overwrite
📂 Structure Backend
src/
 ├── Entity/
 ├── Repository/
 ├── Controller/
 ├── ApiResource/
 ├── DataFixtures/
tests/
 ├── Api/
📂 Structure Frontend
src/
 ├── api/
 ├── composables/
 ├── router/
 ├── services/
 ├── stores/
 ├── views/
🧠 Logique métier

Gestion du stock produit

Description minimale obligatoire

Date d’ajout obligatoire

Sécurité basée sur rôles

Relations entre entités (Produit → Catégorie)

🔒 Sécurité

JWT sécurisé (RS256)

Rôles :

ROLE_USER

ROLE_ADMIN

Protection des endpoints sensibles

Validation serveur obligatoire

📈 Améliorations possibles

Tests unitaires sur services métier

Tests E2E frontend (Cypress)

Intégration paiement Stripe

Dashboard administrateur avancé

Upload et gestion d’images

Pagination optimisée

Déploiement en production (CI/CD)
