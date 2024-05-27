import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';
import About from '@/views/About.vue';
import Request from '@/views/admin/Request.vue';
import Login from '@/views/admin/Login.vue';
import Posts from '@/views/admin/Posts.vue';
import CreatePosts from '@/views/admin/CreatePosts.vue';
import NotFound from '@/views/NotFound.vue';
import AdminLayout from '@/views/admin/AdminLayout.vue';
import Category from "@/views/admin/Category.vue";
import PostsAdd from "@/views/admin/PostsAdd.vue";

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
        path: '/admin/login',
        name: 'Login',
        component: Login
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
                path: 'posts',
                name: 'Posts',
                component: Posts
            },
            {
                path: 'posts/:postsId',
                name: 'EditPosts',
                component: PostsAdd
            },
            {
                path: 'posts/create',
                name: 'CreatePosts',
                component: PostsAdd
            },
            {
                path: 'category',
                name: 'Category',
                component: Category
            },
            {
                path: 'email',
                name: 'Email',
                component: Category
            },
            {
                path: 'ads-banner',
                name: 'AdsBanner',
                component: Category
            },
            {
                path: 'top-banner',
                name: 'TopBanner',
                component: Category
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
