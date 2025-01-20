import { ref } from 'vue'
import axios from 'axios'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { ApiResponse, AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { ProfileEditRequest } from '../interfaces'

// TODO : Add validation
// 'schema://requests/profile-settings.yaml'

/**
 * API Composable
 */
export function useUserProfileEditApi() {
    const apiLoading = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function submitProfileEdit(data: ProfileEditRequest) {
        apiLoading.value = true
        apiError.value = null
        return axios
            .post<ApiResponse>('/account/settings/profile', data)
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

    return { submitProfileEdit, apiLoading, apiError }
}
