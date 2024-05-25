import { createStore } from 'vuex';
import request from './module/request.js';

const store = createStore({
    modules: {
        request,
    },
});

export default store;

