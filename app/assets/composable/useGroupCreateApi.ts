import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/types'

// Interfaces
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
    const defaultData: GroupCreateForm = {
        slug: '',
        name: '',
        description: '',
        icon: 'users'
    }

    // Form data
    const formData = ref<GroupCreateForm>({ ...defaultData })
    const loadingState = ref<Boolean>(false)
    const formError = ref<AlertInterface | null>(null)

    async function sendForm() {
        loadingState.value = true
        formError.value = null
        return axios
            .post<GroupCreateResponse>('/api/groups', formData.value)
            .then((response) => {
                return {
                    success: response.data.success,
                    message: response.data.message,
                    group: response.data.group
                }
            })
            .catch((err) => {
                formError.value = {
                    ...{
                        description: 'An error as occurred',
                        style: Severity.Danger,
                        closeBtn: true
                    },
                    ...err.response.data
                }

                throw formError.value
            })
            .finally(() => {
                loadingState.value = false
            })
    }

    function resetForm() {
        formData.value = { ...defaultData }
        loadingState.value = false
        formError.value = null
    }

    return { sendForm, resetForm, formData, loadingState, formError }
}

export type { GroupCreateForm, GroupCreateResponse }
