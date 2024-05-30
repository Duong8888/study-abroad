import router from "@/router/index.js";
import api from "@/utils/axios.js";
import {API_ENDPOINT} from "@/store/api-endpoint.js";

const state = {
    token: localStorage.getItem('authToken') || '',
    // userId: [],
};

const mutations = {
    SET_TOKEN(state, value) {
        state.token = value.token;
        // state.userId = value.user_info.id;
    },
    CLEAR_TOKEN(state) {
        state.token = '';
    },
};

const actions = {
    async login({commit}, {data, toast}) {
        try {
            const response = await api.post(API_ENDPOINT.API_ADMIN.LOGIN, {
                email: data.email,
                password: data.password
            })
            const value = response.data;
            commit('SET_TOKEN', value);
            localStorage.setItem('authToken', value.token);
            toast.open({
                message: 'SMARTEDU xin chào admin.',
                type: 'success',
                position: 'top'
            });
            await router.push('/admin/request');
        } catch (e) {
            toast.open({
                message: 'Sai tên đăng nhập hoặc mật khẩu.',
                type: 'error',
                position: 'top'
            });
        }
    },
    async logout({commit}) {
        commit('CLEAR_TOKEN');
        localStorage.removeItem('authToken');
        await router.push({name: 'Login'});
    },
    checkToken({state, dispatch}) {
        if (!state.token) {
            dispatch('logout');
        }
    },
};

const getters = {
    isAuthenticated: (state) => !!state.token,
    authToken: (state) => state.token,
    // userId: (state) => state.userId,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
};
