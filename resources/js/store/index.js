import { createStore } from 'vuex';
import request from './module/request.js';
import auth from './module/auth.js';

const store = createStore({
    modules: {
        request,
        auth
    },
});

export default store;

