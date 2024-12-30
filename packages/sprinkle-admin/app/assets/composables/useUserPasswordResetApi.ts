import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { UserDeleteResponse } from '../interfaces'

/**
 * API Composable
 */
export function useUserPasswordResetApi() {
    // Form data
    const loadingState = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function passwordReset(user_name: string) {
        loadingState.value = true
        apiError.value = null
        return axios
            .post<UserDeleteResponse>('/api/users/u/' + user_name + '/password-reset')
            .then((response) => {
                return {
                    message: response.data.message
                }
            })
            .catch((err) => {
                apiError.value = {
                    ...{
                        description: 'An error as occurred',
                        style: Severity.Danger,
                        closeBtn: true
                    },
                    ...err.response.data
                }

                throw apiError.value
            })
            .finally(() => {
                loadingState.value = false
            })
    }

    return { loadingState, apiError, passwordReset }
}
