import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { RoleDeleteResponse } from '../interfaces'

/**
 * API Composable
 */
export function useRoleDeleteApi() {
    // Form data
    const loadingState = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function deleteRole(slug: string) {
        loadingState.value = true
        apiError.value = null
        return axios
            .delete<RoleDeleteResponse>('/api/roles/r/' + slug)
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
                loadingState.value = false
            })
    }

    return { loadingState, apiError, deleteRole }
}
