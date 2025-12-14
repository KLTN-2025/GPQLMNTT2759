import axios from "axios";
const apiUrl = "http://127.0.0.1:8000/api/";

export default {
    getHeader(skipContentType = false) {
        let token = window.localStorage.getItem('token_phu_huynh');
        let headers = {
            'Accept': 'application/json'
        };
        // Only add Content-Type if not FormData
        if (!skipContentType) {
            headers['Content-Type'] = 'application/json';
        }
        if (token != null) {
            headers['Authorization'] = 'Bearer ' + token;
        }
        return headers;
    },
    get(url) {
        return axios.get(apiUrl + url, { headers: this.getHeader() });
    },
    post(url, data) {
        // If data is FormData, let axios set Content-Type automatically with boundary
        const isFormData = data instanceof FormData;
        return axios.post(apiUrl + url, data, { headers: this.getHeader(isFormData) });
    },
    delete(url) {
        return axios.delete(apiUrl + url, { headers: this.getHeader() });
    },
    put(url, data) {
        return axios.put(apiUrl + url, data, { headers: this.getHeader() });
    },
}
