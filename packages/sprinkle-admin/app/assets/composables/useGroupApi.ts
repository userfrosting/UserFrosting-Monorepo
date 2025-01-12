import { ref, watch } from 'vue'
import axios from 'axios'
import { type AlertInterface, Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { GroupResponse } from '../interfaces'
import { usePageMeta } from '@userfrosting/sprinkle-core/composables'

/**
 * API used to fetch a specific group.
 *
 * The Route object is used to watch the slug parameter. When the slug changes, the API is called.
 * TODO : The watch should be specific to the theme, and not the API.
 */
export function useGroupApi(route: any) {
    const loading = ref(false)
    const error = ref<AlertInterface | null>()
    const group = ref<GroupResponse>({
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
            .get<GroupResponse>('/api/groups/g/' + route.params.slug)
            .then((response) => {
                group.value = response.data

                // Update Current Title
                const page = usePageMeta()
                page.title = group.value.name
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
