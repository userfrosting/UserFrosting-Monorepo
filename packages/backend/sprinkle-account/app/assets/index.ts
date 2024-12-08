import type { App } from 'vue'
import type { Router } from 'vue-router'
import { useAuthStore } from './stores/auth'
import { useAuthGuard } from './guards/authGuard'

/* Install plugins */
export default {
    install: (app: App, options: { router: Router }) => {
        // Run auth check on load
        const auth = useAuthStore()
        auth.check()

        // Setup router guards
        const { router } = options
        useAuthGuard(router)
    }
}
