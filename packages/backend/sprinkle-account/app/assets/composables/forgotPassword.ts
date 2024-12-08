/**
 * Forgot password API
 *
 * Fetch the forgot password API. This will send an email to the user with
 * instructions to reset their password.
 *
 * @param {String} email - The email of the user to send the email to.
 *
 * @return {Promise} - The response of the API. Throw an error (AlertInterface)
 * if the request failed. Return a success message (AlertInterface) if the
 * request is a success.
 */
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'

export async function forgotPassword(email: String) {
    return axios
        .post<{ message: string }>('/account/forgot-password', { email: email })
        .then((response): AlertInterface => {
            return {
                description: response.data.message,
                style: Severity.Success,
                closeBtn: true
            }
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
