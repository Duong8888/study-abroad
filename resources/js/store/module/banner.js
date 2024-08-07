import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
import router from '../../router';
const state = {
    banner:[],
    topBanner:[],
    adsBanner:[],
    statusBtn: false,
};

const mutations = {
    SET_BANNER(state, request) {
        state.banner = request.banner;
        if(request.option.type == 0){
            state.topBanner = request.banner;
        }
    },
    SET_STATUS_BTN(state, value) {
        state.statusBtn = value;
    },
};

const actions = {
    async fetchBanner({ commit }, type = null) {
        try {
            const params = {};
            if (type !== null) {
                params.type = type;
            }
            const response = await api.get(API_ENDPOINT.API_ADMIN.BANNER,{ params });
            const banner = response.data;
            let option = {};
            if(type !== null){
                option.type = type;
            }
            commit('SET_BANNER', {banner , option});
        } catch (error) {
            console.error('Error fetching banner:', error);
        }
    },
    async addBanner({commit}, { data, toast }) {
        try {
            commit('SET_STATUS_BTN', true);
            const response = await api.post(API_ENDPOINT.API_ADMIN.BANNER,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                await router.push({name: 'TopBanner'});
                commit('SET_STATUS_BTN', false);
            }
        } catch (error) {
            console.error('Error add banner:', error);
            toast.open({
                message: 'Thêm mới thất bại vui lòng thử lại.',
                type: 'error',
                position: 'top'
            });
            commit('SET_STATUS_BTN', false);
        }
    },

    async updateBanner({commit}, { data, toast }) {
        try {
            commit('SET_STATUS_BTN', true);
            const response = await api.put(`${API_ENDPOINT.API_ADMIN.BANNER}/${data.id}`,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                commit('SET_STATUS_BTN', false);
            }
        } catch (error) {
            console.error('Error add banner:', error);
            toast.open({
                message: 'Error! An error occurred. Please try again later',
                type: 'error',
                position: 'top'
            });
            commit('SET_STATUS_BTN', false);
        }
    },

    async deleteBanner({commit}, { ids, toast }) {
        try {
            const response = await api.post(`${API_ENDPOINT.API_ADMIN.BANNER}/delete`,{ids:ids});
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
    bannerAll: (state) => state.banner,
    topBanner: (state) => state.topBanner,
    statusBtn: (state) => state.statusBtn,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
