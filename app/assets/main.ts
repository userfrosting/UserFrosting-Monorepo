/** Create App */
import { createApp } from 'vue'
import App from './App.vue'
const app = createApp(App)

/** Setup Pinia */
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)
app.use(pinia)

/** Setup Theme */
import '@userfrosting/theme-pink-cupcake/less/main.less'
import PinkCupcake from '@userfrosting/theme-pink-cupcake'
app.use(PinkCupcake)

/** Setup Router */
import router from './router'
app.use(router)

// Done
app.mount('#app')
