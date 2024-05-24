import './bootstrap';
import { createApp } from 'vue';
import App from '@/App.vue';
import Store from '@/store'
import Router from '@/router';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

createApp(App)
    .use(Store)
    .use(Router)
    .use(ToastPlugin)
    .mount('#app');
