/**
 * Register every component globally
 * See : https://vuejs.org/guide/components/registration
 */
import type { App } from 'vue'

import PageLogin from './PageLogin.vue'
import PageRegister from './PageRegister.vue'
import PageForgotPassword from './PageForgotPassword.vue'
import PageResendVerification from './PageResendVerification.vue'

export { PageLogin, PageRegister, PageForgotPassword, PageResendVerification }

export default {
    install: (app: App) => {
        app.component('UFPageLogin', PageLogin)
            .component('UFPageRegister', PageRegister)
            .component('UFPageForgotPassword', PageForgotPassword)
            .component('UFPageResendVerification', PageResendVerification)
    }
}

declare module 'vue' {
    export interface GlobalComponents {
        UFPageLogin: typeof PageLogin
        UFPageRegister: typeof PageRegister
        UFPageForgotPassword: typeof PageForgotPassword
        UFPageResendVerification: typeof PageResendVerification
    }
}
