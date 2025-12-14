import axios from "axios";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default function (to, from, next) {
  var token = localStorage.getItem("token_admin");
  axios
    .get("http://127.0.0.1:8000/api/admin/check-token", {
      headers: {
        Authorization: "Bearer " + token,
      },
    })
    .then((res) => {
      if (res.data.status) {
        localStorage.setItem("ho_ten_admin", res.data.ho_va_ten);
        localStorage.setItem("avatar_admin", res.data.avatar);
        localStorage.setItem("chuc_vu_admin", res.data.chuc_vu);
        localStorage.setItem("email_admin", res.data.email);
        next();
      } else {
        next("/admin/login");
        toaster.error(res.data.message);
      }
    });
}
