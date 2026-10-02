import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';

const state = {
    tiktok: [],
};

const mutations = {
    SET_TIKTOK(state, request) {
        state.tiktok = request;
    },
};

// Lấy thông báo lỗi validate (422) từ Laravel, nếu có
const errorMessage = (error, fallback) => {
    const errors = error.response?.data?.errors;
    if (errors) {
        return Object.values(errors).flat()[0];
    }
    return error.response?.data?.message || fallback;
};

const actions = {
    async fetchTiktok({ commit }) {
        try {
            const response = await api.get(API_ENDPOINT.API_ADMIN.TIKTOK);
            commit('SET_TIKTOK', response.data);
        } catch (error) {
            console.error('Error fetching tiktok:', error);
        }
    },
    async addTiktok({commit}, { data, toast }) {
        try {
            const response = await api.post(API_ENDPOINT.API_ADMIN.TIKTOK, data);
            if (response.data.success) {
                toast.open({message: response.data.message, type: 'success', position: 'top'});
                return true;
            }
        } catch (error) {
            console.error('Error add tiktok:', error);
            toast.open({message: errorMessage(error, 'Thêm mới thất bại vui lòng thử lại.'), type: 'error', position: 'top'});
        }
        return false;
    },
    async updateTiktok({commit}, { data, toast }) {
        try {
            const response = await api.put(`${API_ENDPOINT.API_ADMIN.TIKTOK}/${data.id}`, data);
            if (response.data.success) {
                toast.open({message: response.data.message, type: 'success', position: 'top'});
                return true;
            }
        } catch (error) {
            console.error('Error update tiktok:', error);
            toast.open({message: errorMessage(error, 'Cập nhật thất bại vui lòng thử lại.'), type: 'error', position: 'top'});
        }
        return false;
    },
    async deleteTiktok({commit}, { id, toast }) {
        try {
            const response = await api.delete(`${API_ENDPOINT.API_ADMIN.TIKTOK}/${id}`);
            if (response.data.success) {
                toast.open({message: response.data.message, type: 'success', position: 'top'});
            }
        } catch (error) {
            console.error('Error delete tiktok:', error);
            toast.open({message: 'Xóa thất bại vui lòng thử lại.', type: 'error', position: 'top'});
        }
    },
};

const getters = {
    tiktokAll: (state) => state.tiktok,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
