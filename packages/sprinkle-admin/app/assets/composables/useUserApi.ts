import { ref, watch } from 'vue'
import axios from 'axios'
import { type AlertInterface, Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { UserApi } from '../interfaces'

/**
 * API Composable
 */
export function useUserApi(route: any) {
    const loading = ref(false)
    const error = ref<AlertInterface | null>()
    const user = ref<UserApi>({
        id: 0,
        user_name: '',
        first_name: '',
        last_name: '',
        full_name: '',
        email: '',
        avatar: '',
        flag_enabled: false,
        flag_verified: false,
        group_id: null,
        locale: '',
        created_at: '',
        updated_at: '',
        deleted_at: null,
        locale_name: '',
        group: null
    })

    async function fetchApi() {
        loading.value = true
        error.value = null

        await axios
            .get<UserApi>('/api/users/u/' + route.params.user_name)
            .then((response) => {
                user.value = response.data
            })
            .catch((err) => {
                error.value = {
                    ...{
                        description: 'An error as occurred',
                        style: Severity.Danger
                    },
                    ...err.response.data
                }
            })
            .finally(() => {
                loading.value = false
            })
    }

    watch(
        () => route.params.user_name,
        () => {
            fetchApi()
        },
        { immediate: true }
    )

    return { user, error, loading, fetchApi }
}
