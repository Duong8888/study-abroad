import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
import router from '../../router';
const state = {
    university: [],
    statusBtn: false,
};

const mutations = {
    SET_UNIVERSITY_LIST(state, request) {
        state.university = request;
    },
    SET_STATUS_BTN(state, value) {
        state.statusBtn = value;
    },
};

const actions = {
    async fetchItem({ commit }, sort = null) {
        try {
            const params = {};
            if (sort !== null) {
                params.sort = sort;
            }
            const response = await api.get(API_ENDPOINT.API_ADMIN.UNIVERSITY,{ params });
            const team = response.data;
            commit('SET_UNIVERSITY_LIST', team);
        } catch (error) {
            console.error('Error fetching user:', error);
        }
    },
    async addItem({commit}, { data, toast }) {
        try {
            commit('SET_STATUS_BTN', true);
            const response = await api.post(API_ENDPOINT.API_ADMIN.UNIVERSITY,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                commit('SET_STATUS_BTN', false);
                await router.push({name: 'University'});
            }
        } catch (error) {
            console.error('Error add team:', error);
            toast.open({
                message: 'Error! An error occurred. Please try again later',
                type: 'error',
                position: 'top'
            });
            commit('SET_STATUS_BTN', false);
        }
    },

    async updateItem({commit}, { data, toast }) {
        try {
            commit('SET_STATUS_BTN', true);
            const response = await api.post(`${API_ENDPOINT.API_ADMIN.UNIVERSITY}/${data.get('id')}`,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                await router.push({name: 'University'});
                commit('SET_STATUS_BTN', false);
            }
        } catch (error) {
            console.error('Error add team:', error);
            toast.open({
                message: 'Error! An error occurred. Please try again later',
                type: 'error',
                position: 'top'
            });
            commit('SET_STATUS_BTN', false);
        }
    },

    async deleteItem({commit}, { id, toast }) {
        try {
            const response = await api.delete(`${API_ENDPOINT.API_ADMIN.UNIVERSITY}/${id}`);
            const team = response.data;
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
            }
        } catch (error) {
            console.error('Error add team:', error);
        }
    },
};

const getters = {
    universityAll: (state) => state.university,
    statusBtn: (state) => state.statusBtn,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
