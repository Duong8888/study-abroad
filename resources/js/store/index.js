import { createStore } from 'vuex';
import request from './module/request.js';
import auth from './module/auth.js';
import posts from './module/posts.js';
import category from './module/category.js';

const store = createStore({
    modules: {
        request,
        auth,
        posts,
        category,
    },
});

export default store;

