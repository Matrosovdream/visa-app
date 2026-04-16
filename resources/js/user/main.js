import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import { useAuthStore } from './stores/auth';
import { useGlobalsStore } from './stores/globals';
import revealDirective from './directives/reveal';
import './styles.css';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.directive('reveal', revealDirective);

// Rehydrate auth from localStorage and warm the globals store before mount.
const auth = useAuthStore();
auth.init();

const globals = useGlobalsStore();
globals.load();

app.mount('#user-app');
