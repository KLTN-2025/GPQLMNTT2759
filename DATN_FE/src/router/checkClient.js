import axios from "axios";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default function (to, from, next) {
  var token = localStorage.getItem("token_phu_huynh");
  axios
    .get("http://127.0.0.1:8000/api/client/check-token", {
      headers: {
        Authorization: "Bearer " + token,
      },
    })
    .then((res) => {
      if (res.data.status) {
        localStorage.setItem("ho_ten_phu_huynh", res.data.ho_ten);
        localStorage.setItem("avatar_phu_huynh", res.data.avatar);
        localStorage.setItem("email_phu_huynh", res.data.email);
        next();
      } else {
        next("/login");
        toaster.error(res.data.message);
      }
    });
}
