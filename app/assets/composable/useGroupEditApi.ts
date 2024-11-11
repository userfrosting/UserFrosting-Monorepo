import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/types'

/**
 * Interfaces - What the API expects and what it returns
 */
interface GroupEditForm {
    slug: string
    name: string
    description: string
    icon: string
}

interface GroupEditResponse {
    success: boolean
    message: string
    group: GroupEditForm
}

// TODO : Add validation
// 'schema://requests/group/edit-info.yaml'

/**
 * API Composable
 */
export function useGroupEditApi() {
    const apiLoading = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function submitGroupEdit(slug: string, data: GroupEditForm) {
        apiLoading.value = true
        apiError.value = null
        return axios
            .put<GroupEditResponse>('/api/groups/g/' + slug, data)
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

    return { submitGroupEdit, apiLoading, apiError }
}

export type { GroupEditForm, GroupEditResponse }
