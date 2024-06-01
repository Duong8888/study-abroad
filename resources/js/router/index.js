import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';
import Request from '@/views/admin/Request.vue';
import Login from '@/views/admin/Login.vue';
import Posts from '@/views/admin/Posts.vue';
import CreatePosts from '@/views/admin/CreatePosts.vue';
import NotFound from '@/views/NotFound.vue';
import AdminLayout from '@/views/admin/AdminLayout.vue';
import Category from "@/views/admin/Category.vue";
import PostsAdd from "@/views/admin/PostsAdd.vue";
import PostsList from "@/views/PostsList.vue";
import Layout from "@/views/admin/Layout.vue";
import PostsDetail from "@/views/PostsDetail.vue";
import TopBanner from "@/views/admin/Banner.vue";
import AddBanner from "@/views/admin/AddBanner.vue";
import EditBanner from "@/views/admin/EditBanner.vue";
import AdsBanner from "@/views/admin/AdsBanner.vue";
import MenuManagement from "@/views/admin/MenuManagement.vue";

const routes = [

    {
        path: '/',
        name: 'Layout',
        component: Layout,
        children: [
            {
                path: '',
                name: 'Home',
                component: Home
            },
            {
                path: 'blogs',
                name: 'PostsList',
                component: PostsList
            },
            {
                path: 'blogs/:slug',
                name: 'PostsDetail',
                component: PostsDetail
            },
        ]
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
                component: AdsBanner
            },
            {
                path: 'top-banner',
                name: 'TopBanner',
                component: TopBanner
            },
            {
                path: 'add-banner',
                name: 'AddBanner',
                component: AddBanner
            },
            {
                path: 'edit-banner',
                name: 'EditBanner',
                component: EditBanner
            },
            {
                path: 'menu',
                name: 'Menu',
                component: MenuManagement
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
        window.scrollTo(0, 0);
        next();
    }
});

export default router;
