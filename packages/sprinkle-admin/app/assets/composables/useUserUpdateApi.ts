import { ref } from 'vue'
import axios from 'axios'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { AlertInterface, ApiResponse } from '@userfrosting/sprinkle-core/interfaces'

// TODO : Add validation
// 'schema://requests/user/edit-field.yaml'

/**
 * API Composable
 */
export function useUserUpdateApi() {
    const apiLoading = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function submitUserUpdate(user_name: string, fieldName: string, formData: any) {
        apiLoading.value = true
        apiError.value = null

        return axios
            .put<ApiResponse>('/api/users/u/' + user_name + '/' + fieldName, formData)
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

    return { submitUserUpdate, apiLoading, apiError }
}
