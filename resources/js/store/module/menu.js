import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
import router from "@/router/index.js";
const state = {
    menu: [],
};

const mutations = {
    SET_MENU(state, request) {
        state.menu = request;
    },
};

const actions = {
    async fetchMenu({ commit }) {
        try {
            const response = await api.get(API_ENDPOINT.API_ADMIN.MENU);
            const menu = response.data;
            commit('SET_MENU', menu);
        } catch (error) {
            console.error('Error fetching user:', error);
        }
    },
    async addMenu({commit}, { data, toast }){
        try {
            const response = await api.post(API_ENDPOINT.API_ADMIN.MENU,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                await router.push({name: 'Menu'})
            }
        } catch (error) {
            console.error('Error add menu:', error);
            toast.open({
                message: 'Thêm mới thất bại vui lòng thử lại.',
                type: 'error',
                position: 'top'
            });
        }
    },
    async updateMenu({commit}, { data, toast }) {
        try {
            const response = await api.put(`${API_ENDPOINT.API_ADMIN.MENU}/${data.id}`,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
            }
        } catch (error) {
            console.error('Error add menu:', error);
            toast.open({
                message: 'Error! An error occurred. Please try again later',
                type: 'error',
                position: 'top'
            });
        }
    },

    async deleteMenu({commit}, { id, toast }) {
        try {
            const response = await api.delete(`${API_ENDPOINT.API_ADMIN.MENU}/${id}`);
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
    menuAll: (state) => state.menu,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
