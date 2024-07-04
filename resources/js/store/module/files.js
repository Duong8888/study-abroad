import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
import router from "@/router/index.js";
const state = {
    files: [],
};

const mutations = {
    SET_FILES(state, request) {
        state.files = request;
    },
};

const actions = {
    async fetchFiles({ commit }) {
        try {
            const response = await api.get(API_ENDPOINT.API_ADMIN.FILES);
            const files = response.data;
            commit('SET_FILES', files);
        } catch (error) {
            console.error('Error fetching files:', error);
        }
    },
    async deleteFiles({commit}, { fileName, toast }) {
        try {
            const response = await api.delete(`${API_ENDPOINT.API_ADMIN.FILES}/${fileName}`);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
            }
        } catch (error) {
            console.error('Error add files:', error);
        }
    },
};

const getters = {
    filesAll: (state) => state.files,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
