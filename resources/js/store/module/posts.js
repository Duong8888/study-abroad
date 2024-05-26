import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
const state = {
    post: [],
};

const mutations = {
    SET_POSTS(state, request) {
        state.post = request;
    },
};

const actions = {
    async fetchPost({ commit }) {
        try {
            const response = await api.get(API_ENDPOINT.API_ADMIN.POSTS);
            const posts = response.data;
            commit('SET_POSTS', posts);
        } catch (error) {
            console.error('Error fetching user:', error);
        }
    },
    async addPost({commit}, { data, toast }) {
        try {
            const response = await api.post(API_ENDPOINT.API_ADMIN.POSTS,data);
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
    }
};

const getters = {
    postsAll: (state) => state.post,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
