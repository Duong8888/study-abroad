import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';
import About from '@/views/About.vue';
import Request from '@/views/admin/Request.vue';
import Login from '@/views/admin/Login.vue';
import Posts from '@/views/admin/Posts.vue';
import CreatePosts from '@/views/admin/CreatePosts.vue';
import NotFound from '@/views/NotFound.vue';
import AdminLayout from '@/views/admin/AdminLayout.vue';

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
        path: '/admin',
        name: 'AdminLayout',
        component: AdminLayout,
        children: [
            {
                path: 'request',
                name: 'Request',
                component: Request
            },
            {
                path: 'login',
                name: 'Login',
                component: Login
            },
            {
                path: 'posts',
                name: 'Posts',
                component: Posts
            },
            {
                path: 'create-posts',
                name: 'CreatePosts',
                component: CreatePosts
            },
        ]
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
