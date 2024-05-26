import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
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
            const response = await api.get(API_ENDPOINT.API_ADMIN.REQUEST);
            const user = response.data;
            commit('SET_REQUEST', user);
        } catch (error) {
            console.error('Error fetching user:', error);
        }
    },
    async updateStatus({ commit }, { id, toast }) {
        try {
            const response = await api.put(`${API_ENDPOINT.API_ADMIN.REQUEST}/${id}`);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
            }
        } catch (error) {
            console.error('Error fetching user:', error);
        }
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
