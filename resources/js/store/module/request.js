import {API_ENDPOINT} from "../api-endpoint.js";
const state = {
    request: [],
};

const mutations = {
    UPDATE_STATUS(state, status) {
        state.request.status = status;
    },
    SET_REQUEST(state, request) {
        state.request = request;
    },
};

const actions = {
    async fetchRequest({ commit }) {
        try {
            const token = localStorage.getItem('authToken');
            const response = await axios.get(API_ENDPOINT.API_ADMIN.GET_REQUEST,
            {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            const user = response.data;
            commit('SET_REQUEST', user);
        } catch (error) {
            console.error('Error fetching user:', error);
        }
    },
    updateStatus({ commit }, name) {
        commit('SET_USER_NAME', name);
    },
};

const getters = {
    userAll: (state) => state.request,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
