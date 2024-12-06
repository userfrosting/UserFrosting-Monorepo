/**
 * Interface for registration form
 *
 * This interface is used to define what the composable used to communicate with
 * the API expects as argument.
 */
export interface RegisterForm {
    first_name: string
    last_name: string
    email: string
    user_name: string
    password: string
    passwordc: string
    locale: string
    captcha: string
    spiderbro: string
}
