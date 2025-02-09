/// <reference types="vite/client" />
/// <reference types="@userfrosting/sprinkle-core" />

import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)