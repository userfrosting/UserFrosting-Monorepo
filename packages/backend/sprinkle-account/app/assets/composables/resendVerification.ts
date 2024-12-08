/**
 * Resend Verification API
 *
 * Fetch the resend verification API. This will send an email to the user with
 * instructions to verify their email.
 *
 * @param {String} email - The email of the user to send the email to.
 *
 * @return {Promise} - The response of the API. Throw an error (AlertInterface)
 * if the request failed. Return a success message (AlertInterface) if the
 * request is a success.
 */
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'

export async function resendVerification(email: String) {
    return axios
        .post<{ message: string }>('/account/resend-verification', { email: email })
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
