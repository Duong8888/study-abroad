import { createStore } from 'vuex';
import request from './module/request.js';
import auth from './module/auth.js';
import posts from './module/posts.js';
import category from './module/category.js';
import banner from './module/banner.js';
import menu from './module/menu.js';
import team from './module/team.js';
import universities from './module/universities.js';
import files from './module/files.js';
import tiktok from './module/tiktok.js';
import settings from './module/settings.js';
import testimonial from './module/testimonial.js';

const store = createStore({
    modules: {
        request,
        auth,
        posts,
        category,
        banner,
        menu,
        team,
        universities,
        files,
        tiktok,
        settings,
        testimonial,
    },
});

export default store;

