import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';

const state = {
    testimonialList: [],
    statusBtn: false,
};

const mutations = {
    SET_TESTIMONIAL_LIST(state, request) {
        state.testimonialList = request;
    },
    SET_STATUS_BTN(state, value) {
        state.statusBtn = value;
    },
};

const showError = (toast, error) => {
    toast.open({
        message: error?.response?.data?.message || 'Error! An error occurred. Please try again later',
        type: 'error',
        position: 'top'
    });
};

const actions = {
    async fetchTestimonial({commit}) {
        try {
            const response = await api.get(API_ENDPOINT.API_ADMIN.TESTIMONIAL);
            commit('SET_TESTIMONIAL_LIST', response.data);
        } catch (error) {
            console.error('Error fetching testimonial:', error);
        }
    },
    async addTestimonial({commit}, {data, toast}) {
        commit('SET_STATUS_BTN', true);
        try {
            const response = await api.post(API_ENDPOINT.API_ADMIN.TESTIMONIAL, data);
            if (response.data.success) {
                toast.open({message: response.data.message, type: 'success', position: 'top'});
                return true;
            }
        } catch (error) {
            console.error('Error add testimonial:', error);
            showError(toast, error);
        } finally {
            commit('SET_STATUS_BTN', false);
        }
        return false;
    },
    async updateTestimonial({commit}, {id, data, toast}) {
        commit('SET_STATUS_BTN', true);
        try {
            const response = await api.post(`${API_ENDPOINT.API_ADMIN.TESTIMONIAL}/${id}`, data);
            if (response.data.success) {
                toast.open({message: response.data.message, type: 'success', position: 'top'});
                return true;
            }
        } catch (error) {
            console.error('Error update testimonial:', error);
            showError(toast, error);
        } finally {
            commit('SET_STATUS_BTN', false);
        }
        return false;
    },
    async deleteTestimonial(_, {id, toast}) {
        try {
            const response = await api.delete(`${API_ENDPOINT.API_ADMIN.TESTIMONIAL}/${id}`);
            if (response.data.success) {
                toast.open({message: response.data.message, type: 'success', position: 'top'});
            }
        } catch (error) {
            console.error('Error delete testimonial:', error);
            showError(toast, error);
        }
    },
};

const getters = {
    testimonialAll: (state) => state.testimonialList,
    statusBtn: (state) => state.statusBtn,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
