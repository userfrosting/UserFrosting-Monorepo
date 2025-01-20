import { ref } from 'vue'
import axios from 'axios'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { ApiResponse, AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { PasswordEditRequest } from '../interfaces'

// TODO : Add validation
// 'schema://requests/account-settings.yaml'

/**
 * API Composable
 */
export function useUserPasswordEditApi() {
    const apiLoading = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function submitPasswordEdit(data: PasswordEditRequest) {
        apiLoading.value = true
        apiError.value = null
        return axios
            .post<ApiResponse>('/account/settings', data)
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
                apiLoading.value = false
            })
    }

    return { submitPasswordEdit, apiLoading, apiError }
}
