import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { ApiResponse } from '../interfaces'

// TODO : Add validation
// 'schema://requests/user/edit-field.yaml'

/**
 * API Composable
 */
export function useUserUpdateApi() {
    const apiLoading = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function submitUserUpdate(user_name: string, fieldName: string, fieldValue: any) {
        apiLoading.value = true
        apiError.value = null

        // Assign the field name and value to the payload
        const payload: Record<string, any> = {}
        payload[fieldName] = fieldValue

        return axios
            .put<ApiResponse>('/api/users/u/' + user_name + '/' + fieldName, payload)
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
