<script setup lang="ts">
import { useRoute } from 'vue-router'
import { watch } from 'vue'
import { usePageMeta } from '@userfrosting/sprinkle-core/composables'
import { useGroupApi } from '@userfrosting/sprinkle-admin/composables'
import GroupInfo from '../../components/Pages/Admin/Group/GroupInfo.vue'
import GroupUsers from '../../components/Pages/Admin/Group/GroupUsers.vue'

/**
 * Variables and composables
 */
const route = useRoute()
const page = usePageMeta()
const { group, error, fetchGroup } = useGroupApi(() => route.params.slug)

/**
 * Watcher - Match page title to the group name
 */
watch(
    () => group.value.slug,
    () => {
        page.title = group.value.name
    },
    { immediate: true }
)
</script>

<template>
    <template v-if="error">
        <UFAlert :alert="error" />
    </template>
    <template v-else>
        <div uk-grid>
            <div class="uk-width-1-3">
                <GroupInfo :group="group" @groupUpdated="fetchGroup()" />
            </div>
            <div class="uk-width-2-3">
                <GroupUsers :slug="$route.params.slug.toString()" />
            </div>
        </div>
    </template>
</template>
