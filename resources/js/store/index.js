import { createStore } from 'vuex';
import request from './module/request.js';
import auth from './module/auth.js';
import posts from './module/posts.js';
import category from './module/category.js';
import banner from './module/banner.js';
import menu from './module/menu.js';
import team from './module/team.js';

const store = createStore({
    modules: {
        request,
        auth,
        posts,
        category,
        banner,
        menu,
        team,
    },
});

export default store;

