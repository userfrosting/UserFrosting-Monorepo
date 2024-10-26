import { ref, watch } from 'vue'
import axios from 'axios'
import type { RoleInterface } from '@userfrosting/sprinkle-account/types'
import { type AlertInterface, Severity } from '@userfrosting/sprinkle-core/types'

/**
 * Create RoleApi interface, based on RoleInterface
 */
interface RoleApi extends RoleInterface {
    users_count: number
}

/**
 * API Composable
 */
export function useRoleApi(route: any) {
    const loading = ref(false)
    const error = ref<AlertInterface | null>()
    const role = ref<RoleApi>({
        id: 0,
        slug: '',
        name: '',
        description: '',
        created_at: '',
        updated_at: '',
        deleted_at: null,
        users_count: 0
    })

    async function fetchApi() {
        loading.value = true
        error.value = null

        await axios
            .get<RoleApi>('/api/roles/r/' + route.params.slug)
            .then((response) => {
                role.value = response.data
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
        () => route.params.slug,
        () => {
            fetchApi()
        },
        { immediate: true }
    )

    return { role, error, loading }
}

export type { RoleApi }
