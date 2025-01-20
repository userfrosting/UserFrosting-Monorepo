/**
 * Register every admin components & views globally
 * See : https://vuejs.org/guide/components/registration
 */
import type { App } from 'vue'
import {
    PageLogin,
    PageRegister,
    PageForgotPassword,
    PageResendVerification,
    PageUserSettings,
    PageUserSettingsProfile,
    PageUserSettingsPassword,
    PageUserSettingsEmail
} from '../views/Account'
import {
    FormLogin,
    FormRegister,
    FormForgotPassword,
    FormResendVerification
} from '../components/Pages/Account'

export default {
    install: (app: App) => {
        app.component('UFFormLogin', FormLogin)
            .component('UFFormRegister', FormRegister)
            .component('UFFormForgotPassword', FormForgotPassword)
            .component('UFFormResendVerification', FormResendVerification)
            .component('UFPageLogin', PageLogin)
            .component('UFPageRegister', PageRegister)
            .component('UFPageForgotPassword', PageForgotPassword)
            .component('UFPageResendVerification', PageResendVerification)
            .component('UFPageUserSettings', PageUserSettings)
            .component('UFPageUserSettingsProfile', PageUserSettingsProfile)
            .component('UFPageUserSettingsPassword', PageUserSettingsPassword)
            .component('UFPageUserSettingsEmail', PageUserSettingsEmail)
    }
}

declare module 'vue' {
    export interface GlobalComponents {
        UFFormLogin: typeof FormLogin
        UFFormRegister: typeof FormRegister
        UFFormForgotPassword: typeof FormForgotPassword
        UFFormResendVerification: typeof FormResendVerification
        UFPageLogin: typeof PageLogin
        UFPageRegister: typeof PageRegister
        UFPageForgotPassword: typeof PageForgotPassword
        UFPageResendVerification: typeof PageResendVerification
        UFPageUserSettings: typeof PageUserSettings
        UFPageUserSettingsProfile: typeof PageUserSettingsProfile
        UFPageUserSettingsPassword: typeof PageUserSettingsPassword
        UFPageUserSettingsEmail: typeof PageUserSettingsEmail
    }
}
