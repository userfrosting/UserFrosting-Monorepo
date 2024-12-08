import { ref, watch } from 'vue'
import axios from 'axios'
import { type AlertInterface, Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { GroupApi } from '../interfaces'

/**
 * API Composable
 */
export function useGroupApi(route: any) {
    const loading = ref(false)
    const error = ref<AlertInterface | null>()
    const group = ref<GroupApi>({
        id: 0,
        name: '',
        slug: '',
        description: '',
        icon: '',
        created_at: '',
        updated_at: '',
        deleted_at: null,
        users_count: 0
    })

    async function fetchApi() {
        loading.value = true
        error.value = null

        await axios
            .get<GroupApi>('/api/groups/g/' + route.params.slug)
            .then((response) => {
                group.value = response.data
            })
            .catch((err) => {
                error.value = {
                    ...{
                        description: 'An error as occurred',
                        style: Severity.Danger,
                        closeBtn: true
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

    return { group, error, loading, fetchApi }
}
