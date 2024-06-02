import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';
import router from '../../router';
const state = {
    teamList: [],
};

const mutations = {
    SET_TEAM_LIST(state, request) {
        state.teamList = request;
    },
};

const actions = {
    async fetchTeam({ commit }, sort = null) {
        try {
            const params = {};
            if (sort !== null) {
                params.sort = sort;
            }
            const response = await api.get(API_ENDPOINT.API_ADMIN.TEAM,{ params });
            const team = response.data;
            commit('SET_TEAM_LIST', team);
        } catch (error) {
            console.error('Error fetching user:', error);
        }
    },
    async addTeam({commit}, { data, toast }) {
        try {
            const response = await api.post(API_ENDPOINT.API_ADMIN.TEAM,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                await router.push({name: 'Team'});
            }
        } catch (error) {
            console.error('Error add team:', error);
            toast.open({
                message: 'Error! An error occurred. Please try again later',
                type: 'error',
                position: 'top'
            });
        }
    },

    async updateTeam({commit}, { data, toast }) {
        try {
            const response = await api.post(`${API_ENDPOINT.API_ADMIN.TEAM}/${data.get('id')}`,data);
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
                await router.push({name: 'Team'});
            }
        } catch (error) {
            console.error('Error add team:', error);
            toast.open({
                message: 'Error! An error occurred. Please try again later',
                type: 'error',
                position: 'top'
            });
        }
    },

    async deleteTeam({commit}, { id, toast }) {
        try {
            const response = await api.delete(`${API_ENDPOINT.API_ADMIN.TEAM}/${id}`);
            const team = response.data;
            if(response.data.success){
                toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top'
                });
            }
        } catch (error) {
            console.error('Error add team:', error);
        }
    },
};

const getters = {
    teamAll: (state) => state.teamList,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
