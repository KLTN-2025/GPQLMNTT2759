import axios from "axios";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default function (to, from, next) {
    var token = localStorage.getItem('token_giao_vien');
    axios
        .get("http://127.0.0.1:8000/api/teacher/check-token", {
            headers: {
                Authorization: "Bearer " + token,
            },
        })
        .then((res) => {
            if (res.data.status) {
                localStorage.setItem("ho_ten_giao_vien", res.data.ho_va_ten);
                next();
            } else {
                next("/teacher/login");
                toaster.error(res.data.message);
            }
        });
}
