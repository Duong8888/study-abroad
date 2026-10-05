import {API_ENDPOINT} from "../api-endpoint.js";
import api from '../../utils/axios.js';

const REQUEST_URL = API_ENDPOINT.API_ADMIN.REQUEST;

const state = {
    list: {data: [], total: 0, current_page: 1, last_page: 1, per_page: 20, from: 0, to: 0},
    stats: null,
    loading: false,
};

const mutations = {
    SET_LIST(state, list) {
        state.list = list;
    },
    SET_STATS(state, stats) {
        state.stats = stats;
    },
    SET_LOADING(state, value) {
        state.loading = value;
    },
    REPLACE_ITEM(state, item) {
        const index = state.list.data.findIndex(row => row.id === item.id);
        if (index !== -1) state.list.data.splice(index, 1, item);
    },
};

function notify(toast, response) {
    toast?.open({message: response.data.message, type: response.data.success ? 'success' : 'error', position: 'top'});
}

function notifyError(toast, error) {
    toast?.open({
        message: error?.response?.data?.message || 'Có lỗi xảy ra, vui lòng thử lại.',
        type: 'error',
        position: 'top',
    });
}

const actions = {
    async fetchRequests({commit}, params = {}) {
        commit('SET_LOADING', true);
        try {
            const response = await api.get(REQUEST_URL, {params});
            commit('SET_LIST', response.data);
        } catch (error) {
            console.error('Error fetching requests:', error);
        } finally {
            commit('SET_LOADING', false);
        }
    },
    async fetchStats({commit}) {
        try {
            const response = await api.get(`${REQUEST_URL}/stats`);
            commit('SET_STATS', response.data);
        } catch (error) {
            console.error('Error fetching request stats:', error);
        }
    },
    // data: {status?, note?}
    async updateRequest({commit}, {id, data, toast}) {
        try {
            const response = await api.put(`${REQUEST_URL}/${id}`, data);
            if (response.data.success) commit('REPLACE_ITEM', response.data.data);
            notify(toast, response);
            return response.data.success;
        } catch (error) {
            notifyError(toast, error);
            return false;
        }
    },
    async bulkUpdate(_, {ids, status, toast}) {
        try {
            const response = await api.post(`${REQUEST_URL}/bulk-update`, {ids, status});
            notify(toast, response);
            return response.data.success;
        } catch (error) {
            notifyError(toast, error);
            return false;
        }
    },
    async deleteRequests(_, {ids, toast}) {
        try {
            const response = ids.length === 1
                ? await api.delete(`${REQUEST_URL}/${ids[0]}`)
                : await api.post(`${REQUEST_URL}/bulk-delete`, {ids});
            notify(toast, response);
            return response.data.success;
        } catch (error) {
            notifyError(toast, error);
            return false;
        }
    },
    // Tải file CSV theo bộ lọc hiện tại
    async exportRequests(_, {params, toast}) {
        try {
            const response = await api.get(`${REQUEST_URL}/export`, {params, responseType: 'blob', timeout: 60000});
            const name = (response.headers['content-disposition'] || '').match(/filename="?([^"]+)"?/)?.[1]
                || 'yeu-cau-tu-van.csv';
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(response.data);
            link.download = name;
            link.click();
            setTimeout(() => window.URL.revokeObjectURL(link.href), 1000);
        } catch (error) {
            notifyError(toast, error);
        }
    },
};

const getters = {
    requestList: (state) => state.list,
    requestStats: (state) => state.stats,
    requestLoading: (state) => state.loading,
    newRequestCount: (state) => state.stats?.status?.[0] ?? 0,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
