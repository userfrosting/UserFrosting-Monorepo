import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { ApiResponse } from '../interfaces'

// TODO : Add validation
// 'schema://requests/role/edit-field.yaml'

/**
 * API used to update role.
 *
 * This API is tied to the `RoleUpdateFieldAction` API, accessed at the
 * GET `/api/roles/r/{slug}/{field}` endpoint.
 *
 * This composable can be used to update {field} for a specific role.
 */
export function useRoleUpdateApi() {
    const apiLoading = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function submitRoleUpdate(slug: string, fieldName: string, formData: any) {
        apiLoading.value = true
        apiError.value = null

        return axios
            .put<ApiResponse>('/api/roles/r/' + slug + '/' + fieldName, formData)
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

    return { submitRoleUpdate, apiLoading, apiError }
}
