import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
import defaultLogoMain from '@/assets/images/common/logo.png';
import defaultLogoWhite from '@/assets/images/common/logo-new.png';
import defaultLogoFooter from '@/assets/images/common/logo-footer.png';

// Cài đặt được server gửi sẵn trong app.blade.php, có ngay khi trang mở nên logo không bị nháy
const preloaded = window.__SETTINGS__ || null;

const state = {
    settings: preloaded || {},
    // Đã có sẵn từ server thì không cần gọi API lần đầu nữa
    loading: preloaded ? Promise.resolve() : null,
};

const mutations = {
    SET_SETTINGS(state, request) {
        state.settings = request;
    },
    MERGE_SETTINGS(state, request) {
        state.settings = {...state.settings, ...request};
    },
    REMOVE_SETTING(state, key) {
        const {[key]: removed, ...rest} = state.settings;
        state.settings = rest;
    },
    SET_LOADING(state, promise) {
        state.loading = promise;
    },
};

const errorMessage = (error, fallback) => {
    const errors = error.response?.data?.errors;
    return errors ? Object.values(errors).flat()[0] : fallback;
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
    // Nhiều component cùng cần settings (header, footer, logo...), chỉ gọi API 1 lần
    loadSettings({ state, commit, dispatch }) {
        if (!state.loading) {
            commit('SET_LOADING', dispatch('fetchSettings'));
        }
        return state.loading;
    },
    async updateSettings({ commit }, { data, toast }) {
        try {
            const response = await api.put(API_ENDPOINT.API_ADMIN.SETTINGS, data);
            if (response.data.success) {
                commit('MERGE_SETTINGS', data);
                toast.open({message: response.data.message, type: 'success', position: 'top'});
            }
        } catch (error) {
            console.error('Error update settings:', error);
            toast.open({message: errorMessage(error, 'Lưu thất bại vui lòng thử lại.'), type: 'error', position: 'top'});
        }
    },
    async uploadLogo({ commit }, { key, file, toast }) {
        try {
            const formData = new FormData();
            formData.append('key', key);
            formData.append('logo', file);
            const response = await api.post(`${API_ENDPOINT.API_ADMIN.SETTINGS}/logo`, formData, {timeout: 30000});
            if (response.data.success) {
                commit('MERGE_SETTINGS', {[key]: response.data.data});
                toast.open({message: response.data.message, type: 'success', position: 'top'});
            }
        } catch (error) {
            console.error('Error upload logo:', error);
            toast.open({message: errorMessage(error, 'Tải logo thất bại vui lòng thử lại.'), type: 'error', position: 'top'});
        }
    },
    async deleteLogo({ commit }, { key, toast }) {
        try {
            const response = await api.delete(`${API_ENDPOINT.API_ADMIN.SETTINGS}/logo/${key}`);
            if (response.data.success) {
                commit('REMOVE_SETTING', key);
                toast.open({message: response.data.message, type: 'success', position: 'top'});
            }
        } catch (error) {
            console.error('Error delete logo:', error);
            toast.open({message: 'Khôi phục logo thất bại vui lòng thử lại.', type: 'error', position: 'top'});
        }
    },
};

const getters = {
    settingsAll: (state) => state.settings,
    // Logo màu, dùng trên nền sáng (footer, trang đăng nhập...)
    logoMain: (state) => state.settings.logo_main || defaultLogoMain,
    // Logo trắng, dùng trên nền đỏ (header, sidebar admin). Chưa upload logo trắng mà đã có logo chính thì dùng logo chính
    logoWhite: (state) => state.settings.logo_white || state.settings.logo_main || defaultLogoWhite,
    // Logo riêng cho footer (nền trắng). Chưa upload thì dùng logo chính
    logoFooter: (state) => state.settings.logo_footer || state.settings.logo_main || defaultLogoFooter,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
