import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import { useConfigStore } from '@userfrosting/sprinkle-core/stores'
import type { UserInterface, RegisterForm } from '../interfaces'

// TODO : Refactor as a true composable

// Variables
function getDefaultForm(): RegisterForm {
    const config = useConfigStore()
    return {
        first_name: '',
        last_name: '',
        email: '',
        user_name: '',
        password: '',
        passwordc: '',
        locale: config.get('site.registration.user_defaults.locale', 'en_US'),
        captcha: '',
        spiderbro: 'http://'
    }
}

function getAvailableLocales(): string[] {
    return useConfigStore().get('locales.available')
}

function getCaptchaUrl(): string {
    return '/account/captcha' // TODO : Add captcha path to config
}

// Actions
async function doRegister(form: RegisterForm) {
    return axios
        .post<UserInterface>('/account/register', form)
        .then((response) => {
            return response.data
        })
        .catch((err) => {
            const error: AlertInterface = {
                ...{
                    description: 'An error as occurred',
                    style: Severity.Danger,
                    closeBtn: true
                },
                ...err.response.data
            }

            throw error
        })
}

export { getDefaultForm, getAvailableLocales, getCaptchaUrl, doRegister }
