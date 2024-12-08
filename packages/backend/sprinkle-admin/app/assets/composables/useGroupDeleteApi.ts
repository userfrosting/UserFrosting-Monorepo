import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { GroupDeleteResponse } from '../interfaces'

/**
 * API Composable
 */
export function useGroupDeleteApi() {
    // Form data
    const loadingState = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function deleteGroup(slug: string) {
        loadingState.value = true
        apiError.value = null
        return axios
            .delete<GroupDeleteResponse>('/api/groups/g/' + slug)
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

    return { loadingState, apiError, deleteGroup }
}
