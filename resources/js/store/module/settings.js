import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';

const state = {
    settings: {},
};

const mutations = {
    SET_SETTINGS(state, request) {
        state.settings = request;
    },
};

const actions = {
    async fetchSettings({ commit }) {
        try {
            const response = await api.get(API_ENDPOINT.API_ADMIN.SETTINGS);
            // Laravel trả về [] khi chưa có dữ liệu, đổi về object cho dễ dùng
            commit('SET_SETTINGS', Array.isArray(response.data) ? {} : response.data);
        } catch (error) {
            console.error('Error fetching settings:', error);
        }
    },
    async updateSettings({ commit }, { data, toast }) {
        try {
            const response = await api.put(API_ENDPOINT.API_ADMIN.SETTINGS, data);
            if (response.data.success) {
                commit('SET_SETTINGS', data);
                toast.open({message: response.data.message, type: 'success', position: 'top'});
            }
        } catch (error) {
            console.error('Error update settings:', error);
            const errors = error.response?.data?.errors;
            toast.open({
                message: errors ? Object.values(errors).flat()[0] : 'Lưu thất bại vui lòng thử lại.',
                type: 'error',
                position: 'top'
            });
        }
    },
};

const getters = {
    settingsAll: (state) => state.settings,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
