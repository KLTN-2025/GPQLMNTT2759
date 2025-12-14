import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "./plugins/echo";
import Default from "./layout/Admin/wrapper/index.vue";
import Client from "./layout/Client/wrapper/index.vue";
import Blank from "./layout/Blank/wrapper/index.vue";
import Teacher from "./layout/Teachers/wrapper/index.vue";
import Toaster from "@meforma/vue-toaster";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { aliases, mdi } from "vuetify/iconsets/mdi";

// Tạo Vuetify instance
const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: "mdi",
    aliases,
    sets: { mdi },
  },
});

const app = createApp(App);

app.use(router);
app.use(Toaster, {
  position: "top-right",
});
app.use(vuetify);
app.component("default-layout", Default);
app.component("client-layout", Client);
app.component("blank-layout", Blank);
app.component("teacher-layout", Teacher);

app.mount("#app");
