import { ref } from 'vue'
import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import type { UserCreateRequest, UserCreateResponse } from '../interfaces'

// TODO : Add validation
// 'schema://requests/user/create.yaml'

/**
 * API Composable
 */
export function useUserCreateApi() {
    const apiLoading = ref<Boolean>(false)
    const apiError = ref<AlertInterface | null>(null)

    async function submitUserCreate(data: UserCreateRequest) {
        apiLoading.value = true
        apiError.value = null
        return axios
            .post<UserCreateResponse>('/api/users', data)
            .then((response) => {
                return {
                    success: response.data.success,
                    message: response.data.message,
                    user: response.data.user
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

    return { submitUserCreate, apiLoading, apiError }
}
