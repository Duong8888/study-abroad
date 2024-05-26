import axios from 'axios';
import {API_ENDPOINT} from "../store/api-endpoint.js";
import router from "@/router/index.js";
const api = axios.create({
    baseURL: API_ENDPOINT.BASE_URL,
    timeout: 5000
});

api.interceptors.request.use(
    config => {
        const token = localStorage.getItem('authToken');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

api.interceptors.response.use(
    response => response,
    error => {
        if (error.response && (error.response.status === 401 || error.response.status === 403)) {
            localStorage.removeItem('authToken');
            router.push({ name: 'Login' });
        }
        return Promise.reject(error);
    }
);


export default api;
