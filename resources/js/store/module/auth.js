const state = {
    token: localStorage.getItem('authToken') || '',
};

const mutations = {
    SET_TOKEN(state, token) {
        state.token = token;
    },
    CLEAR_TOKEN(state) {
        state.token = '';
    },
};

const actions = {
    login({ commit }, token) {
        commit('SET_TOKEN', token);
        localStorage.setItem('token', token);
    },
    logout({ commit }) {
        commit('CLEAR_TOKEN');
        localStorage.removeItem('token');
    },
    checkToken({ state, dispatch }) {
        if (!state.token) {
            dispatch('logout');
        }
    },
};

const getters = {
    isAuthenticated: (state) => !!state.token,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
};
