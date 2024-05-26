import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
const state = {
    category: [],
};

const mutations = {
    SET_CATEGORY(state, request) {
        state.category = request;
    },
};

const actions = {
    async fetchCategory({ commit }) {
        try {
            const response = await api.get(API_ENDPOINT.API_ADMIN.CATEGORY);
            console.log(response);
            const category = response.data;
            commit('SET_CATEGORY', category);
        } catch (error) {
            console.error('Error fetching user:', error);
        }
    },
};

const getters = {
    categoryAll: (state) => state.category,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
