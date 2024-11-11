import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/types'

/**
 * Interfaces - What the API expects and what it returns
 */
interface GroupCreateForm {
    slug: string
    name: string
    description: string
    icon: string
}

interface GroupCreateResponse {
    success: boolean
    message: string
    group: GroupCreateForm
}

// TODO : Add validation
// 'schema://requests/group/create.yaml'

/**
 * API Composable
 */
export function useGroupCreateApi() {
    const apiLoading = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function submitGroupCreate(data: GroupCreateForm) {
        apiLoading.value = true
        apiError.value = null
        return axios
            .post<GroupCreateResponse>('/api/groups', data)
            .then((response) => {
                return {
                    success: response.data.success,
                    message: response.data.message,
                    group: response.data.group
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

    return { submitGroupCreate, apiLoading, apiError }
}

export type { GroupCreateForm, GroupCreateResponse }
