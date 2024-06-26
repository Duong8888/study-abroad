import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
import router from '../../router';
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
    async addPost({commit}, { data, toast }) {
        try {
            const response = await api.post(API_ENDPOINT.API_ADMIN.POSTS,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                await router.push({name: 'Posts'});
            } else {
                toast.open({
                    message: response.data.message,
                    type: 'error',
                    position: 'top'
                });
            }
        } catch (error) {
            console.error('Error add posts:', error);
            toast.open({
                message: 'Error! An error occurred. Please try again later',
                type: 'error',
                position: 'top'
            });
        }
    },

    async updatePost({commit}, { data, toast }) {
        try {
            const response = await api.put(`${API_ENDPOINT.API_ADMIN.POSTS}/${data.id}`,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                await router.push({name: 'Posts'});
            } else {
                toast.open({
                    message: response.data.message,
                    type: 'error',
                    position: 'top'
                });
            }
        } catch (error) {
            console.error('Error add posts:', error);
            toast.open({
                message: 'Error! An error occurred. Please try again later',
                type: 'error',
                position: 'top'
            });
        }
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
