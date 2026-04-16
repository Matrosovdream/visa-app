import axios from 'axios';

// Session cookie auth + CSRF token from the Blade shell's meta tag.
function csrf() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

const api = axios.create({
    baseURL: '/api/v1/admin',
    withCredentials: true,
    headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});

api.interceptors.request.use((config) => {
    const method = (config.method || '').toLowerCase();
    if (['post', 'put', 'patch', 'delete'].includes(method)) {
        config.headers['X-CSRF-TOKEN'] = csrf();
    }
    return config;
});

api.interceptors.response.use(
    (res) => res,
    (err) => {
        const status = err.response?.status;
        if (status === 401 || status === 419) {
            // Session expired — bounce to the Blade login.
            window.location.href = '/backend-login?redirect=' + encodeURIComponent(window.location.pathname);
        }
        return Promise.reject(err);
    }
);

export default api;
