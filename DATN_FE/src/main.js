import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import ClientLayout from './layout/Client/wrapper/index.vue'
import BlankLayout from './layout/Blank/wrapper/index.vue'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'

const vuetify = createVuetify({
  components,
  directives,
  icons: { defaultSet: 'mdi' }
})

const app = createApp(App)

app.use(router)
app.use(vuetify)
app.component('client-layout', ClientLayout)
app.component('blank-layout', BlankLayout)
app.component('default-layout', ClientLayout)

app.mount('#app')