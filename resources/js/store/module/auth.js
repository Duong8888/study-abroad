import router from "@/router/index.js";
import api from "@/utils/axios.js";
import {API_ENDPOINT} from "@/store/api-endpoint.js";

const state = {
    token: localStorage.getItem('authToken') || '',
    userInfo: [],
    statusBtn: false,
};

const mutations = {
    SET_TOKEN(state, value) {
        state.token = value.token;
        // state.userId = value.user_info.id;
    },
    SET_USER(state, value) {
        state.userInfo = value;
    },
    CLEAR_TOKEN(state) {
        state.token = '';
    },
    SET_STATUS_BTN(state, value) {
        state.statusBtn = value;
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
            await router.push({name:'Request'});
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

    async getUser({commit}) {
        try {
            const response = await api.get(API_ENDPOINT.API_ADMIN.PROFILE)
            const value = response.data;
            commit('SET_USER', value);
        } catch (e) {
            console.log(e);
        }
    },

    async updateUser({commit}, {data, toast}) {
        try {
            commit('SET_STATUS_BTN', true);
            const response = await api.post(API_ENDPOINT.API_ADMIN.PROFILE,data)
            const value = response.data;
            if(value.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                commit('SET_STATUS_BTN', false);
            }
        } catch (e) {
            console.log(e);
            commit('SET_STATUS_BTN', false);
        }
    },

    async changePass({commit}, {data, toast}) {
        try {
            commit('SET_STATUS_BTN', true);
            const response = await api.post(API_ENDPOINT.API_ADMIN.PROFILE+'/change-password',data)
            const value = response.data;
            if(value.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
            }else {
                toast.open({
                    message: response.data.message,
                    type: 'error',
                    position: 'top'
                });
            }
            commit('SET_STATUS_BTN', false);
        } catch (e) {
            console.log(e);
            commit('SET_STATUS_BTN', false);
        }
    },



};

const getters = {
    isAuthenticated: (state) => !!state.token,
    authToken: (state) => state.token,
    userInfo: (state) => state.userInfo,
    statusBtn: (state) => state.statusBtn,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
};
