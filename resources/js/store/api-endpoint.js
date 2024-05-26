const API =  '/api';
const ADMIN =  '/admin';
export const API_ENDPOINT = {
    BASE_URL: `${API}${ADMIN}`,
    API_ADMIN: {
        LOGIN : `/login`,
        REQUEST : `/request-list`,
    },
    API_USER: {
        SEND_REQUEST : `${API}/consultation-request`,
    },
}
