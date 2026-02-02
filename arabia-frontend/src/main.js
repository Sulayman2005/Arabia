// // import './assets/main.css'
// import './assets/base.css'
// // import { createApp } from 'vue'
// // import App from './App.vue'

// // createApp(App).mount('#app')

// import { createApp } from "vue";
// import App from "./App.vue";
// import router from "./router";

// createApp(App).use(router).mount("#app");


import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import './assets/base.css'

const app = createApp(App);

app.use(createPinia());
app.use(router);

app.mount("#app");
