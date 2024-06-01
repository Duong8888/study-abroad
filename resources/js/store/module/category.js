import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
import router from "@/router/index.js";
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
    async addType({commit}, { data, toast }) {
        try {
            const response = await api.post(API_ENDPOINT.API_ADMIN.CATEGORY,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                await router.push({name: 'Category'})
            }
        } catch (error) {
            console.error('Error add banner:', error);
            toast.open({
                message: 'Thêm mới thất bại vui lòng thử lại.',
                type: 'error',
                position: 'top'
            });
        }
    },

    async updateType({commit}, { data, toast }) {
        try {
            const response = await api.put(`${API_ENDPOINT.API_ADMIN.CATEGORY}/${data.id}`,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
            }
        } catch (error) {
            console.error('Error add banner:', error);
            toast.open({
                message: 'Error! An error occurred. Please try again later',
                type: 'error',
                position: 'top'
            });
        }
    },

    async deleteType({commit}, { id, toast }) {
        try {
            console.log(id);
            const response = await api.delete(`${API_ENDPOINT.API_ADMIN.CATEGORY}/${id}`);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
            }
        } catch (error) {
            console.error('Error add posts:', error);
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
