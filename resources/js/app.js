import './bootstrap';
import { createApp } from 'vue';
import App from '@/App.vue';
import Store from '@/store'
import Router from '@/router';
import toast, { Toaster } from 'solid-toast';

createApp(App)
    .use(Store)
    .use(Router)
    .use(toast)
    .mount('#app');
