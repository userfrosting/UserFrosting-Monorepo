import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { RoleEditRequest, RoleEditResponse } from '../interfaces'

// TODO : Add validation
// 'schema://requests/role/edit-info.yaml'

/**
 * API Composable
 */
export function useRoleEditApi() {
    const apiLoading = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function submitRoleEdit(slug: string, data: RoleEditRequest) {
        apiLoading.value = true
        apiError.value = null
        return axios
            .put<RoleEditResponse>('/api/roles/r/' + slug, data)
            .then((response) => {
                return response.data
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

    return { submitRoleEdit, apiLoading, apiError }
}
