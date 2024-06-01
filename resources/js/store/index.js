import { createStore } from 'vuex';
import request from './module/request.js';
import auth from './module/auth.js';
import posts from './module/posts.js';
import category from './module/category.js';
import banner from './module/banner.js';
import menu from './module/menu.js';

const store = createStore({
    modules: {
        request,
        auth,
        posts,
        category,
        banner,
        menu,
    },
});

export default store;

