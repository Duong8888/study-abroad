const API =  '/api';
const ADMIN =  '/admin';
export const API_ENDPOINT = {
    API_ADMIN: {
        LOGIN : `${API}${ADMIN}/login`,
        GET_REQUEST : `${API}${ADMIN}/request-list`,
    },
    API_USER: {
        SEND_REQUEST : `${API}/consultation-request`,
    },
}
