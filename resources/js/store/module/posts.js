import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';

// Gọi API lưu bài viết, hiện thông báo và trả về true nếu thành công
async function savePost(request, toast) {
    try {
        const response = await request();
        toast.open({
            message: response.data.message,
            type: response.data.success ? 'success' : 'error',
            position: 'top'
        });
        return !!response.data.success;
    } catch (error) {
        console.error('Error save posts:', error);
        toast.open({
            message: error?.response?.data?.message || 'Error! An error occurred. Please try again later',
            type: 'error',
            position: 'top'
        });
        return false;
    }
}
const state = {
    postsList: [],
    posts:[],
};

const mutations = {
    SET_POSTS_LIST(state, request) {
        state.postsList = request;
    },
    SET_POSTS(state, request) {
        state.posts = request;
    },
};

const actions = {
    async fetchPost({ commit }, sort = null) {
        try {
            const params = {};
            if (sort !== null) {
                if(sort === 'limit'){
                    params.limit = sort;
                }else {
                    params.sort = JSON.stringify(sort);
                }
            }
            const response = await api.get(API_ENDPOINT.API_ADMIN.POSTS,{ params });
            const posts = response.data;
            commit('SET_POSTS_LIST', posts);
        } catch (error) {
            console.error('Error fetching user:', error);
        }
    },
    async addPost(_, { data, toast }) {
        return savePost(() => api.post(API_ENDPOINT.API_ADMIN.POSTS, data), toast);
    },

    async updatePost(_, { data, toast }) {
        return savePost(() => api.put(`${API_ENDPOINT.API_ADMIN.POSTS}/${data.id}`, data), toast);
    },

    clearPost({commit}) {
        commit('SET_POSTS', []);
    },

    async getOnePost({commit}, slug) {
        try {
            const response = await api.get(`${API_ENDPOINT.API_ADMIN.POSTS}/${slug}/edit`);
            const posts = response.data;
            commit('SET_POSTS', posts);
        } catch (error) {
            console.error('Error add posts:', error);
        }
    },

    async deletePosts({commit}, { id, toast }) {
        try {
            const response = await api.delete(`${API_ENDPOINT.API_ADMIN.POSTS}/${id}`);
            const posts = response.data;
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
    postsAll: (state) => state.postsList,
    posts:(state) => state.posts,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
