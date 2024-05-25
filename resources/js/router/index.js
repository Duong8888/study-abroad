import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';
import About from '@/views/About.vue';
import HomeAdmin from '@/views/admin/Home.vue';
import Login from '@/views/admin/Login.vue';
import NotFound from '@/views/NotFound.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/about',
        name: 'About',
        component: About
    },
    {
        path: '/admin/home',
        name: 'HomeAdmin',
        component: HomeAdmin
    },
    {
        path: '/admin/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/:catchAll(.*)', // Bắt tất cả các route không khớp
        name: 'NotFound',
        component: NotFound
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
