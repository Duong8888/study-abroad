const API =  '/api';
const ADMIN =  '/admin';
export const API_ENDPOINT = {
    BASE_URL: `${API}${ADMIN}`,
    API_ADMIN: {
        LOGIN : `/login`,
        REQUEST : `/request-list`,
        POSTS : `/posts`,
        CATEGORY : `/category`,
        BANNER : `/banner`,
    },
    API_USER: {
        SEND_REQUEST : `${API}/consultation-request`,
    },
}
