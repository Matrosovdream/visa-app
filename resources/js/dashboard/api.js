import axios from 'axios';

// The dashboard reuses the existing session cookie (the admin logs in via
// /backend-login which creates a Laravel session). We send credentials on
// every request and let the server auth middleware enforce access.
const api = axios.create({
    baseURL: '/api/v1/admin',
    withCredentials: true,
    headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});

api.interceptors.response.use(
    (res) => res,
    (err) => {
        if (err.response?.status === 401 || err.response?.status === 419) {
            // Session expired — send to backend login.
            window.location.href = '/backend-login?redirect=' + encodeURIComponent(window.location.pathname);
        }
        return Promise.reject(err);
    }
);

export default api;
