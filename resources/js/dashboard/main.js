import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import api from './api';
import { useAdminStore } from './stores/admin';
import './styles.css';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);

// Provide axios globally in case views want it.
app.config.globalProperties.$api = api;

// Hydrate the admin user (who we are + which role) before mount.
const admin = useAdminStore();
admin.load();

app.mount('#dashboard-app');
