import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { UserDeleteResponse } from '../interfaces'

/**
 * API Composable
 */
export function useUserDeleteApi() {
    // Form data
    const loadingState = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function deleteUser(user_name: string) {
        loadingState.value = true
        apiError.value = null
        return axios
            .delete<UserDeleteResponse>('/api/users/u/' + user_name)
            .then((response) => {
                return {
                    success: response.data.success,
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

    return { loadingState, apiError, deleteUser }
}
