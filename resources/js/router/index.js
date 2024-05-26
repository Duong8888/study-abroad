import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';
import About from '@/views/About.vue';
import Request from '@/views/admin/Request.vue';
import Login from '@/views/admin/Login.vue';
import Posts from '@/views/admin/Posts.vue';
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
        path: '/admin/request',
        name: 'Request',
        component: Request
    },
    {
        path: '/admin/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/admin/posts',
        name: 'Posts',
        component: Posts
    },
    {
        path: '/:catchAll(.*)',
        name: 'NotFound',
        component: NotFound
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('authToken');
    if (to.name === 'Login' && isAuthenticated) {
        next({ name: 'Request' });
    } else {
        next();
    }
});

export default router;
