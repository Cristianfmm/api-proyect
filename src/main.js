import { createApp } from 'vue';
import App from './App.vue';
import store from './store'; // Importa Vuex

const app = createApp(App);
app.use(store); // Usa Vuex en la app
app.mount('#app');
