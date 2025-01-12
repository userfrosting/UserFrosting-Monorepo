import { ref, watch } from 'vue'
import axios from 'axios'
import { type AlertInterface, Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { PermissionApi } from '../interfaces'
import { usePageMeta } from '@userfrosting/sprinkle-core/composables'

/**
 * API Composable
 */
export function usePermissionApi(route: any) {
    const loading = ref(false)
    const error = ref<AlertInterface | null>()
    const permission = ref<PermissionApi>({
        id: 0,
        slug: '',
        name: '',
        conditions: '',
        description: '',
        created_at: '',
        updated_at: '',
        deleted_at: null
    })

    async function fetchApi() {
        loading.value = true
        error.value = null

        await axios
            .get<PermissionApi>('/api/permissions/p/' + route.params.id)
            .then((response) => {
                permission.value = response.data

                // Update Current Title
                const page = usePageMeta()
                page.title = permission.value.name
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
        () => route.params.id,
        () => {
            fetchApi()
        },
        { immediate: true }
    )

    return { permission, error, loading }
}
