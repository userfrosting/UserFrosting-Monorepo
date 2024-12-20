/**
 * Register every views globally
 * See : https://vuejs.org/guide/components/registration
 */
import type { App } from 'vue'
import { PageLogin, PageRegister, PageForgotPassword, PageResendVerification } from '../views'

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
