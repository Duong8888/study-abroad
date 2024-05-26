import './bootstrap';
import { createApp } from 'vue';
import App from '@/App.vue';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import Store from '@/store'
import Router from '@/router';
import CKEditor from '@ckeditor/ckeditor5-vue';

createApp(App)
    .use(ToastPlugin)
    .use(CKEditor)
    .use(Store)
    .use(Router)
    .mount('#app');
